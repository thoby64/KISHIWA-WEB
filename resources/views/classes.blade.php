@extends('layouts.app')

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
            <a href="{{ route('classes') }}" class="nav-item nav-link active">Classes</a>
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

<div class="container-xxl py-5 page-header position-relative mb-5">
    <div class="container py-5">
        <h1 class="display-2 text-white animated slideInDown mb-4">Classes</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Classes</li>
            </ol>
        </nav>
    </div>
</div>

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
        <div class="mt-4">
            {{ $classes->links() }}
        </div>
    </div>
</div>
<!-- Classes End -->

<!-- Appointment Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="bg-light rounded">
            <div class="row g-0">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="h-100 d-flex flex-column justify-content-center p-5">
                        <h1 class="mb-4">Make Appointment</h1>
                        <form>
                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="gname" placeholder="Gurdian Name">
                                        <label for="gname">Gurdian Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control border-0" id="gmail" placeholder="Gurdian Email">
                                        <label for="gmail">Gurdian Email</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="cname" placeholder="Child Name">
                                        <label for="cname">Child Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="cage" placeholder="Child Age">
                                        <label for="cage">Child Age</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control border-0" placeholder="Leave a message here" id="message" style="height: 100px"></textarea>
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
<!-- Testimonial Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">What Parents Say About Us</h1>
            <p>Our students thrive in a nurturing and engaging environment. Hear from our parents and guardians about how Little Stars has impacted their children's growth and learning.</p>
        </div>
        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">
            <div class="testimonial-item bg-light rounded p-5">
                <p class="fs-5">"Little Stars Daycare and Nursery School has been amazing for my daughter. The teachers are supportive, and she has grown so much academically and socially. We feel part of a wonderful school community."</p>
                <div class="d-flex align-items-center bg-white me-n5" style="border-radius: 50px 0 0 50px;">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('img/testimonial-1.jpg') }}" style="width: 90px; height: 90px;">
                    <div class="ps-3">
                        <h3 class="mb-1">Jane Mwangi</h3>
                        <span>Parent</span>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-primary ms-auto d-none d-sm-flex"></i>
                </div>
            </div>
            <div class="testimonial-item bg-light rounded p-5">
                <p class="fs-5">"The staff at Little Stars are incredibly dedicated. My son loves attending classes, and I've seen him become more confident and curious about learning every day."</p>
                <div class="d-flex align-items-center bg-white me-n5" style="border-radius: 50px 0 0 50px;">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('img/testimonial-2.jpg') }}" style="width: 90px; height: 90px;">
                    <div class="ps-3">
                        <h3 class="mb-1">Samuel Otieno</h3>
                        <span>Parent</span>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-primary ms-auto d-none d-sm-flex"></i>
                </div>
            </div>
            <div class="testimonial-item bg-light rounded p-5">
                <p class="fs-5">"Choosing Little Stars was the best decision for our child. The teachers are patient and encouraging, and the learning environment is fun yet disciplined."</p>
                <div class="d-flex align-items-center bg-white me-n5" style="border-radius: 50px 0 0 50px;">
                    <img class="img-fluid flex-shrink-0 rounded-circle" src="{{ asset('img/testimonial-3.jpg') }}" style="width: 90px; height: 90px;">
                    <div class="ps-3">
                        <h3 class="mb-1">Grace Njeri</h3>
                        <span>Parent</span>
                    </div>
                    <i class="fa fa-quote-right fa-3x text-primary ms-auto d-none d-sm-flex"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial End -->

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