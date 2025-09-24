@extends('Reception')

@section('content')
<div class="content-header">
    <h1 class="h3 mb-0 text-gray-800">Edit Course</h1>
</div>

<form action="{{ route('reception.courses.update', $course) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Course Name</label>
        <input type="text" name="name" class="form-control" value="{{ $course->name }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Duration</label>
        <input type="text" name="duration" class="form-control" value="{{ $course->duration }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Fee</label>
        <input type="number" name="fee" class="form-control" value="{{ $course->fee }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ $course->description }}</textarea>
    </div>

    <button class="btn btn-primary">Update</button>
    <a href="{{ route('reception.courses.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
