@extends('layouts.reception')

@section('header', 'Edit Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-semibold mb-6">Edit Payment</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reception.payments.update', $payment) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Student:</label>
                    <input type="text" value="{{ $payment->student->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 leading-tight focus:outline-none focus:shadow-outline" disabled>
                    <input type="hidden" name="student_id" value="{{ $payment->student_id }}">
                </div>

                <!-- Course -->
                <div>
                    <label for="course_id" class="block text-gray-700 text-sm font-bold mb-2">Course:</label>
                    <select name="course_id" id="course_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $payment->course_id == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Month Number -->
                <div>
                    <label for="month_number" class="block text-gray-700 text-sm font-bold mb-2">Month Number:</label>
                    <input type="number" name="month_number" id="month_number" value="{{ $payment->month_number }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="1" max="12">
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount:</label>
                    <input type="number" name="amount" id="amount" value="{{ $payment->amount }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required step="0.01">
                </div>

                <!-- Payment Date -->
                <div>
                    <label for="payment_date" class="block text-gray-700 text-sm font-bold mb-2">Payment Date & Time:</label>
                    <input type="datetime-local" id="payment_date" value="{{ $payment_date_formatted }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 leading-tight focus:outline-none focus:shadow-outline" disabled>
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes:</label>
                    <textarea name="notes" id="notes" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $payment->notes }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-between mt-8">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Payment
                </button>
                <a href="{{ route('reception.payments.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection