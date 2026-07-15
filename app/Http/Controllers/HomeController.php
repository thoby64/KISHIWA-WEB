<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Announcement;
use App\Models\ClassModel;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch published events with proper status check
        $events = Event::where('is_published', true)
            ->where('status', Event::STATUS_PUBLISHED)
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->limit(6)
            ->get();
            
        // Fetch published announcements
        $announcements = Announcement::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $classes = ClassModel::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('home', compact('events', 'announcements', 'classes'));
    }

    public function about()
    {
        return view('about');
    }

    public function events()
    {
        // Fetch published events with proper status check
        $events = Event::where('is_published', true)
            ->where('status', Event::STATUS_PUBLISHED)
            ->where('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->paginate(10);

        return view('events.index', compact('events'));
    }

    public function announcements()
    {
        $announcements = Announcement::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }
}