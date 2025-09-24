@extends('Reception')

@section('content')
<div class="content-header">
    <h1 class="h3 mb-0 text-gray-800">Add Course</h1>
</div>

<form action="{{ route('reception.courses.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Course Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Duration</label>
        <input type="text" name="duration" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Fee</label>
        <input type="number" name="fee" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <button class="btn btn-success">Save</button>
    <a href="{{ route('reception.courses.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
