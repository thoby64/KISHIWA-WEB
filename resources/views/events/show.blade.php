@extends('layouts.app')

@section('title', $event->title . ' - Little Stars Daycare and Nursery School')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bg-light rounded p-4">
                    <a href="{{ route('events') }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Back to Events</a>
                    <h1 class="mb-3">{{ $event->title }}</h1>

                    <div class="mb-4">
                        @if($event->hasFeaturedImage())
                            <img src="{{ $event->featured_image_url }}" alt="{{ $event->title }}" class="img-fluid rounded mb-3" style="max-height:400px; object-fit:cover; width:100%;">
                        @endif

                        <p class="text-muted">
                            <i class="fa fa-calendar-alt me-2"></i> {{ $event->event_date->format('F j, Y') }}
                            @if($event->event_time)
                                at {{ $event->event_time->format('g:i A') }}
                            @endif
                            @if($event->location)
                                &nbsp; | &nbsp; <i class="fa fa-map-marker-alt me-1"></i> {{ $event->location }}
                            @endif
                        </p>
                    </div>

                    <div class="mb-4">
                        {!! nl2br(e($event->description)) !!}
                    </div>

                    <div class="mt-4">
                        <strong>Category:</strong> {{ $event->category?->name ?? 'General' }}
                    </div>

                    @if($event->tags->isNotEmpty())
                    <div class="mt-3">
                        <strong>Tags:</strong>
                        @foreach($event->tags as $tag)
                            <span class="badge bg-secondary me-1">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
