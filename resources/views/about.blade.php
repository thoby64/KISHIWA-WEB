@extends('layouts.app')

@section('title', 'About Us - Little Stars Daycare and Nursery School')

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
            <a href="{{ route('about') }}" class="nav-item nav-link active">About Us</a>
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
        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-3 d-none d-lg-block">
            Staff Login<i class="fa fa-arrow-right ms-3"></i>
        </a>
    </div>
</nav>
<!-- Navbar End -->

<!-- Page Header Start -->
<div class="container-xxl py-5 page-header position-relative mb-5">
    <div class="container py-5">
        <h1 class="display-2 text-white animated slideInDown mb-4">About Us</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">About Us</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="mb-4">
                    Dedicated to Quality Education and Holistic Development
                </h1>
                <p>
                    At Little Stars Daycare and Nursery School, we are committed to providing quality education for
                    early learners and nursery school children. Our experienced teachers
                    work closely with parents to nurture academic excellence and strong character.
                </p>
                <p class="mb-4">
                    We create a supportive and disciplined learning environment that encourages
                    curiosity, creativity, critical thinking, and positive social values,
                    preparing learners for future academic success.
                </p>
                <div class="row g-4 align-items-center">
                    <div class="col-sm-6">
                        <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('contact') }}">
                            Contact Us
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle flex-shrink-0" src="{{ asset('img/user.jpg') }}" alt="" style="width: 45px; height: 45px;">
                            <div class="ms-3">
                                <h6 class="text-primary mb-1">Little Stars School</h6>
                                <small>School Administration</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 about-img wow fadeInUp" data-wow-delay="0.5s">
                <div class="row">
                    <div class="col-12 text-center">
                        <img class="img-fluid w-75 rounded-circle bg-light p-3" src="{{ asset('img/about-1.jpg') }}" alt="">
                    </div>
                    <div class="col-6 text-start" style="margin-top: -150px;">
                        <img class="img-fluid w-100 rounded-circle bg-light p-3" src="{{ asset('img/about-2.jpg') }}" alt="">
                    </div>
                    <div class="col-6 text-end" style="margin-top: -150px;">
                        <img class="img-fluid w-100 rounded-circle bg-light p-3" src="{{ asset('img/about-3.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

<!-- Call To Action Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="bg-light rounded">
            <div class="row g-0">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded" src="{{ asset('img/call-to-action.jpg') }}" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="h-100 d-flex flex-column justify-content-center p-5">
                        <h1 class="mb-4">Become a member at Little Stars</h1>
                        <p class="mb-4">
                            Join a team of dedicated members passionate about shaping young minds.
                            We value professionalism, continuous growth, and commitment to excellence
                            in early childhood education.
                        </p>
                        <a class="btn btn-primary py-3 px-5" href="{{ route('contact') }}">
                            Get Started Now<i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Call To Action End -->

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