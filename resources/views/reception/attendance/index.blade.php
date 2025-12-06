@extends('layouts.reception')

@section('header', 'Attendance Records')

@section('content')
<div class="container mx-auto px-4 py-8">

    <div class="bg-white shadow-md rounded-lg p-8">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Attendance Overview</h1>
                <p class="text-gray-500 text-sm">Today: {{ now()->format('M d, Y') }}</p>
            </div>

            <a href="{{ route('reception.attendance.scan') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <i class="fas fa-qrcode mr-2"></i>
                Scan QR Code
            </a>
        </div>

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">Present Today</p>
                <p class="text-3xl font-bold text-gray-800">{{ $todayCount ?? 0 }}</p>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">Courses Today</p>
                <p class="text-3xl font-bold text-gray-800">{{ $uniqueCourses ?? 0 }}</p>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">Last Scan</p>
                <p class="text-xl font-semibold text-gray-800">
                    {{ $latestAttendance ? $latestAttendance->attended_at->format('h:i A') : '—' }}
                </p>
            </div>

        </div>

        {{-- FILTERS --}}
        <form method="GET" action="{{ route('reception.attendance.index') }}" class="mb-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- SEARCH --}}
                <input 
                    type="text" 
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search student name or ID"
                    class="border rounded-lg px-3 py-2 w-full"
                >

                {{-- COURSE FILTER --}}
                <select name="course" class="border rounded-lg px-3 py-2 w-full">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>

                {{-- DATE FILTER --}}
                <input 
                    type="date" 
                    name="date" 
                    value="{{ request('date') }}"
                    class="border rounded-lg px-3 py-2 w-full"
                >

                {{-- RESET --}}
                <a href="{{ route('reception.attendance.index') }}" 
                   class="border px-3 py-2 rounded-lg text-center hover:bg-gray-100">
                    Reset
                </a>
            </div>

            {{-- FILTER SUBMIT BUTTON --}}
            <div class="mt-4">
                <button 
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg">
                    Apply Filters
                </button>
            </div>

        </form>

        {{-- ATTENDANCE TABLE --}}
        <div class="overflow-x-auto">

            @if($attendances && count($attendances) > 0)

                @foreach($attendances as $date => $records)

                    <div class="mb-6 border rounded-lg overflow-hidden shadow">
                        
                        <div class="bg-blue-600 text-white px-4 py-2 text-lg font-semibold">
                            {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                        </div>

                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Student ID</th>
                                    <th class="py-2 px-4 border-b">Name</th>
                                    <th class="py-2 px-4 border-b">Phone</th>
                                    <th class="py-2 px-4 border-b">Course</th>
                                    <th class="py-2 px-4 border-b">Time</th>
                                    <th class="py-2 px-4 border-b">Payment Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($records as $attendance)
                                    <tr>
                                        <td class="py-2 px-4 border-b">{{ $attendance->student->registration_number }}</td>
                                        <td class="py-2 px-4 border-b">{{ $attendance->student->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $attendance->student->student_phone }}</td>
                                        <td class="py-2 px-4 border-b">{{ $attendance->student->course->name }}</td>
                                        <td class="py-2 px-4 border-b">{{ $attendance->attended_at->format('h:i A') }}</td>
                                        <td class="py-2 px-4 border-b">
                                            @php
                                                $courseFee = $attendance->student->course->fee ?? 0;

                                                // Total paid by this student
                                                $totalPaid = $attendance->student->payments->sum('amount');

                                                // Determine status
                                                $isPaid = $totalPaid >= $courseFee;
                                            @endphp

                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $isPaid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $isPaid ? 'Paid' : 'Unpaid' }}
                                            </span>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                @endforeach

            @else
                <p class="text-center py-4">No attendance records found.</p>
            @endif

        </div>


        {{-- PAGINATION --}}
        @if(isset($attendances))
        <div class="mt-4">
            {{ $attendances->appends(request()->query())->links() }}
        </div>
        @endif

    </div>
</div>
@endsection
