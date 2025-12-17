@extends('layouts.reception')

@section('header', 'Dashboard')
@section('title', 'Reception Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 mt-1">Here's what's happening today</p>
            </div>
            <div class="text-right">
                <p class="text-lg font-semibold text-gray-800">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        <!-- Total Students -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Total Students</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalStudents) }}</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2"><span class="text-green-600">+{{ $weeklyNewStudents }}</span> new this week</p>
        </div>

        <!-- Today's Registrations -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Today's Registrations</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $todaysRegistrations }}</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-plus text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                @if($todaysRegistrations > 0)
                    <span class="text-green-600">Active</span> registration day
                @else
                    <span class="text-gray-600">No</span> registrations yet today
                @endif
            </p>
        </div>

        <!-- QR Code Stats -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-indigo-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Available QR Codes</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ App\Models\QRCode::whereNull('student_id')->count() }}</h3>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full">
                    <i class="fas fa-qrcode text-indigo-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                <span class="text-indigo-600">{{ App\Models\QRCode::whereNotNull('student_id')->count() }}</span> assigned
            </p>
        </div>

        <!-- Pending Payments -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Pending Payments</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pendingPayments }}</h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                @if($overduePayments > 0)
                    <span class="text-red-600">{{ $overduePayments }}</span> overdue
                @else
                    <span class="text-green-600">All up to date</span>
                @endif
            </p>
        </div>

        <!-- Today's Revenue -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Today's Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rs.{{ number_format($todaysRevenue, 2) }}</h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                @php
                    $revenueChange = $yesterdaysRevenue > 0 ? (($todaysRevenue - $yesterdaysRevenue) / $yesterdaysRevenue) * 100 : 0;
                @endphp
                @if($revenueChange > 0)
                    <span class="text-green-600">+{{ number_format($revenueChange, 1) }}%</span> from yesterday
                @elseif($revenueChange < 0)
                    <span class="text-red-600">{{ number_format($revenueChange, 1) }}%</span> from yesterday
                @else
                    <span class="text-gray-600">Same as</span> yesterday
                @endif
            </p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions Card -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-3 gap-4">
                <a href="{{ route('reception.students.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-user-plus text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">New Student</span>
                </a>
                <a href="{{ route('centers.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-credit-card text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Add Center</span>
                </a>
                <a href="{{ route('reception.qrcodes.manage') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-qrcode text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Manage QR Codes</span>
                </a>
                <a href="{{ route('reception.students.index') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-list text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">View Students</span>
                </a>
                <a href="{{ route('reception.payments.index') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-receipt text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Payment History</span>
                </a>
                <a href="{{ route('reception.qrcodes.print-batch') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-print text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Print QR Codes</span>
                </a>
                <a href="{{ route('courses.create') }}" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-book text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Add Courses</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                <a href="#" class="text-sm text-primary-600 hover:text-primary-700">View All</a>
            </div>
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-{{ 
                            str_contains(strtolower($activity->action), 'student') ? 'green' : 
                            (str_contains(strtolower($activity->action), 'payment') ? 'blue' : 
                            (str_contains(strtolower($activity->action), 'update') ? 'purple' : 'gray'))
                        }}-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-{{ 
                                str_contains(strtolower($activity->action), 'student') ? 'user-plus' : 
                                (str_contains(strtolower($activity->action), 'payment') ? 'credit-card' : 
                                (str_contains(strtolower($activity->action), 'update') ? 'edit' : 'activity'))
                            }} text-{{ 
                                str_contains(strtolower($activity->action), 'student') ? 'green' : 
                                (str_contains(strtolower($activity->action), 'payment') ? 'blue' : 
                                (str_contains(strtolower($activity->action), 'update') ? 'purple' : 'gray'))
                            }}-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800">{{ $activity->action }}</p>
                            @if($activity->description)
                                <p class="text-xs text-gray-500">{{ Str::limit($activity->description, 50) }}</p>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-sm text-gray-500">No recent activities found</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Today's Schedule & Pending Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Schedule -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Today's Schedule</h3>
                <a href="{{ route('reception.schedule.index') }}" class="text-sm text-primary-600 hover:text-primary-700">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($todaySchedules as $schedule)
                    <div class="flex items-center justify-between p-3 rounded-lg 
                        {{ strtolower($schedule->status) == 'upcoming' ? 'bg-blue-50' : (strtolower($schedule->status) == 'scheduled' ? 'bg-green-50' : 'bg-gray-50') }}">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-8 rounded-full 
                                {{ strtolower($schedule->status) == 'upcoming' ? 'bg-blue-500' : (strtolower($schedule->status) == 'scheduled' ? 'bg-green-500' : 'bg-gray-400') }}"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $schedule->title }}</p>
                                <p class="text-xs text-gray-600">{{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }} - {{ $schedule->location }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ strtolower($schedule->status) == 'upcoming' ? 'bg-blue-100 text-blue-800' : (strtolower($schedule->status) == 'scheduled' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $schedule->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-500">No schedules today</p>
                @endforelse
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pending Tasks</h3>
                @php
                    $urgentTasks = 0;
                    if($overduePaymentSchedules > 0) $urgentTasks++;
                    if($studentsNeedingVerification > 0) $urgentTasks++;
                @endphp
                @if($urgentTasks > 0)
                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">{{ $urgentTasks }} Urgent</span>
                @else
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">All Clear</span>
                @endif
            </div>
            <div class="space-y-3">
                @forelse($pendingTasks as $task)
                    <div class="flex items-center justify-between p-3 border rounded-lg
                        {{ $task->priority == 'urgent' ? 'border-red-200' : ($task->priority == 'today' ? 'border-yellow-200' : 'border-blue-200') }}">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $task->title }}</p>
                            </div>
                        </div>
                        <span class="text-sm {{ $task->priority == 'urgent' ? 'text-red-600' : ($task->priority == 'today' ? 'text-yellow-600' : 'text-blue-600') }}">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-500">No pending tasks</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card { transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
</style>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Task completion
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const taskItem = this.closest('div.flex.items-center.justify-between');
            if(this.checked){
                taskItem.style.opacity='0.6';
                taskItem.style.textDecoration='line-through';
            }else{
                taskItem.style.opacity='1';
                taskItem.style.textDecoration='none';
            }
        });
    });
});
</script>
@endsection

@endsection
