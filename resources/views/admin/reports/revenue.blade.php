@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold leading-tight">Revenue Report</h2>
            <p class="text-gray-600">Analyze revenue trends over a selected period.</p>
        </div>

        <!-- Filters -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.reports.revenue') }}">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $startDate->toDateString() }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $endDate->toDateString() }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Group By</label>
                        <select name="grouping" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="daily" {{ $grouping == 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $grouping == 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $grouping == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="yearly" {{ $grouping == 'yearly' ? 'selected' : '' }}>Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex items-center space-x-2">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Generate Report
                    </button>
                    <a href="{{ route('admin.reports.revenue') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                        Clear Filters
                    </a>
                    <button type="submit" name="export" value="pdf" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-file-pdf mr-2"></i>Export to PDF
                    </button>
                </div>
            </form>
        </div>

        <!-- Report Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-green-500 text-white rounded-lg p-6">
                <h3 class="text-lg font-semibold">Total Revenue</h3>
                <p class="text-2xl font-bold">₹{{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="bg-blue-500 text-white rounded-lg p-6">
                <h3 class="text-lg font-semibold">Total Transactions</h3>
                <p class="text-2xl font-bold">{{ number_format($totalTransactions) }}</p>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">Revenue Over Time</h3>
            <canvas id="revenueChart"></canvas>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueData->keys()) !!},
            datasets: [{
                label: 'Total Revenue',
                data: {!! json_encode($revenueData->pluck('total_amount')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return '₹' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += '₹' + context.parsed.y.toLocaleString();
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
