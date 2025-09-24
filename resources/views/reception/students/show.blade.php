@extends('layouts.reception')

@section('header', 'Student Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-semibold mb-6">Student Details</h1>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
            <p class="text-gray-800">{{ $student->name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
            <p class="text-gray-800">{{ $student->email }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Phone:</label>
            <p class="text-gray-800">{{ $student->phone }}</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('reception.students.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Back to Students
            </a>
        </div>
    </div>
</div>
@endsection