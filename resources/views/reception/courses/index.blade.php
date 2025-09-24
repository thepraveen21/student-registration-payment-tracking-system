@extends('Reception')

@section('content')
<div class="content-header">
    <h1 class="h3 mb-0 text-gray-800">Manage Courses</h1>
    <a href="{{ route('reception.courses.create') }}" class="btn btn-primary float-end">
        <i class="fas fa-plus"></i> Add New Course
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

<div class="card mt-4">
    <div class="card-header">Courses List</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Duration</th>
                    <th>Fee</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($courses as $course)
                <tr>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->duration }}</td>
                    <td>${{ number_format($course->fee, 2) }}</td>
                    <td>{{ $course->description }}</td>
                    <td>
                        <a href="{{ route('reception.courses.edit', $course) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('reception.courses.destroy', $course) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this course?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No courses found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
