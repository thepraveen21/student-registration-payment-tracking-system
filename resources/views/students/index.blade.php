@extends('layouts.Admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Students</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Reg. No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Student Phone</th>
                <th>Parent Phone</th>
                <th>Date of Birth</th>
                <th>Course</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->registration_number }}</td>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->student_phone }}</td>
                    <td>{{ $student->parent_phone }}</td>
                    <td>{{ $student->date_of_birth }}</td>
                    <td>{{ $student->course?->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $students->links() }}
</div>
@endsection
