<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLogin;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        // Authorization is handled by the role:admin middleware
        $query = AuditLogin::with('user');
        
        // Add filters based on request
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('ip_address')) {
            $query->where('ip_address', 'like', '%' . $request->ip_address . '%');
        }
        
        if ($request->filled('login_type')) {
            $query->where('login_type', $request->login_type);
        }
        
        if ($request->filled('date_from')) {
            $query->where('login_time', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('login_time', '<=', $request->date_to . ' 23:59:59');
        }
        
        $auditLogs = $query->orderBy('login_time', 'desc')->paginate(20);
        
        // Get all users for the filter dropdown
        $users = User::orderBy('name')->get();
        
        return view('admin.audit.index', compact('auditLogs', 'users'));
    }

    public function userActivity($userId, Request $request)
    {
        // Authorization is handled by the role:admin middleware
        $user = User::findOrFail($userId);
        
        $query = AuditLogin::where('user_id', $userId);
        
        // Add filters based on request
        if ($request->filled('login_type')) {
            $query->where('login_type', $request->login_type);
        }
        
        if ($request->filled('date_from')) {
            $query->where('login_time', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('login_time', '<=', $request->date_to . ' 23:59:59');
        }
        
        $auditLogs = $query->orderBy('login_time', 'desc')->paginate(20);
        
        return view('admin.audit.user-activity', compact('auditLogs', 'user'));
    }

    public function deactivateUser($userId)
    {
        // Authorization is handled by the role:admin middleware
        $user = User::findOrFail($userId);
        
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot deactivate your own account.');
        }
        
        $user->update(['is_active' => false]);
        
        return redirect()->back()->with('success', 'User has been deactivated successfully.');
    }

    public function activateUser($userId)
    {
        // Authorization is handled by the role:admin middleware
        $user = User::findOrFail($userId);
        
        $user->update(['is_active' => true]);
        
        return redirect()->back()->with('success', 'User has been activated successfully.');
    }

    public function activity(Request $request)
    {
        // Authorization is handled by the role:admin middleware
        $query = ActivityLog::with('user');
        
        // Add filters based on request
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->filled('action')) {
            $query->where('action', 'like', '%' . $request->action . '%');
        }
        
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }
        
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }
        
        $activityLogs = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get all users for the filter dropdown
        $users = User::orderBy('name')->get();
        
        return view('admin.users.activity', compact('activityLogs', 'users'));
    }

    public function deleteUser($userId)
    {
        // Authorization is handled by the role:admin middleware
        $user = User::findOrFail($userId);
        
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        
        return redirect()->back()->with('success', 'User has been deleted successfully.');
    }
}