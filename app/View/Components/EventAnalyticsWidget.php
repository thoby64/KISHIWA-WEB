<?php

namespace App\View\Components;

use App\Models\Event;
use App\Models\EventCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EventAnalyticsWidget extends Component
{
    public $totalEvents;
    public $publishedEvents;
    public $upcomingEvents;
    public $eventsThisMonth;
    public $categoryStats;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->totalEvents = Event::count();
        $this->publishedEvents = Event::published()->count();
        $this->upcomingEvents = Event::upcoming()->published()->count();
        $this->eventsThisMonth = Event::whereMonth('event_date', now()->month)
                                     ->whereYear('event_date', now()->year)
                                     ->count();

        // Category statistics
        $this->categoryStats = EventCategory::withCount('events')
                                          ->orderBy('events_count', 'desc')
                                          ->take(5)
                                          ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.event-analytics-widget');
    }
}
