@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Payment Details</h1>
                <p class="mt-2 text-sm text-gray-600">View payment information and details</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-100 to-emerald-100 rounded-lg border border-green-200">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-medium text-green-800">
                        Receipt #{{ $payment->receipt_number ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
        <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Payment Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden mb-8">
            <!-- Card Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Payment Information</h2>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $payment->status == 'completed' ? 'bg-green-100 text-green-800' : ($payment->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        @if($payment->status == 'completed')
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($payment->status == 'pending')
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
            </div>

            <!-- Amount Display -->
            <div class="px-6 py-8 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-green-100">
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-600">Total Amount</p>
                    <p class="mt-2 text-3xl md:text-4xl font-bold text-green-700">Rs. {{ number_format($payment->amount, 2) }}</p>
                    <p class="mt-1 text-sm text-gray-500">Paid on {{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}</p>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Student Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Student Information
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Student Name</p>
                                <p class="mt-1 text-base text-gray-900 font-medium">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</p>
                            </div>
                            @if($payment->student->registration_number)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Registration Number</p>
                                <p class="mt-1 text-base text-gray-900">{{ $payment->student->registration_number }}</p>
                            </div>
                            @endif
                            @if($payment->student->email)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Email Address</p>
                                <p class="mt-1 text-base text-gray-900">{{ $payment->student->email }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b border-gray-200 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Payment Details
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Payment Method</p>
                                @php
                                    $methodColors = [
                                        'cash' => 'bg-green-100 text-green-800 border border-green-200',
                                        'card' => 'bg-blue-100 text-blue-800 border border-blue-200',
                                        'bank_transfer' => 'bg-purple-100 text-purple-800 border border-purple-200',
                                        'check' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                        'online' => 'bg-indigo-100 text-indigo-800 border border-indigo-200'
                                    ];
                                    $color = $methodColors[$payment->payment_method] ?? 'bg-gray-100 text-gray-800 border border-gray-200';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-1 {{ $color }}">
                                    @switch($payment->payment_method)
                                        @case('cash')
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                            @break
                                        @case('card')
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                            </svg>
                                            @break
                                        @case('bank_transfer')
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                            </svg>
                                            @break
                                        @default
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                    @endswitch
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                </span>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-500">Payment Date</p>
                                <p class="mt-1 text-base text-gray-900">{{ \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') }}</p>
                            </div>

                            @if($payment->receipt_number)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Receipt Number</p>
                                <p class="mt-1 text-base text-gray-900 font-mono">{{ $payment->receipt_number }}</p>
                            </div>
                            @endif

                            @if($payment->notes)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Notes</p>
                                <p class="mt-1 text-base text-gray-900">{{ $payment->notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <a href="{{ route('admin.payments.index') }}" 
                               class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Back to Payments
                            </a>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.payments.edit', $payment->id) }}" 
                               class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Payment
                            </a>
                            <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this payment?')"
                                        class="inline-flex items-center px-4 py-2.5 border border-red-300 text-red-700 bg-white hover:bg-red-50 rounded-lg font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information Card -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Additional Information</h2>
            </div>
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Created On</p>
                        <p class="mt-1 text-base text-gray-900">{{ $payment->created_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Last Updated</p>
                        <p class="mt-1 text-base text-gray-900">{{ $payment->updated_at->format('F d, Y \a\t h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection