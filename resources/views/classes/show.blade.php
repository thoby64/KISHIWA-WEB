@extends('layouts.app')

@section('title', $class->name ?? 'Class')

@section('content')
<div class="container-xxl py-5 page-header position-relative mb-5">
    <div class="container py-5">
        <h1 class="display-2 text-white animated slideInDown mb-4">{{ $class->name }}</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('classes') }}">Classes</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">{{ $class->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light rounded p-4">
                    <div class="text-center mb-4">
                        <img src="{{ $class->image_url }}" alt="{{ $class->name }}" class="img-fluid rounded mb-3" style="max-height:300px; object-fit:cover;">
                        <h2 class="mb-2">{{ $class->name }}</h2>
                        <p class="text-muted">{{ $class->age_group ?? '—' }} Age Group &middot; {{ $class->schedule_time ?? '—' }}</p>
                    </div>

                    <h5>Description</h5>
                    <p>{{ $class->description }}</p>
                </div>

                    <a href="{{ route('classes') }}" class="btn btn-secondary mt-3">Back to Classes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
