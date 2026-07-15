<?php

namespace App\View\Components;

use App\Models\Event;
use Illuminate\View\Component;

class UpcomingEventsWidget extends Component
{
    public $events;
    public $limit;

    public function __construct($limit = 5)
    {
        $this->limit = $limit;
        $this->events = Event::published()
            ->upcoming()
            ->with(['category', 'creator'])
            ->limit($this->limit)
            ->get();
    }

    public function render()
    {
        return view('components.upcoming-events-widget');
    }
}
