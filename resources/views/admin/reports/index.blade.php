@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Advanced Reports</h1>
                <p class="mt-2 text-sm text-gray-600">Generate detailed reports and analytics for your student management system</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <div class="flex items-center space-x-3">
                    <!-- <button onclick="window.print()" 
                           class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Reports
                    </button> -->
                </div>
            </div>
        </div>

        <!-- Quick Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Total Students -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl shadow-lg p-6 transform hover:-translate-y-1 transition-transform duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-400 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium opacity-90">Total Students</p>
                        <p class="text-2xl font-bold">{{ number_format($stats['total_students']) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl shadow-lg p-6 transform hover:-translate-y-1 transition-transform duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-400 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium opacity-90">Total Revenue</p>
                        <p class="text-2xl font-bold">Rs.{{ number_format($stats['total_payments'], 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Payments -->
            <div class="bg-gradient-to-r from-yellow-500 to-amber-600 text-white rounded-xl shadow-lg p-6 transform hover:-translate-y-1 transition-transform duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-400 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium opacity-90">Pending Payments</p>
                        <p class="text-2xl font-bold">Rs.{{ number_format($stats['pending_payments'], 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Overdue Payments -->
            <div class="bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-xl shadow-lg p-6 transform hover:-translate-y-1 transition-transform duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-400 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium opacity-90">Overdue Payments</p>
                        <p class="text-2xl font-bold">Rs.{{ number_format($stats['overdue_payments'], 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Courses -->
            <div class="bg-gradient-to-r from-purple-500 to-violet-600 text-white rounded-xl shadow-lg p-6 transform hover:-translate-y-1 transition-transform duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-400 p-3 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium opacity-90">Total Courses</p>
                        <p class="text-2xl font-bold">{{ number_format($stats['total_courses']) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Categories -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Course Reports -->
            <a href="{{ route('admin.reports.course-wise-students') }}" 
               class="bg-white rounded-xl shadow-md border border-gray-200 hover:shadow-lg hover:border-blue-300 overflow-hidden transform hover:-translate-y-1 transition-all duration-200">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800">Course Reports</h3>
                            <p class="text-sm text-gray-600">Analyze student enrollment and course performance</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="text-blue-700 font-medium">Course-wise Students Report</div>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Payment Reports -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-green-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800">Payment Reports</h3>
                            <p class="text-sm text-gray-600">Financial analysis and payment tracking</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.payments.index') }}" 
                       class="flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span class="text-green-800 font-medium">Payment History</span>
                        </div>
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('admin.reports.payment-wise-students') }}" 
                       class="flex items-center justify-between p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-green-800 font-medium">Payment-wise Student Report</span>
                        </div>
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Student Reports -->
            <div class="bg-white rounded-xl shadow-md border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-purple-50 to-violet-50 border-b border-purple-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-gradient-to-r from-purple-500 to-violet-600 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-800">Student Reports</h3>
                            <p class="text-sm text-gray-600">Student demographics and performance</p>
                        </div>
                    </div>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.students.index') }}" 
                       class="flex items-center justify-between p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors duration-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 3.75l-5.5-5.5m0 0l-5.5 5.5m5.5-5.5v12"/>
                            </svg>
                            <span class="text-purple-800 font-medium">All Students List</span>
                        </div>
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Coming Soon Reports -->
        <!-- <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Coming Soon Reports</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"> -->
                <!-- Center Reports -->
                <!-- <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-xl shadow-sm border border-gray-300 overflow-hidden opacity-75">
                    <div class="px-6 py-4 border-b border-gray-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-400 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-700">Center Reports</h3>
                                <p class="text-sm text-gray-600">Center-wise performance analysis</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-300 text-gray-700">
                            Coming Soon
                        </span>
                    </div>
                </div> -->

                <!-- Monthly Reports -->
                <!-- <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-xl shadow-sm border border-gray-300 overflow-hidden opacity-75">
                    <div class="px-6 py-4 border-b border-gray-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-400 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-700">Monthly Reports</h3>
                                <p class="text-sm text-gray-600">Monthly revenue and enrollment trends</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-300 text-gray-700">
                            Coming Soon
                        </span>
                    </div>
                </div> -->

                <!-- Export Reports -->
                <!-- <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-xl shadow-sm border border-gray-300 overflow-hidden opacity-75">
                    <div class="px-6 py-4 border-b border-gray-300">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-400 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-700">Export Reports</h3>
                                <p class="text-sm text-gray-600">Export data to PDF, Excel formats</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-300 text-gray-700">
                            Coming Soon
                        </span>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        .container {
            padding: 0;
        }
        nav, button, a, .hover\:shadow-lg, .hover\:border-blue-300, 
        .transform, .hover\:-translate-y-1, .transition-all, 
        .transition-transform, .transition-colors,
        .opacity-75, .bg-gradient-to-r.from-gray-100, 
        .bg-gradient-to-r.to-gray-200 {
            display: none !important;
        }
        .bg-white, .rounded-xl, .shadow-md, .border {
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
        }
        .grid-cols-1, .md\:grid-cols-2, .lg\:grid-cols-3, 
        .sm\:grid-cols-2, .lg\:grid-cols-5 {
            display: block !important;
        }
        .bg-gradient-to-r {
            background: linear-gradient(to right, var(--tw-gradient-stops)) !important;
        }
    }
</style>
@endsection