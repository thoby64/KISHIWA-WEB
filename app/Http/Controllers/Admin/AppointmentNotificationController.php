<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AppointmentNotification;

class AppointmentNotificationController extends Controller
{
    public function index()
    {
        $notifications = AppointmentNotification::with('user')->get();
        $users = User::whereIn('role', ['admin', 'manager'])->get();
        return view('auth.admin.appointment-notifications.index', compact('notifications', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:appointment_notifications,user_id'
        ]);

        AppointmentNotification::create(['user_id' => $request->user_id]);

        return redirect()->back()->with('success', 'User added to appointment notifications.');
    }

    public function destroy($userId)
    {
        $notification = AppointmentNotification::where('user_id', $userId)->firstOrFail();
        $notification->delete();

        return redirect()->back()->with('success', 'User removed from appointment notifications.');
    }
}
