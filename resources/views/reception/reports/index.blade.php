@extends('layouts.reception')

@section('header', 'Attendance Matrix')

@section('content')
<div class="container mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold mb-4">Attendance Matrix (4 months / 16 weeks)</h1>

    {{-- Filter row --}}
    <form method="GET" class="mb-4 inline-block w-full">
        <div class="flex flex-col md:flex-row md:items-end md:space-x-4 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700">Course</label>
                <select name="course_id" class="mt-1 block w-full border rounded px-3 py-2">
                    <option value="">All courses</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:ml-auto">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            </div>
        </div>
    </form>

    {{-- Legend --}}
    <div class="flex items-center space-x-4 mb-4">
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 bg-green-500 rounded"></div><div class="text-sm">Attended (≥1 day in week)</div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 bg-red-500 rounded"></div><div class="text-sm">Absent (no days in week)</div>
        </div>
        <div class="ml-6 text-sm text-gray-600">Note: each student's course start = student registration date.</div>
    </div>

    <div class="overflow-auto border rounded bg-white shadow">
        <table class="min-w-max w-full table-auto">
            <thead>
                {{-- Top header: Student columns + 4 month groups --}}
                <tr class="bg-gray-100">
                    <th class="px-4 py-3 text-left font-semibold sticky left-0 bg-gray-100 z-10">Student</th>
                    <th class="px-4 py-3 text-left font-semibold sticky left-0 bg-gray-100 z-10">Course</th>
                    <th class="px-4 py-3 text-left font-semibold sticky left-0 bg-gray-100 z-10">Center</th>

                    @for($m = 1; $m <= 4; $m++)
                        <th colspan="4" class="px-4 py-3 text-center font-semibold border-l">
                            Month {{ $m }}
                        </th>
                    @endfor

                    <th class="px-4 py-3 text-center font-semibold border-l">Presence %</th>
                </tr>

                {{-- Second header: week labels --}}
                <tr class="bg-gray-200">
                    <th class="px-4 py-2"></th>
                    <th class="px-4 py-2"></th>
                    <th class="px-4 py-2"></th>

                    @for($w = 1; $w <= 16; $w++)
                        <th class="px-2 py-2 text-center text-xs font-medium border-l">W{{ $w }}</th>
                    @endfor

                    <th class="px-4 py-2 text-center text-xs font-medium">%</th>
                </tr>
            </thead>

            <tbody>
                @forelse($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap font-medium sticky left-0 bg-white z-0">
                            {{ $student->name }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap sticky left-0 bg-white z-0">
                            {{ $student->course->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap sticky left-0 bg-white z-0">
                            {{ $student->center->name ?? '-' }}
                        </td>

                        {{-- 16 week boxes --}}
                        @php
                            $row = $attendanceMatrix[$student->id] ?? [];
                        @endphp

                        @for($i = 0; $i < 16; $i++)
                            @php
                                $cell = $row[$i] ?? null;
                                $attended = $cell['attended'] ?? false;
                                $count = $cell['count'] ?? 0;
                                $start = isset($cell['start']) ? $cell['start']->format('Y-m-d') : '';
                                $end = isset($cell['end']) ? $cell['end']->format('Y-m-d') : '';
                                $title = $start && $end ? "Week ".($i+1).": $start → $end\nAttendances: $count" : "Week ".($i+1);
                            @endphp

                            <td class="px-2 py-3 text-center border-l">
                                <div
                                    title="{{ $title }}"
                                    class="w-6 h-6 mx-auto rounded transition-shadow"
                                    style="background-color: {{ $attended ? '#16a34a' : '#ef4444' }};">
                                </div>
                            </td>
                        @endfor

                        {{-- percent --}}
                        @php
                            $st = $stats[$student->id] ?? ['percent' => 0];
                        @endphp
                        <td class="px-4 py-3 text-center font-semibold">
                            {{ $st['percent'] ?? 0 }}%
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="20" class="px-4 py-6 text-center text-gray-500">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Monthly Payment Report -->
<div class="mt-8">
    <h2 class="text-xl font-semibold mb-4">Monthly Payment Report</h2>

    @forelse($paymentReports as $month => $payments)
        @php
            $monthLabel = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
            $monthTotal = $payments->sum('amount');
        @endphp

        <div class="mb-6 border rounded-lg overflow-hidden shadow-sm">
            <div class="bg-gray-100 px-4 py-2 font-semibold text-gray-700">
                {{ $monthLabel }}
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Student</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Center</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Payment (Rs.)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($payments as $row)
                        <tr>
                            <td class="px-4 py-2">
                                {{ $row->first_name }} {{ $row->last_name }}
                            </td>
                            <td class="px-4 py-2">
                                {{ $row->center_name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-2 text-right font-medium">
                                {{ number_format($row->amount, 2) }}
                            </td>
                        </tr>
                    @endforeach

                    <!-- Month Total -->
                    <tr class="bg-gray-50 font-semibold">
                        <td colspan="2" class="px-4 py-2 text-right">Total:</td>
                        <td class="px-4 py-2 text-right">
                            {{ number_format($monthTotal, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @empty
        <p class="text-gray-500">No monthly payments recorded yet.</p>
    @endforelse
</div>

@endsection
