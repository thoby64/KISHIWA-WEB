@extends('layouts.app')

@section('title', 'Home - Little Stars Daycare and Nursery School')

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
            <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
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
        <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-3 d-none d-lg-block">Staff Login<i class="fa fa-arrow-right ms-3"></i></a>
    </div>
</nav>
<!-- Navbar End -->

<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5">
    <div class="owl-carousel header-carousel position-relative">
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="{{ asset('img/carousel-1.jpg') }}" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0, 0, 0, .2);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-10 col-lg-8">
                            <h1 class="display-2 text-white animated slideInDown mb-4">
    Nurturing Excellence from Early Learning to Nursery Education
</h1>
<p class="fs-5 fw-medium text-white mb-4 pb-2">
    At Little Stars Daycare and Nursery School, we provide a strong academic foundation that inspires confidence,
    discipline, and lifelong love for learning in every child.
</p>
<a href="{{ route('about') }}" class="btn btn-primary rounded-pill py-sm-3 px-sm-5 me-3 animated slideInLeft">Learn More</a>
                            <a href="{{ route('classes') }}" class="btn btn-dark rounded-pill py-sm-3 px-sm-5 animated slideInRight">Our Classes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="{{ asset('img/carousel-2.jpg') }}" alt="">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0, 0, 0, .2);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-10 col-lg-8">
                            <h1 class="display-2 text-white animated slideInDown mb-4">
    Building Bright Futures Through Quality Education
</h1>
<p class="fs-5 fw-medium text-white mb-4 pb-2">
    At Little Stars, our holistic approach combines academic excellence, character development,
    and a supportive learning environment to help every learner succeed.
</p>
<a href="{{ route('about') }}" class="btn btn-primary rounded-pill py-sm-3 px-sm-5 me-3 animated slideInLeft">Learn More</a>
                            <a href="{{ route('classes') }}" class="btn btn-dark rounded-pill py-sm-3 px-sm-5 animated slideInRight">Our Classes</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->

<!-- Facilities Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">School Facilities</h1>
          <p>
    We provide a safe, well-equipped, and supportive school environment designed
    to enhance learning, creativity, and physical development.
</p>
 </div>
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="facility-item">
                    <div class="facility-icon bg-primary">
                        <span class="bg-primary"></span>
                        <i class="fa fa-bus-alt fa-3x text-primary"></i>
                        <span class="bg-primary"></span>
                    </div>
                    <div class="facility-text bg-primary">
                        <h3 class="text-primary mb-3">School Bus</h3>
                   <p class="mb-0">
    Safe and reliable school transport ensuring timely and secure travel for our learners.
</p>
 </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="facility-item">
                    <div class="facility-icon bg-success">
                        <span class="bg-success"></span>
                        <i class="fa fa-futbol fa-3x text-success"></i>
                        <span class="bg-success"></span>
                    </div>
                    <div class="facility-text bg-success">
                        <h3 class="text-success mb-3">Playground</h3>
                    <p class="mb-0">
    Spacious and secure playgrounds that promote physical fitness and teamwork.
</p>
</div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="facility-item">
                    <div class="facility-icon bg-warning">
                        <span class="bg-warning"></span>
                        <i class="fa fa-home fa-3x text-warning"></i>
                        <span class="bg-warning"></span>
                    </div>
                    <div class="facility-text bg-warning">
                        <h3 class="text-warning mb-3">Healthy Canteen</h3>
         <p class="mb-0">
    A strong curriculum delivered by dedicated teachers focused on academic excellence.
</p>

</div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <div class="facility-item">
                    <div class="facility-icon bg-info">
                        <span class="bg-info"></span>
                        <i class="fa fa-graduation-cap fa-3x text-info"></i>
                        <span class="bg-info"></span>
                    </div>
                    <div class="facility-text bg-info">
                        <h3 class="text-info mb-3">Quality Education</h3>
                   <p class="mb-0">
    A strong curriculum delivered by dedicated teachers focused on academic excellence.
</p>
 </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Facilities End -->

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="mb-4">
                    Committed to Academic Excellence and Character Development</h1>
                    <p>
                        Little Stars Daycare and Nursery School is a learning institution dedicated to providing quality education
                        for early learners. We focus on nurturing intellectual growth, moral values, and social responsibility.
                    </p>
                    <p class="mb-4">
                        Through a balanced curriculum, experienced educators, and a caring environment,
                        we empower our students to become confident, disciplined, and responsible citizens
                        ready to excel academically and beyond the classroom.
</p>

                    <div class="row g-4 align-items-center">
                    <div class="col-sm-6">
                        <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('about') }}">Read More</a>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle flex-shrink-0" src="{{ asset('img/user.jpg') }}" alt="" style="width: 45px; height: 45px;">
                            <div class="ms-3">
                               <h6 class="text-primary mb-1">School Administrator</h6>
                               <small>Academic Leadership</small>

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
                        <h1 class="mb-4">Join Our Community</h1>
                        <p class="mb-4">
                            Join a school community that values excellence, discipline, and holistic development.
                            We partner with parents to provide the best educational journey for every child.
