@extends('layouts.app')

@section('title', 'Announcements - Little Stars Daycare and Nursery School')

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
                <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Pages</a>
                <div class="dropdown-menu rounded-0 rounded-bottom border-0 shadow-sm m-0">
                    <a href="{{ route('events.index') }}" class="dropdown-item">Events</a>
                    <a href="{{ route('announcements.index') }}" class="dropdown-item active">Announcements</a>
                    <a href="{{ route('appointment.create') }}" class="dropdown-item">Make Appointment</a>
                    <a href="{{ route('contact') }}" class="dropdown-item">Contact Us</a>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="nav-item nav-link">Contact Us</a>
        </div>
        @auth
        <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-user me-2"></i>{{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu rounded-0 rounded-bottom border-0 shadow-sm m-0">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                    <a href="{{ route('settings') }}" class="dropdown-item">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                       Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
        @else
        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a>
        @endauth
    </div>
</nav>
<!-- Navbar End -->

<!-- Page Header Start -->
<div class="container-xxl py-5 page-header position-relative mb-5">
    <div class="container py-5">
        <h1 class="display-2 text-white animated slideInDown mb-4">Announcements</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Announcements</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Announcements Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">Latest Announcements</h1>
            <p>Stay informed with our latest updates and announcements from Little Stars Daycare and Nursery School</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            @forelse($announcements as $announcement)
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-4">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle flex-shrink-0" src="{{ asset('img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                            <div class="ms-3">
                                <h6 class="fw-normal mb-1">{{ $announcement->creator->name ?? 'Little Stars Daycare and Nursery School' }}</h6>
                                <small>{{ $announcement->created_at->format('M d, Y') }}</small>
                            </div>
                        </div>
                        @if($announcement->is_urgent)
                        <span class="badge bg-danger">Urgent</span>
                        @endif
                    </div>
                    <h5 class="mb-3">{{ $announcement->title }}</h5>
                    <p class="mb-4">{{ $announcement->content }}</p>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="far fa-eye text-primary me-1"></i>
                            <small>123 Views</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="far fa-clock text-primary me-1"></i>
                            <small>{{ $announcement->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    <h4>No announcements available at the moment.</h4>
                    <p>Please check back later for updates.</p>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $announcements->links() }}
        </div>
    </div>
</div>
<!-- Announcements End -->

@endsection