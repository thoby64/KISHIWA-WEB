@extends('layouts.app')

@section('title', 'Message Details - Little Stars Daycare and Nursery School')

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
        <h1 class="display-2 text-white animated slideInDown mb-4">Message Details</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('auth.messages.index') }}">Messages</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Details</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Message Details Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="mb-0">Message from {{ $message->name }}</h3>
                        <a href="{{ route('auth.messages.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Back to Messages
                        </a>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <strong>Name:</strong> {{ $message->name }}
                        </div>
                        <div class="col-md-6">
                            <strong>Email:</strong> {{ $message->email }}
                        </div>
                        <div class="col-md-6">
                            <strong>Subject:</strong> {{ $message->subject }}
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong> 
                            @if($message->replied_at)
                                <span class="badge bg-success">Replied</span>
                            @elseif($message->is_read)
                                <span class="badge bg-warning">Read</span>
                            @else
                                <span class="badge bg-secondary">Unread</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Created:</strong> {{ $message->created_at->format('M d, Y H:i') }}
                        </div>
                        @if($message->read_at)
                        <div class="col-md-6">
                            <strong>Read At:</strong> {{ $message->read_at->format('M d, Y H:i') }}
                        </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h5>Message:</h5>
                        <div class="bg-white p-3 rounded">
                            {{ $message->message }}
                        </div>
                    </div>

                    @if($message->reply_message)
                    <div class="mb-4">
                        <h5>Your Reply:</h5>
                        <div class="bg-success text-white p-3 rounded">
                            {{ $message->reply_message }}
                        </div>
                        @if($message->replied_at)
                        <small class="text-muted">Replied on {{ $message->replied_at->format('M d, Y H:i') }} by {{ $message->replier->name }}</small>
                        @endif
                    </div>
                    @else
                    <div class="mb-4">
                        <h5>Reply to Message:</h5>
                        <form method="POST" action="{{ route('auth.messages.reply', $message) }}">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control" name="reply_message" rows="5" placeholder="Type your reply here..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-reply me-2"></i>Send Reply
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Message Details End -->

@endsection