</p>

                        <a class="btn btn-primary py-3 px-5" href="{{ route('contact') }}">Get Started Now<i class="fa fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Call To Action End -->

<!-- Classes Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">School Classes</h1>
            <p>Browse our available classes and find the right fit for your child.</p>
        </div>
        <div class="row g-4">
            @forelse($classes as $class)
                <div class="col-lg-4 col-md-6 wow fadeInUp">
                    <div class="classes-item">
                        <div class="bg-light rounded-circle w-75 mx-auto p-3">
                            <img class="img-fluid rounded-circle" src="{{ $class->image_url }}" alt="{{ $class->name }}">
                        </div>
                        <div class="bg-light rounded p-4 pt-5 mt-n5">
                            <a class="d-block text-center h3 mt-3 mb-4" href="{{ route('classes.show', $class->id) }}">{{ $class->name }}</a>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                            </div>
                            <div class="row g-1">
                                <div class="col-4">
                                    <div class="border-top border-3 border-primary pt-2">
                                        <h6 class="text-primary mb-1">Age:</h6>
                                        <small>{{ $class->age_group ?? '—' }}</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border-top border-3 border-success pt-2">
                                        <h6 class="text-success mb-1">Time:</h6>
                                        <small>{{ $class->schedule_time ?? '—' }}</small>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No classes available at the moment.</p>
                </div>
            @endforelse
        </div>
        <div class="text-center mt-4">
            <a class="btn btn-outline-primary" href="{{ route('classes') }}">View All Classes</a>
        </div>
    </div>
</div>
<!-- Classes End -->

<!-- Events Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">Upcoming Events</h1>
        <p>
    Stay informed about our upcoming school activities, academic events,
    and special programs designed to enrich student learning.
</p>
</div>
        <div class="row g-4">
            @forelse($events as $event)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="classes-item">
                    <div class="bg-light rounded p-4">
                        <div class="position-relative mb-3">
                            @if($event->hasFeaturedImage())
                                <img class="img-fluid w-100 rounded" src="{{ $event->featured_image_url }}" alt="{{ $event->title }}" style="height:180px; object-fit:cover;">
                            @else
                                <img class="img-fluid w-100 rounded" src="{{ asset('img/default-event.jpg') }}" alt="{{ $event->title }}" style="height:180px; object-fit:cover;">
                            @endif
                        </div>
                        <h3 class="mb-3">{{ $event->title }}</h3>
                        <p>{{ Str::limit($event->description, 100) }}</p>
                        <div class="mt-3 text-end">
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">More Info</a>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fa fa-calendar-alt me-2"></i>{{ $event->event_date->format('M d, Y') }}</span>
                            <span><i class="fa fa-clock me-2"></i>{{ $event->event_time ? $event->event_time->format('h:i A') : 'N/A' }}</span>
                        </div>
                        <div class="mt-3">
                            <span><i class="fa fa-map-marker-alt me-2"></i>{{ $event->location ?: 'TBD' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No upcoming events at the moment.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Events End -->

<!-- Announcements Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">Latest Announcements</h1>
        <p>
    Keep up to date with important school notices, updates, and official announcements.
</p>
</div>
        <div class="row g-4">
            @forelse($announcements as $announcement)
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="classes-item">
                    <div class="bg-light rounded p-4">
                        <div class="position-relative mb-3">
                            @if($announcement->hasFeaturedImage())
                                <img class="img-fluid w-100 rounded" src="{{ $announcement->featured_image_url }}" alt="{{ $announcement->title }}" style="height:180px; object-fit:cover;">
                            @else
                                <img class="img-fluid w-100 rounded" src='{{ asset("img/default.jpg") }}' alt="{{ $announcement->title }}" style="height:180px; object-fit:cover;">
                            @endif
                        </div>
                        <h3 class="mb-3">{{ $announcement->title }}</h3>
                        <p>{{ Str::limit($announcement->content, 150) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fa fa-calendar-alt me-2"></i>{{ $announcement->created_at->format('M d, Y') }}
                            </small>
                            @if($announcement->is_urgent)
                            <span class="badge bg-danger">Urgent</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>No recent announcements.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Announcements End -->

<!-- Appointment Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="bg-light rounded">
            <div class="row g-0">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="h-100 d-flex flex-column justify-content-center p-5">
                        <h1 class="mb-4">Schedule a School Visit or Consultation</h1>
                        <p>Book an appointment with our school administration to discuss admissions,
                            academic programs, or any questions about your child’s education.
                        </p>

                        <a href="{{ route('appointment.create') }}" class="btn btn-primary py-3 px-5">Book Appointment<i class="fa fa-arrow-right ms-2"></i></a>
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