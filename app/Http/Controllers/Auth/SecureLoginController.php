<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\LoginSecurityService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SecureLoginController extends Controller
{
    protected $redirectTo = '/dashboard';
    protected $loginSecurityService;

    public function __construct(LoginSecurityService $loginSecurityService)
    {
        $this->loginSecurityService = $loginSecurityService;
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        // Check rate limit
        $rateLimitCheck = $this->loginSecurityService->checkRateLimit($ipAddress);
        if (!$rateLimitCheck['allowed']) {
            throw ValidationException::withMessages([
                $this->username() => [$rateLimitCheck['message']],
            ]);
        }

        // Find user by email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            // Record failed attempt for unknown user
            $this->loginSecurityService->recordFailedLogin(
                $credentials['email'], 
                $ipAddress, 
                $userAgent,
                'User not found'
            );
            
            return false;
        }

        // Check if user is locked
        if ($this->loginSecurityService->isUserLocked($user)) {
            throw ValidationException::withMessages([
                $this->username() => ['Your account is temporarily locked due to too many failed attempts. Please try again later.'],
            ]);
        }

        // Check if user is active
        if (!$user->is_active) {
            throw ValidationException::withMessages([
                $this->username() => ['Your account has been deactivated. Please contact administrator.'],
            ]);
        }

        // Attempt to authenticate
        $result = $this->guard()->attempt($credentials, $request->filled('remember'));

        if ($result) {
            // Login successful
            $this->loginSecurityService->resetFailedAttempts($user);
            $this->loginSecurityService->recordLoginAttempt(
                $user, 
                $ipAddress, 
                $userAgent, 
                true
            );
            
            // Update user's last login info
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $ipAddress
            ]);

            return true;
        } else {
            // Login failed
            $this->loginSecurityService->handleFailedLogin($user);
            $this->loginSecurityService->recordFailedLogin(
                $credentials['email'], 
                $ipAddress, 
                $userAgent,
                'Invalid credentials'
            );
            
            return false;
        }
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return redirect($this->redirectPath());
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect('/dashboard');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function loggedOut(Request $request)
    {
        //
    }

    protected function redirectPath()
    {
        return '/dashboard';
    }

    public function showLoginForm()
    {
        // For security, we'll show a 404 for unauthorized access
        // In a real implementation, you might want to have a separate admin login
        // that's only accessible through a specific route or IP
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect back to the login form. Of course, when this user
        // surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $ipAddress = $request->ip();

        if ($user) {
            $this->loginSecurityService->recordLogout($user, $ipAddress);
        }

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    public function username()
    {
        return 'email';
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [__('auth.failed')],
        ]);
    }

    protected function incrementLoginAttempts(Request $request)
    {
        // Implementation for incrementing login attempts
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        // Implementation for checking if there are too many login attempts
        return false;
    }

    protected function fireLockoutEvent(Request $request)
    {
        // Implementation for firing lockout event
    }

    protected function sendLockoutResponse(Request $request)
    {
        // Implementation for sending lockout response
    }
}