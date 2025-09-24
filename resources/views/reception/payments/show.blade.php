@extends('layouts.reception')

@section('header', 'Payment Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-semibold mb-6">Payment Details</h1>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Student:</label>
            <p class="text-gray-800">{{ $payment->student->name }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Amount:</label>
            <p class="text-gray-800">{{ $payment->amount }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
            <p class="text-gray-800">{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : 'N/A' }}</p>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Payment Method:</label>
            <p class="text-gray-800">{{ $payment->payment_method }}</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('reception.payments.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Back to Payments
            </a>
        </div>
    </div>
</div>
@endsection