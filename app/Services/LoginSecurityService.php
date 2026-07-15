<?php

namespace App\Services;

use App\Models\User;
use App\Models\AuditLogin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginSecurityService
{
    private const MAX_FAILED_ATTEMPTS = 5;
    private const MAX_LOGIN_LOGOUT_COUNT = 15;
    private const LOCKOUT_TIME = 1800; // 30 minutes in seconds
    private const TIME_WINDOW = 86400; // 24 hours in seconds

    public function recordLoginAttempt($user, $ipAddress, $userAgent, $isSuccessful, $additionalInfo = null)
    {
        return AuditLogin::create([
            'user_id' => $user ? $user->id : null,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'login_type' => 'login',
            'login_time' => now(),
            'is_successful' => $isSuccessful,
            'additional_info' => $additionalInfo
        ]);
    }

    public function recordLogout($user, $ipAddress)
    {
        // Find the most recent login record for this user and IP that hasn't been logged out yet
        $recentLogin = AuditLogin::where('user_id', $user->id)
            ->where('ip_address', $ipAddress)
            ->where('login_type', 'login')
            ->whereNull('logout_time')
            ->latest('login_time')
            ->first();

        if ($recentLogin) {
            $recentLogin->update([
                'logout_time' => now(),
                'login_type' => 'logout'
            ]);
        }

        return AuditLogin::create([
            'user_id' => $user->id,
            'ip_address' => $ipAddress,
            'user_agent' => request()->userAgent(),
            'login_type' => 'logout',
            'login_time' => now(),
            'is_successful' => true
        ]);
    }

    public function recordFailedLogin($email, $ipAddress, $userAgent, $errorMessage = null)
    {
        return AuditLogin::create([
            'user_id' => null,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'login_type' => 'failed',
            'login_time' => now(),
            'is_successful' => false,
            'additional_info' => $errorMessage
        ]);
    }

    public function checkFailedAttempts($user)
    {
        if ($user->failed_login_attempts >= self::MAX_FAILED_ATTEMPTS) {
            $user->update([
                'is_active' => false,
                'locked_until' => now()->addMinutes(30)
            ]);
            
            return false;
        }
        
        return true;
    }

    public function handleFailedLogin($user)
    {
        $user->increment('failed_login_attempts');
        $user->update([
            'last_failed_login_at' => now()
        ]);
        
        if ($user->failed_login_attempts >= self::MAX_FAILED_ATTEMPTS) {
            $user->update([
                'is_active' => false,
                'locked_until' => now()->addMinutes(30)
            ]);
        }
    }

    public function resetFailedAttempts($user)
    {
        $user->update([
            'failed_login_attempts' => 0,
            'last_failed_login_at' => null,
            'locked_until' => null
        ]);
    }

    public function checkRateLimit($ipAddress)
    {
        $key = 'login_attempts:'.$ipAddress;
        
        // Check if user has exceeded login/logout attempts in the last 24 hours
        $loginLogoutCount = AuditLogin::where('ip_address', $ipAddress)
            ->whereBetween('login_time', [now()->subDay(), now()])
            ->whereIn('login_type', ['login', 'logout'])
            ->count();

        if ($loginLogoutCount >= self::MAX_LOGIN_LOGOUT_COUNT) {
            return [
                'allowed' => false,
                'message' => 'Too many login/logout attempts. Please try again later.'
            ];
        }

        return ['allowed' => true];
    }

    public function isUserLocked($user)
    {
        if ($user->locked_until && now()->lt($user->locked_until)) {
            return true;
        }
        
        // Reset failed attempts after lockout period
        if ($user->locked_until && now()->gte($user->locked_until)) {
            $this->resetFailedAttempts($user);
        }
        
        return false;
    }

    public function activateUser($user)
    {
        $user->update([
            'is_active' => true,
            'failed_login_attempts' => 0,
            'locked_until' => null
        ]);
    }
}