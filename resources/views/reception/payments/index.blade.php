@extends('layouts.reception')

@section('header', 'Monthly Payments')
@section('title', 'Monthly Payments')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    <!-- Header Section -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Monthly Payments</h1>
                <p class="mt-1 md:mt-2 text-sm text-gray-600">View and manage student monthly payment records</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('reception.payments.create') }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Record Payment
                </a>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
    <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm" role="alert">
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

    

    <!-- Summary Stats -->
    @if($monthlyPayments->count())
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Payments</p>
                    <p class="text-xl font-bold text-gray-900">{{ $monthlyPayments->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Amount</p>
                    <p class="text-xl font-bold text-green-700">Rs. {{ number_format($monthlyPayments->sum('amount'), 2) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="bg-purple-100 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-3.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Unique Students</p>
                    <p class="text-xl font-bold text-gray-900">{{ $monthlyPayments->pluck('student_id')->unique()->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="bg-amber-100 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Date Range</p>
                    @php
                        $dates = $monthlyPayments->pluck('payment_date')->sort();
                        $firstDate = $dates->first();
                        $lastDate = $dates->last();
                    @endphp
                    <p class="text-sm font-medium text-gray-900">
                        @if($firstDate && $lastDate)
                            {{ $firstDate->format('M d') }} - {{ $lastDate->format('M d, Y') }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Filters Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Search & Filters</h3>
        
        <form method="GET" action="{{ route('reception.payments.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                        Search Student
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Search by name or reg no..."
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>
                </div>

                <!-- Course Filter -->
                <div>
                    <label for="course" class="block text-sm font-medium text-gray-700 mb-2">
                        Course
                    </label>
                    <select name="course" id="course"
                            class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="">All Courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Center Filter -->
                <div>
                    <label for="center" class="block text-sm font-medium text-gray-700 mb-2">
                        Center
                    </label>
                    <select name="center" id="center"
                            class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="">All Centers</option>
                        @foreach ($centers as $center)
                            <option value="{{ $center->id }}" {{ request('center') == $center->id ? 'selected' : '' }}>
                                {{ $center->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end mt-6 pt-6 border-t border-gray-200">
                <div class="flex space-x-3">
                    <a href="{{ route('reception.payments.index') }}" 
                       class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Clear Filters
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Payments List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Payment Records</h3>
                <p class="text-sm text-gray-600 mt-1">Grouped by payment date and time</p>
            </div>
            @if($monthlyPayments->count())
            <div class="text-sm text-gray-700">
                <span class="font-semibold">{{ $monthlyPayments->count() }}</span> records
            </div>
            @endif
        </div>

        @php
            $grouped = $monthlyPayments->groupBy(fn($i) => $i->payment_date->format('Y-m-d'));
        @endphp

        @forelse($grouped as $date => $records)
            <!-- Date Group Header - LARGER DATE/TIME ONLY -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-blue-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                    <div class="flex items-center mb-2 sm:mb-0">
                        <div class="bg-white p-2 rounded-lg shadow-sm mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <!-- LARGER DATE -->
                            <h4 class="text-xl font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                            </h4>
                            <div class="flex items-center mt-1">
                                <span class="text-sm text-gray-600">
                                    {{ count($records) }} payment{{ count($records) > 1 ? 's' : '' }} • 
                                    Total: Rs. {{ number_format($records->sum('amount'), 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium">
                            {{ $records->pluck('student_id')->unique()->count() }} students
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment Cards for this time group -->
            <div class="divide-y divide-gray-100">
                @foreach($records as $pay)
                <div class="px-6 py-5 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-4">
                        <!-- Student Info -->
                        <div class="lg:w-1/4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-100 to-indigo-200 rounded-xl flex items-center justify-center shadow-sm mr-4">
                                    <span class="text-blue-700 font-bold text-lg">
                                        {{ substr($pay->student->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900">
                                        {{ $pay->student->name }}
                                        @if($pay->updated_at->ne($pay->created_at))
                                            <span class="text-xs text-gray-500 font-normal">(edited)</span>
                                        @endif
                                    </h4>
                                    <p class="text-xs text-gray-600 mt-0.5">{{ $pay->student->reg_no }}</p>
                                    <div class="flex items-center mt-2">
                                        <svg class="w-3 h-3 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span class="text-xs text-gray-600">{{ $pay->course->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Center Info -->
                        <div class="lg:w-1/5">
                            <div class="flex items-center text-sm text-gray-700">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span>{{ $pay->student->center->name ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="lg:w-2/5">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-4 border border-green-100">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Month</p>
                                        <div class="flex items-center mt-1">
                                            <span class="text-sm font-semibold text-gray-900 bg-white px-3 py-1 rounded-lg border border-gray-200">
                                                Month {{ $pay->month_number }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</p>
                                        <p class="text-lg font-bold text-green-700 mt-1">Rs. {{ number_format($pay->amount, 2) }}</p>
                                    </div>
                                    <!-- PAYMENT TIME -->
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Time</p>
                                        <p class="text-lg font-bold text-gray-900 mt-1 flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $pay->payment_date->format('h:i A') }}
                                        </p>
                                    </div>
                                    <!-- LARGER DATE -->
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Date</p>
                                        <p class="text-lg font-bold text-gray-900 mt-1">{{ $pay->payment_date->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                @if($pay->notes)
                                <div class="mt-3 pt-3 border-t border-green-200">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Notes</p>
                                    <p class="text-xs text-gray-700 bg-white px-3 py-2 rounded border border-gray-200">{{ $pay->notes }}</p>
                                </div>
                                @endif
                                @if($pay->updated_at->ne($pay->created_at))
                                <div class="mt-3 pt-3 border-t border-green-200">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Last Edited</p>
                                    <p class="text-xs text-gray-700">{{ $pay->updated_at->format('M d, Y, h:i A') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Recorded By -->
                        <div class="lg:w-1/5">
                            <div class="text-right">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Recorded By</p>
                                <p class="text-sm font-medium text-gray-900 mt-1">{{ $pay->recordedBy->name ?? 'N/A' }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">via Reception</p>
                                <div class="mt-4 flex justify-end space-x-2">
                                    <a href="{{ route('reception.payments.edit', $pay) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('reception.payments.destroy', $pay) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @empty
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mb-4">
                    <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Payment Records</h3>
                <p class="text-sm text-gray-600 mb-6 max-w-md mx-auto">
                    No monthly payments have been recorded yet. Start by recording a new payment.
                </p>
                <a href="{{ route('reception.payments.create') }}" 
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Record First Payment
                </a>
            </div>
        @endforelse

        @if($monthlyPayments->count())
            <!-- Stats Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-semibold">{{ $monthlyPayments->count() }}</span> payment records • 
                    Total Amount: <span class="font-semibold text-green-700">Rs. {{ number_format($monthlyPayments->sum('amount'), 2) }}</span>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection