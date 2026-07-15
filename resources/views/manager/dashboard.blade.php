@extends('layouts.app')

@section('title', 'Manager Dashboard - Little Stars Daycare and Nursery School')

@section('content')
<!-- Custom Styles for Responsive Dashboard -->
<style>
@media (max-width: 768px) {
    .dashboard-card {
        margin-bottom: 1rem;
    }
    .quick-actions .btn {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    .stats-card .d-flex {
        flex-direction: column;
        text-align: center;
    }
    .stats-card .ms-3 {
        margin-left: 0 !important;
        margin-top: 0.5rem;
    }
}
@media (max-width: 576px) {
    .container-xxl {
        padding-left: 15px;
        padding-right: 15px;
    }
    .display-2 {
        font-size: 2rem;
    }
}
</style>
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
                    <a href="{{ route('appointment.create') }}" class="dropdown-item">Make Appointment</a>
                    <a href="{{ route('contact') }}" class="dropdown-item">Contact Us</a>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="nav-item nav-link">Contact Us</a>
        </div>
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
    </div>
</nav>
<!-- Navbar End -->

<!-- Page Header Start -->
<div class="container-xxl py-5 page-header position-relative mb-5">
    <div class="container py-5">
        <h1 class="display-2 text-white animated slideInDown mb-4">Manager Dashboard</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Manager Dashboard</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Manager Dashboard Content Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 col-12 wow fadeInUp dashboard-card" data-wow-delay="0.1s">
                <div class="bg-light rounded p-3 stats-card">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa fa-book fa-2x text-white"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Total Classes</p>
                            <h6>{{ $stats['total_classes'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 wow fadeInUp dashboard-card" data-wow-delay="0.3s">
                <div class="bg-light rounded p-3 stats-card">
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa fa-calendar-check fa-2x text-white"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Pending Appointments</p>
                            <h6>{{ $stats['pending_appointments'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 wow fadeInUp dashboard-card" data-wow-delay="0.5s">
                <div class="bg-light rounded p-3 stats-card">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa fa-bullhorn fa-2x text-white"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Announcements</p>
                            <h6>{{ $stats['total_announcements'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 wow fadeInUp dashboard-card" data-wow-delay="0.7s">
                <div class="bg-light rounded p-3 stats-card">
                    <div class="d-flex align-items-center">
                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa fa-calendar-alt fa-2x text-white"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Events</p>
                            <h6>{{ $stats['total_events'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Additional Statistics Row -->
        <div class="row g-4 mt-4">
            <div class="col-lg-3 col-md-6 col-12 wow fadeInUp dashboard-card" data-wow-delay="0.1s">
                <div class="bg-light rounded p-3 stats-card">
                    <div class="d-flex align-items-center">
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa fa-envelope fa-2x text-white"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Unread Messages</p>
                            <h6>{{ $stats['unread_messages'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 wow fadeInUp dashboard-card" data-wow-delay="0.3s">
                <div class="bg-light rounded p-3 stats-card">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa fa-reply fa-2x text-white"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Replied Messages</p>
                            <h6>{{ $stats['replied_messages'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 wow fadeInUp dashboard-card" data-wow-delay="0.5s">
                <div class="bg-light rounded p-3 stats-card">
                    <div class="d-flex align-items-center">
                        <div class="bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa fa-calendar-plus fa-2x text-white"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Upcoming Events</p>
                            <h6>{{ $stats['upcoming_events'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12 wow fadeInUp dashboard-card" data-wow-delay="0.7s">
                <div class="bg-light rounded p-3 stats-card">
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <i class="fa fa-check-circle fa-2x text-white"></i>
                        </div>
                        <div class="ms-3">
                            <p class="mb-2">Confirmed Appointments</p>
                            <h6>{{ $stats['confirmed_appointments'] }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Analytics and Events Section -->
        <div class="row g-4 mt-4">
            <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                <x-event-analytics-widget />
            </div>
        </div>

        <div class="row g-4 mt-4">
            <!-- Quick Actions Section - Full width on mobile, half on larger screens -->
            <div class="col-lg-6 col-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-4 quick-actions">
                    <h4 class="mb-4">Quick Actions</h4>
                    <div class="row g-2">
                        <div class="col-md-6 col-12">
                            <a href="{{ route('auth.events.index') }}" class="btn btn-primary w-100 py-3">Manage Events</a>
                        </div>
                        <div class="col-md-6 col-12">
                            <a href="{{ route('auth.announcements.index') }}" class="btn btn-success w-100 py-3">Announcements</a>
                        </div>
                        <div class="col-md-6 col-12">
                            <a href="{{ route('auth.appointments.index') }}" class="btn btn-warning w-100 py-3">Appointments</a>
                        </div>
                        <div class="col-md-6 col-12">
                            <a href="{{ route('auth.classes.index') }}" class="btn btn-info w-100 py-3">Manage Classes</a>
                        </div>
                        <div class="col-md-6 col-12">
                            <a href="{{ route('auth.messages.index') }}" class="btn btn-dark w-100 py-3">Manage Messages</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Events Section - Full width on mobile, half on larger screens -->
            <div class="col-lg-6 col-12 wow fadeInUp" data-wow-delay="0.3s">
                <x-upcoming-events-widget :events="$upcomingEvents ?? collect()" />
            </div>
        </div>
    </div>
</div>
<!-- Manager Dashboard Content End -->

<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container-fluid px-4 px-lg-5">
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
@endsection