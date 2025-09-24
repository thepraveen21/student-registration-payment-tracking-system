@extends('layouts.admin')

@section('content')
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Reports</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Financial Reports -->
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Financial Reports</h2>
                <div class="space-y-4">
                    <a href="{{ route('admin.reports.financial.revenue') }}" class="report-link-card">
                        <div class="flex items-center">
                            <div class="mr-4">
                                <i class="fas fa-chart-line text-blue-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Revenue Reports</h3>
                                <p class="text-sm text-gray-600">View monthly and annual revenue trends.</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('admin.reports.financial.payment_status') }}" class="report-link-card">
                        <div class="flex items-center">
                            <div class="mr-4">
                                <i class="fas fa-tasks text-yellow-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Payment Status Reports</h3>
                                <p class="text-sm text-gray-600">Analyze payment statuses (paid, pending, overdue).</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('admin.reports.financial.payment_method') }}" class="report-link-card">
                        <div class="flex items-center">
                            <div class="mr-4">
                                <i class="fas fa-credit-card text-green-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Payment Method Analysis</h3>
                                <p class="text-sm text-gray-600">Breakdown of payments by method.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Student Reports -->
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Student Reports</h2>
                <div class="space-y-4">
                    <a href="{{ route('admin.reports.student.enrollment_trends') }}" class="report-link-card">
                        <div class="flex items-center">
                            <div class="mr-4">
                                <i class="fas fa-user-plus text-purple-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Enrollment Trends</h3>
                                <p class="text-sm text-gray-600">Track student enrollment over time.</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('admin.reports.student.course_enrollment') }}" class="report-link-card">
                        <div class="flex items-center">
                            <div class="mr-4">
                                <i class="fas fa-book-reader text-indigo-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Course Enrollment Statistics</h3>
                                <p class="text-sm text-gray-600">See how many students are in each course.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .report-link-card {
        display: block;
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 1.5rem;
        transition: all 0.2s ease-in-out;
    }
    .report-link-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-color: #3b82f6;
    }
</style>
@endpush
