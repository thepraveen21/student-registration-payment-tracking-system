@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold leading-tight">Enrollment Summary Report</h2>
            <p class="text-gray-600">An overview of student enrollment statistics.</p>
        </div>

        <!-- Filters -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.reports.enrollment-summary') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ request('start_date') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ request('end_date') }}">
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Filter Report
                        </button>
                        <a href="{{ route('admin.reports.enrollment-summary') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                            Clear Filters
                        </a>
                        <button type="submit" name="export" value="pdf" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-file-pdf mr-2"></i>Export to PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-500 text-white rounded-lg p-6">
                <h3 class="text-lg font-semibold">Total Students</h3>
                <p class="text-2xl font-bold">{{ number_format($summary['total_students']) }}</p>
            </div>
            <div class="bg-green-500 text-white rounded-lg p-6">
                <h3 class="text-lg font-semibold">Enrollments by Course</h3>
                <p class="text-2xl font-bold">{{ $summary['by_course']->count() }} Courses</p>
            </div>
            <div class="bg-purple-500 text-white rounded-lg p-6">
                <h3 class="text-lg font-semibold">Enrollments by Month</h3>
                <p class="text-2xl font-bold">{{ $summary['by_month']->count() }} Months</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4">Enrollment by Course</h3>
                <canvas id="byCourseChart"></canvas>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4">Enrollment by Month</h3>
                <canvas id="byMonthChart"></canvas>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Enrollment by Course Chart
    const byCourseCtx = document.getElementById('byCourseChart').getContext('2d');
    const byCourseChart = new Chart(byCourseCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($summary['by_course']->keys()) !!},
            datasets: [{
                data: {!! json_encode($summary['by_course']->values()) !!},
                backgroundColor: [
                    '#4299e1', '#48bb78', '#f56565', '#ed8936', '#9f7aea', '#a0aec0'
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // Enrollment by Month Chart
    const byMonthCtx = document.getElementById('byMonthChart').getContext('2d');
    const byMonthChart = new Chart(byMonthCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($summary['by_month']->keys()) !!},
            datasets: [{
                label: 'Students',
                data: {!! json_encode($summary['by_month']->values()) !!},
                backgroundColor: '#4299e1',
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush
