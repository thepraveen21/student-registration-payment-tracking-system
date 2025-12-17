@extends('layouts.admin')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Total Students</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalStudents }}</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-graduate text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Active Students</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $activeStudents }}</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Overdue Payments</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $overduePayments }}</h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-red-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Monthly Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rs.{{ number_format($monthlyRevenue, 2) }}</h3>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-dollar-sign text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="chart-container bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Payment Trends</h3>
            <canvas id="paymentChart" height="250"></canvas>
        </div>

        <div class="chart-container bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Course Distribution</h3>
            <canvas id="courseChart" height="250"></canvas>
        </div>
    </div>

 <!-- Newly Added Students -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Newly Added Students</h3>
            <p class="text-sm text-gray-500 mt-1">Recently registered students in the system</p>
        </div>
        <div class="bg-blue-50 text-blue-600 text-xs font-medium px-3 py-1 rounded-full">
            {{ count($recentStudents) }} new
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/60 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Student</th>
                    <th class="px-6 py-3">Course</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Joined</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($recentStudents as $student)
                    <tr class="group hover:bg-blue-50/30 transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center shadow-sm">
                                    <span class="text-blue-700 font-semibold">{{ substr($student->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">{{ $student->name }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $student->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-book-open mr-1.5 text-xs"></i>
                                {{ $student->course->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span>
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $student->created_at->format('d M, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $student->created_at->diffForHumans() }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if(count($recentStudents) === 0)
        <div class="text-center py-8">
            <div class="text-gray-400 mb-2">
                <i class="fas fa-user-graduate text-3xl"></i>
            </div>
            <p class="text-gray-500">No new students added recently</p>
        </div>
    @endif
</div>

<!-- Recent Payments -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-semibold text-gray-800">Recent Monthly Payments</h3>
            <p class="text-sm text-gray-500 mt-1">Latest monthly payment transactions</p>
        </div>
        <div class="bg-green-50 text-green-600 text-xs font-medium px-3 py-1 rounded-full">
            {{ count($recentPayments) }} payments
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50/60 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3">Student</th>
                    <th class="px-6 py-3">Course</th>
                    <th class="px-6 py-3">Month</th>
                    <th class="px-6 py-3">Amount</th>
                    <th class="px-6 py-3">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($recentPayments as $payment)
                    <tr class="group hover:bg-green-50/30 transition-all duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-green-100 to-emerald-200 rounded-full flex items-center justify-center shadow-sm">
                                    <span class="text-green-700 font-semibold">{{ substr($payment->student->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $payment->student->full_name }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $payment->student->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-book-open mr-1.5 text-xs"></i>
                                {{ $payment->course->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Month {{ $payment->month_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-lg font-bold text-green-700">Rs.{{ number_format($payment->amount, 2) }}</div>
                            <div class="text-xs text-gray-500">Recorded</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $payment->payment_date->format('d M, Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $payment->payment_date->diffForHumans() }}</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if(count($recentPayments) === 0)
        <div class="text-center py-8">
            <div class="text-gray-400 mb-2">
                <i class="fas fa-credit-card text-3xl"></i>
            </div>
            <p class="text-gray-500">No recent monthly payments found</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
    <script>
        // Payment Trends Chart
        const paymentCtx = document.getElementById('paymentChart').getContext('2d');
        const paymentChart = new Chart(paymentCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($paymentChartData->keys()) !!},
                datasets: [{
                    label: 'Payments Received',
                    data: {!! json_encode($paymentChartData->values()) !!},
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Course Distribution Chart
        const courseCtx = document.getElementById('courseChart').getContext('2d');
        const courseChart = new Chart(courseCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($courseChartData->keys()) !!},
                datasets: [{
                    data: {!! json_encode($courseChartData->values()) !!},
                    backgroundColor: [
                        '#0ea5e9',
                        '#3b82f6',
                        '#6366f1',
                        '#8b5cf6',
                        '#a855f7'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    </script>
@endpush