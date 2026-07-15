@props(['events'])

<div class="card h-100">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">
            <i class="fa fa-calendar-check me-2"></i>Upcoming Events
        </h5>
    </div>
    <div class="card-body p-0">
        @if($events->isEmpty())
            <div class="p-4 text-center text-muted">
                <i class="fa fa-inbox fa-3x mb-3"></i>
                <p>No upcoming events</p>
            </div>
        @else
            <div class="event-list">
                @foreach($events as $event)
                    <div class="event-item p-3 border-bottom">
                        <div class="d-flex align-items-start mb-2">
                            @if($event->hasFeaturedImage())
                                <img src="{{ $event->featured_image_url }}" alt="{{ $event->title }}" class="me-3 rounded" style="width: 60px; height: 45px; object-fit: cover;">
                            @else
                                <div class="me-3 bg-light border rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 45px;">
                                    <i class="fa fa-calendar text-muted"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $event->title }}</h6>
                                        @if($event->category)
                                            <span class="badge" style="background-color: {{ $event->category->color ?? '#6c757d' }}">
                                                {{ $event->category->name }}
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('auth.events.edit', $event) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </div>
                        
                        <div class="small text-muted">
                            <div class="mb-1">
                                <i class="fa fa-calendar me-2"></i>{{ $event->event_date->format('M d, Y') }}
                                @if($event->event_time)
                                    <i class="fa fa-clock ms-2 me-2"></i>{{ $event->event_time->format('h:i A') }}
                                @endif
                            </div>
                            @if($event->location)
                                <div class="mb-1">
                                    <i class="fa fa-map-marker me-2"></i>{{ $event->location }}
                                </div>
                            @endif
                        </div>
                    </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <div class="card-footer bg-light">
        <a href="{{ route('auth.events.index') }}" class="btn btn-sm btn-primary w-100">
            <i class="fa fa-arrow-right me-2"></i>View All Events
        </a>
    </div>
</div>
