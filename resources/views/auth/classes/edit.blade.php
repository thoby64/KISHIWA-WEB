@extends('layouts.app')

@section('title', 'Edit Class - Little Stars Daycare and Nursery School')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <h3>Edit Class</h3>

        <form action="{{ route('auth.classes.update', $class) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $class->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $class->description) }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="age_group" class="form-label">Age Group</label>
                    <input type="text" name="age_group" id="age_group" class="form-control" value="{{ old('age_group', $class->age_group) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="schedule_time" class="form-label">Schedule Time</label>
                    <input type="text" name="schedule_time" id="schedule_time" class="form-control" value="{{ old('schedule_time', $class->schedule_time) }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="image" class="form-label">Featured Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                    @if($class->hasImage())
                        <img src="{{ $class->image_url }}" class="img-thumbnail mt-2" style="max-width:200px; max-height:150px;" />
                    @endif
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label d-block">Active</label>
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $class->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Visible on site</label>
                    </div>
                </div>
            </div>

            <a href="{{ route('auth.classes.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Class</button>
        </form>
    </div>
</div>
@endsection
