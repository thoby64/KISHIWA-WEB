@extends('layouts.app')

@section('title', 'Make Appointment - Little Stars Daycare and Nursery School')

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
                    <a href="{{ route('appointment.create') }}" class="dropdown-item active">Make Appointment</a>
                    <a href="{{ route('contact') }}" class="dropdown-item">Contact Us</a>
                </div>
            </div>
            <a href="{{ route('contact') }}" class="nav-item nav-link">Contact Us</a>
        </div>
        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-3 d-none d-lg-block">Staff Login<i class="fa fa-arrow-right ms-3"></i></a>
    </div>
</nav>
<!-- Navbar End -->

<!-- Page Header Start -->
<div class="container-xxl py-5 page-header position-relative mb-5">
    <div class="container py-5">
        <h1 class="display-2 text-white animated slideInDown mb-4">Appointment</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Appointment</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Appointment Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="bg-light rounded">
            <div class="row g-0">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="h-100 d-flex flex-column justify-content-center p-5">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h1 class="mb-4">Make Appointment</h1>
                        <p>Book an appointment with our school administration to discuss enrollment, programs, or any other inquiries.</p>
                        <form method="POST" action="{{ route('appointment.store') }}">
                            @csrf
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="gname" name="guardian_name" placeholder="Guardian Name" required>
                                        <label for="gname">Guardian Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control border-0" id="gmail" name="guardian_email" placeholder="Guardian Email" required>
                                        <label for="gmail">Guardian Email</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="cname" name="child_name" placeholder="Child Name" required>
                                        <label for="cname">Child Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="cage" name="child_age" placeholder="Child Age" required>
                                        <label for="cage">Child Age</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control border-0" placeholder="Leave a message here" id="message" name="message" style="height: 100px"></textarea>
                                        <label for="message">Message</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded" src="{{ asset('img/appointment.jpg') }}" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Appointment End -->


<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
    <style>
        .footer a,.footer p,.footer .btn-social{transition: all 0.3s ease;}
        .footer .btn-link:hover{color:#ffffff;transform:translateX(6px);}
        .footer .btn-social{width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;}
        .footer .btn-social:hover{background-color:#ffffff;color:#0d6efd;transform:translateY(-5px) scale(1.1);box-shadow:0 8px 20px rgba(255,255,255,0.25);}
        .footer p:hover{color:#ffffff;transform:translateX(5px);}
        .footer-menu a:hover{color:#ffffff;text-decoration:underline;}
        @media (hover:none){.footer a:hover,.footer p:hover,.footer .btn-social:hover{transform:none;}}
    </style>

    <div class="container-fluid px-lg-5">
        <div class="row gy-5">

            <!-- Get In Touch -->
            <div class="col-xl-4 col-lg-4 col-md-12 text-center text-lg-start">
                <h3 class="text-white mb-4">Get In Touch</h3>
                <p class="mb-3"><i class="fa fa-map-marker-alt me-3"></i>Little Stars Daycare and Nursery School</p>
                <p class="mb-3"><i class="fa fa-phone-alt me-3"></i>0786617048</p>
                <p class="mb-4"><i class="fa fa-envelope me-3"></i>littlestarsdaycarenurseryschoo@gmail.com</p>

                <div class="d-flex justify-content-center justify-content-lg-start gap-2">
                    <a class="btn btn-outline-light btn-social rounded-circle" href="https://www.instagram.com/littlestarsdaycarenurseryschool" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social rounded-circle" href="https://www.facebook.com/Littlestarsdaycare.Nurseryschool" target="_blank"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-xl-3 col-lg-4 col-md-12 text-center text-lg-start">
                <h3 class="text-white mb-4">Quick Links</h3>
                <a class="btn btn-link text-white-50 d-block" href="{{ route('home') }}">Home</a>
                <a class="btn btn-link text-white-50 d-block" href="{{ route('about') }}">About Us</a>
                <a class="btn btn-link text-white-50 d-block" href="{{ route('classes') }}">Classes</a>
                <a class="btn btn-link text-white-50 d-block" href="{{ route('contact') }}">Contact Us</a>
            </div>

            <!-- School Motto -->
            <div class="col-xl-5 col-lg-4 col-md-12 text-center text-lg-start">
                <h3 class="text-white mb-4">School Motto</h3>
                <p class="fst-italic mb-3">"Refining knowledge And Character"</p>
                <p>We are committed to nurturing responsible, confident, and lifelong learners through quality education and strong moral values.</p>
            </div>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="container-fluid border-top border-secondary mt-5 pt-4 px-lg-5">
        <div class="row">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                &copy; <a class="border-bottom text-white" href="#">Little Stars Daycare and Nursery School</a>, All Rights Reserved.
            </div>
            <div class="col-md-6 text-center text-md-end footer-menu">
                <a href="{{ route('home') }}" class="me-3">Home</a>
                <a href="{{ route('about') }}" class="me-3">Privacy</a>
                <a href="{{ route('contact') }}" class="me-3">Terms</a>
                <a href="{{ route('contact') }}">FAQs</a>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

@endsection