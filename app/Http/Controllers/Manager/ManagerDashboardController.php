<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\ClassModel;
use App\Models\Appointment;
use App\Models\Announcement;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ManagerDashboardController extends Controller
{
    public function index()
    {
        // Get upcoming events for the widget
        $upcomingEvents = Event::with('category')
            ->upcoming()
            ->published()
            ->orderBy('event_date', 'asc')
            ->take(5)
            ->get();

        // Summary statistics
        $stats = [
            'total_classes' => ClassModel::count(),
            'active_classes' => ClassModel::where('is_active', true)->count(),
            'pending_appointments' => Appointment::where('is_confirmed', false)->count(),
            'confirmed_appointments' => Appointment::where('is_confirmed', true)->count(),
            'total_announcements' => Announcement::count(),
            'published_announcements' => Announcement::where('is_published', true)->count(),
            'total_events' => Event::count(),
            'published_events' => Event::where('status', 'published')->count(),
            'upcoming_events' => Event::upcoming()->published()->count(),
            'total_messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
            'replied_messages' => ContactMessage::whereNotNull('replied_at')->count(),
        ];

        return view('manager.dashboard', compact('upcomingEvents', 'stats'));
    }
}