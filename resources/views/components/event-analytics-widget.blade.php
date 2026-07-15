<div class="card h-100">
    <div class="card-header bg-info text-white">
        <h5 class="card-title mb-0">
            <i class="fa fa-chart-bar me-2"></i>Event Analytics
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-6">
                <div class="text-center">
                    <div class="h4 mb-0 text-primary">{{ $totalEvents }}</div>
                    <small class="text-muted">Total Events</small>
                </div>
            </div>
            <div class="col-6">
                <div class="text-center">
                    <div class="h4 mb-0 text-success">{{ $publishedEvents }}</div>
                    <small class="text-muted">Published</small>
                </div>
            </div>
            <div class="col-6">
                <div class="text-center">
                    <div class="h4 mb-0 text-warning">{{ $upcomingEvents }}</div>
                    <small class="text-muted">Upcoming</small>
                </div>
            </div>
            <div class="col-6">
                <div class="text-center">
                    <div class="h4 mb-0 text-info">{{ $eventsThisMonth }}</div>
                    <small class="text-muted">This Month</small>
                </div>
            </div>
        </div>

        @if($categoryStats->count() > 0)
            <hr>
            <h6 class="mb-2">Events by Category</h6>
            <div class="small">
                @foreach($categoryStats as $category)
                    <div class="d-flex justify-content-between mb-1">
                        <span>{{ $category->name }}</span>
                        <span class="badge bg-secondary">{{ $category->events_count }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>