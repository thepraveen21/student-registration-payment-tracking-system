@extends('layouts.reception')

@section('header', 'Monthly Payments')

@section('content')
<div class="container mx-auto px-4 py-8">

    <!-- PAGE HEADER -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Students Monthly Payments</h1>

        <a href="{{ route('reception.payments.create') }}"
           class="bg-green-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-green-700 transition transform hover:scale-105">
            + Record Payment
        </a>
    </div>

    <!-- SUCCESS MESSAGE -->
    @if (session('success'))
        <div class="bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm mb-6">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- =============================== -->
    <!-- SEARCH & FILTER SECTION -->
    <!-- =============================== -->
    <form method="GET"
          action="{{ route('reception.payments.index') }}"
          class="bg-white shadow-lg rounded-xl px-6 py-6 mb-10 border border-gray-200">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">Search & Filters</h2>

        <div class="grid md:grid-cols-3 gap-6">

            <!-- SEARCH STUDENT -->
            <div>
                <label class="text-sm text-gray-600 font-semibold mb-1 block">Search Student</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by name or reg no..."
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 shadow-sm" />
            </div>

            <!-- FILTER COURSE -->
            <div>
                <label class="text-sm text-gray-600 font-semibold mb-1 block">Filter by Course</label>
                <select name="course"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 shadow-sm">
                    <option value="">All Courses</option>
                    @foreach ($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- FILTER CENTER -->
            <div>
                <label class="text-sm text-gray-600 font-semibold mb-1 block">Filter by Center</label>
                <select name="center"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 shadow-sm">
                    <option value="">All Centers</option>
                    @foreach ($centers as $center)
                        <option value="{{ $center->id }}" {{ request('center') == $center->id ? 'selected' : '' }}>
                            {{ $center->name }}
                        </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="mt-6 flex justify-end">
            <button class="bg-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-blue-700 transition transform hover:scale-105">
                Apply Filters
            </button>
        </div>

    </form>

    <!-- =============================== -->
    <!-- GROUPED PAYMENT TABLE LIST -->
    <!-- =============================== -->
    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
        <h2 class="text-xl font-bold bg-gray-100 px-6 py-4 border-b text-gray-700">
            Monthly Payment Records
        </h2>

        @php
            $grouped = $monthlyPayments->groupBy(fn($i) => $i->payment_date->format('Y-m-d'));
        @endphp

        @forelse($grouped as $date => $records)

            <!-- DATE HEADER -->
            <div class="bg-blue-50 border-l-4 border-blue-500 px-6 py-4 shadow-sm">
                <h3 class="text-lg font-semibold text-blue-700 tracking-tight">
                    Payments on {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                </h3>
            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal mb-10 shadow-sm">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Reg No</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Center</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Month</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Recorded By</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Notes</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @foreach($records as $pay)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 border-b">{{ $pay->student->name }}</td>
                                <td class="px-6 py-4 border-b">{{ $pay->student->reg_no }}</td>
                                <td class="px-6 py-4 border-b">{{ $pay->course->name }}</td>
                                <td class="px-6 py-4 border-b">{{ $pay->student->center->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 border-b">Month {{ $pay->month_number }}</td>
                                <td class="px-6 py-4 border-b font-semibold text-gray-800">
                                    Rs. {{ number_format($pay->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 border-b">{{ $pay->payment_date->format('h:i A') }}</td>
                                <td class="px-6 py-4 border-b">{{ $pay->recordedBy->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 border-b">{{ $pay->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @empty
            <div class="text-center py-10 text-gray-500 text-lg">
                No monthly payments recorded yet.
            </div>
        @endforelse
    </div>
</div>
@endsection
