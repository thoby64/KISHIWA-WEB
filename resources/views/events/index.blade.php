@extends('layouts.app')

@section('title', 'Events - Little Stars Daycare and Nursery School')

@section('content')
<!-- Spinner Start -->
<div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<!-- Spinner End -->

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0">
    <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
        <img src="{{ asset('img/logo/littlestar.PNG') }}" alt="Little Stars Logo" style="height: 50px; margin-right: 10px;">
        <h1 class="m-0 text-primary" style="font-size: 1.2rem;">LITTLE STARS DAYCARE AND NURSERY SCHOOL</h1>
    </a>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav mx-auto">
            <a href="{{ route('home') }}" class="nav-item nav-link">Home</a>
            <a href="{{ route('about') }}" class="nav-item nav-link">About Us</a>
            <a href="{{ route('classes') }}" class="nav-item nav-link">Classes</a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu rounded-0 rounded-bottom border-0 shadow-sm m-0">
                    <a href="{{ route('appointment.create') }}" class="dropdown-item">Make Appointment</a>
                    <a href="{{ route('contact') }}" class="dropdown-item">Contact Us</a>
                </div>
            </div>
            <a href="{{ route('events') }}" class="nav-item nav-link active">Events</a>
            <a href="{{ route('contact') }}" class="nav-item nav-link">Contact Us</a>
        </div>
        <div class="navbar-nav ms-auto">
            <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
        </div>
    </div>
</nav>
<!-- Navbar End -->

<!-- Page Header Start -->
<div class="container-xxl py-5 page-header position-relative mb-5">
    <div class="container py-5">
        <h1 class="display-2 text-white animated slideInDown mb-4">School Events</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Events</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Events Start -->
<div class="container-xxl py-5">
    <div class="container">
        <!-- Search and Filter Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <form method="GET" action="{{ route('events') }}" class="row g-3">
                        <div class="col-md-6">
                            <label for="search" class="form-label">Search Events</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   placeholder="Search by title, description..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="category" class="form-label">Filter by Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search me-2"></i>Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Events Grid -->
        <div class="row g-4">
            @forelse($events as $event)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-light rounded overflow-hidden">
                        <div class="position-relative">
                            @if($event->hasFeaturedImage())
                                <img class="img-fluid w-100" src="{{ $event->featured_image_url }}" alt="{{ $event->title }}" style="height: 250px; object-fit: cover;">
                            @else
                                <img class="img-fluid w-100" src="{{ asset('img/default-event.jpg') }}" alt="{{ $event->title }}" style="height: 250px; object-fit: cover;">
                            @endif
                            @if($event->category)
                                <div class="bg-primary text-white px-3 py-1 position-absolute top-0 end-0 m-2 rounded">
                                    {{ $event->category->name }}
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h5 class="mb-3">{{ $event->title }}</h5>
                            <p class="mb-3">{{ Str::limit($event->description, 100) }}</p>

                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fa fa-calendar text-primary me-2"></i>
                                    <span>{{ $event->event_date->format('F d, Y') }}</span>
                                </div>
                                @if($event->event_time)
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fa fa-clock text-primary me-2"></i>
                                        <span>{{ $event->event_time->format('h:i A') }}</span>
                                    </div>
                                @endif
                                @if($event->location)
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-map-marker text-primary me-2"></i>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                @endif
                            </div>

                            @if($event->tags->count() > 0)
                                <div class="mb-3">
                                    @foreach($event->tags->take(3) as $tag)
                                        <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                                    @endforeach
                                    @if($event->tags->count() > 3)
                                        <span class="badge bg-light text-dark">+{{ $event->tags->count() - 3 }} more</span>
                                    @endif
                                </div>
                            @endif
                            <div class="d-flex justify-content-end mt-2">
                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">More Info</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fa fa-calendar fa-4x text-muted mb-4"></i>
                        <h3 class="text-muted">No Events Found</h3>
                        <p class="text-muted">There are currently no published events. Please check back later.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($events->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>
<!-- Events End -->

<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">Little Stars Daycare and Nursery School</a>, All Right Reserved.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('about') }}">Privacy</a>
                        <a href="{{ route('contact') }}">Terms</a>
                        <a href="{{ route('contact') }}">FAQs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- JavaScript for enhanced functionality -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide spinner after page load
    const spinner = document.getElementById('spinner');
    if (spinner) {
        setTimeout(() => {
            spinner.classList.remove('show');
        }, 1000);
    }
});
</script>
@endsection