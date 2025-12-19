@extends('layouts.reception')

@section('header', 'Dashboard')
@section('title', 'Reception Dashboard')

@section('content')
<div class="space-y-4 md:space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white shadow-sm rounded-lg p-4 md:p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-3 md:mb-0">
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 mt-1 text-xs md:text-sm">Here's what's happening today</p>
            </div>
            <div class="text-left md:text-right">
                <p class="text-base md:text-lg font-semibold text-gray-800">{{ now()->format('l, F j, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3 md:gap-4 lg:gap-6">
        <!-- Total Students -->
        <div class="stat-card bg-white rounded-lg p-4 md:p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs md:text-sm text-gray-600">Total Students</p>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800">{{ number_format($totalStudents) }}</h3>
                </div>
                <div class="bg-blue-100 p-2 md:p-3 rounded-full flex-shrink-0">
                    <i class="fas fa-user-graduate text-blue-600 text-lg md:text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1 md:mt-2"><span class="text-green-600">+{{ $weeklyNewStudents }}</span> new this week</p>
        </div>

        <!-- Today's Registrations -->
        <div class="stat-card bg-white rounded-lg p-4 md:p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs md:text-sm text-gray-600">Today's Registrations</p>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800">{{ $todaysRegistrations }}</h3>
                </div>
                <div class="bg-green-100 p-2 md:p-3 rounded-full flex-shrink-0">
                    <i class="fas fa-user-plus text-green-600 text-lg md:text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1 md:mt-2">
                @if($todaysRegistrations > 0)
                    <span class="text-green-600">Active</span> registration day
                @else
                    <span class="text-gray-600">No</span> registrations yet today
                @endif
            </p>
        </div>

        <!-- QR Code Stats -->
        <div class="stat-card bg-white rounded-lg p-4 md:p-6 border-l-4 border-indigo-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs md:text-sm text-gray-600">Available QR Codes</p>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800">{{ App\Models\QRCode::whereNull('student_id')->count() }}</h3>
                </div>
                <div class="bg-indigo-100 p-2 md:p-3 rounded-full flex-shrink-0">
                    <i class="fas fa-qrcode text-indigo-600 text-lg md:text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1 md:mt-2">
                <span class="text-indigo-600">{{ App\Models\QRCode::whereNotNull('student_id')->count() }}</span> assigned
            </p>
        </div>

        <!-- Pending Payments -->
        <div class="stat-card bg-white rounded-lg p-4 md:p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs md:text-sm text-gray-600">Pending Payments</p>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800">{{ $pendingPayments }}</h3>
                </div>
                <div class="bg-yellow-100 p-2 md:p-3 rounded-full flex-shrink-0">
                    <i class="fas fa-clock text-yellow-600 text-lg md:text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1 md:mt-2">
                @if($overduePayments > 0)
                    <span class="text-red-600">{{ $overduePayments }}</span> overdue
                @else
                    <span class="text-green-600">All up to date</span>
                @endif
            </p>
        </div>

        <!-- Today's Revenue -->
        <div class="stat-card bg-white rounded-lg p-4 md:p-6 border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs md:text-sm text-gray-600">Today's Revenue</p>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800">Rs.{{ number_format($todaysRevenue, 2) }}</h3>
                </div>
                <div class="bg-purple-100 p-2 md:p-3 rounded-full flex-shrink-0">
                    <i class="fas fa-dollar-sign text-purple-600 text-lg md:text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-1 md:mt-2">
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
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
        <!-- Quick Actions Card -->
        <div class="bg-white shadow-sm rounded-lg p-4 md:p-6">
            <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-3 md:mb-4">Quick Actions</h3>
            <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-3 gap-2 md:gap-3 lg:gap-4">
                <a href="{{ route('reception.students.create') }}" class="flex flex-col items-center justify-center p-2 md:p-3 lg:p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-user-plus text-lg md:text-xl lg:text-2xl text-gray-400 group-hover:text-primary-600 mb-1 md:mb-2"></i>
                    <span class="text-xs md:text-sm font-medium text-gray-700 group-hover:text-primary-700 text-center">New Student</span>
                </a>
                <a href="{{ route('centers.create') }}" class="flex flex-col items-center justify-center p-2 md:p-3 lg:p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-credit-card text-lg md:text-xl lg:text-2xl text-gray-400 group-hover:text-primary-600 mb-1 md:mb-2"></i>
                    <span class="text-xs md:text-sm font-medium text-gray-700 group-hover:text-primary-700 text-center">Add Center</span>
                </a>
                <a href="{{ route('reception.qrcodes.manage') }}" class="flex flex-col items-center justify-center p-2 md:p-3 lg:p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-qrcode text-lg md:text-xl lg:text-2xl text-gray-400 group-hover:text-primary-600 mb-1 md:mb-2"></i>
                    <span class="text-xs md:text-sm font-medium text-gray-700 group-hover:text-primary-700 text-center">Manage QR</span>
                </a>
                <a href="{{ route('reception.students.index') }}" class="flex flex-col items-center justify-center p-2 md:p-3 lg:p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-list text-lg md:text-xl lg:text-2xl text-gray-400 group-hover:text-primary-600 mb-1 md:mb-2"></i>
                    <span class="text-xs md:text-sm font-medium text-gray-700 group-hover:text-primary-700 text-center">View Students</span>
                </a>
                <a href="{{ route('reception.payments.index') }}" class="flex flex-col items-center justify-center p-2 md:p-3 lg:p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-receipt text-lg md:text-xl lg:text-2xl text-gray-400 group-hover:text-primary-600 mb-1 md:mb-2"></i>
                    <span class="text-xs md:text-sm font-medium text-gray-700 group-hover:text-primary-700 text-center">Payments</span>
                </a>
                <a href="{{ route('reception.qrcodes.print-batch') }}" class="flex flex-col items-center justify-center p-2 md:p-3 lg:p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-print text-lg md:text-xl lg:text-2xl text-gray-400 group-hover:text-primary-600 mb-1 md:mb-2"></i>
                    <span class="text-xs md:text-sm font-medium text-gray-700 group-hover:text-primary-700 text-center">Print QR</span>
                </a>
                <a href="{{ route('courses.create') }}" class="flex flex-col items-center justify-center p-2 md:p-3 lg:p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-book text-lg md:text-xl lg:text-2xl text-gray-400 group-hover:text-primary-600 mb-1 md:mb-2"></i>
                    <span class="text-xs md:text-sm font-medium text-gray-700 group-hover:text-primary-700 text-center">Add Course</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white shadow-sm rounded-lg p-4 md:p-6">
            <div class="flex justify-between items-center mb-3 md:mb-4">
                <h3 class="text-base md:text-lg font-semibold text-gray-800">Recent Activity</h3>
                <a href="#" class="text-xs md:text-sm text-primary-600 hover:text-primary-700">View All</a>
            </div>
            <div class="space-y-2 md:space-y-3 lg:space-y-4 max-h-60 md:max-h-80 overflow-y-auto pr-1">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start md:items-center space-x-2 md:space-x-3">
                        <div class="w-6 h-6 md:w-8 md:h-8 bg-{{ 
                            str_contains(strtolower($activity->action), 'student') ? 'green' : 
                            (str_contains(strtolower($activity->action), 'payment') ? 'blue' : 
                            (str_contains(strtolower($activity->action), 'update') ? 'purple' : 'gray'))
                        }}-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5 md:mt-0">
                            <i class="fas fa-{{ 
                                str_contains(strtolower($activity->action), 'student') ? 'user-plus' : 
                                (str_contains(strtolower($activity->action), 'payment') ? 'credit-card' : 
                                (str_contains(strtolower($activity->action), 'update') ? 'edit' : 'activity'))
                            }} text-{{ 
                                str_contains(strtolower($activity->action), 'student') ? 'green' : 
                                (str_contains(strtolower($activity->action), 'payment') ? 'blue' : 
                                (str_contains(strtolower($activity->action), 'update') ? 'purple' : 'gray'))
                            }}-600 text-xs md:text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs md:text-sm text-gray-800 truncate">{{ $activity->action }}</p>
                            @if($activity->description)
                                <p class="text-xs text-gray-500 truncate">{{ Str::limit($activity->description, 30) }}</p>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400 flex-shrink-0 whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <div class="text-center py-2 md:py-4">
                        <p class="text-xs md:text-sm text-gray-500">No recent activities</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Today's Schedule & Pending Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
        <!-- Today's Schedule -->
        <div class="bg-white shadow-sm rounded-lg p-4 md:p-6">
            <div class="flex justify-between items-center mb-3 md:mb-4">
                <h3 class="text-base md:text-lg font-semibold text-gray-800">Today's Schedule</h3>
                <a href="{{ route('reception.schedule.index') }}" class="text-xs md:text-sm text-primary-600 hover:text-primary-700">View All</a>
            </div>
            <div class="space-y-2 md:space-y-3 max-h-60 md:max-h-80 overflow-y-auto pr-1">
                @forelse($todaySchedules as $schedule)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-2 md:p-3 rounded-lg 
                        {{ strtolower($schedule->status) == 'upcoming' ? 'bg-blue-50' : (strtolower($schedule->status) == 'scheduled' ? 'bg-green-50' : 'bg-gray-50') }}">
                        <div class="flex items-center space-x-2 md:space-x-3 mb-1 sm:mb-0">
                            <div class="w-2 h-6 md:h-8 rounded-full 
                                {{ strtolower($schedule->status) == 'upcoming' ? 'bg-blue-500' : (strtolower($schedule->status) == 'scheduled' ? 'bg-green-500' : 'bg-gray-400') }}"></div>
                            <div class="min-w-0">
                                <p class="text-xs md:text-sm font-medium text-gray-800 truncate">{{ $schedule->title }}</p>
                                <p class="text-xs text-gray-600 truncate">{{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }} - {{ $schedule->location }}</p>
                            </div>
                        </div>
                        <span class="px-1.5 py-0.5 md:px-2 md:py-1 text-xs rounded-full self-start sm:self-auto mt-1 sm:mt-0
                            {{ strtolower($schedule->status) == 'upcoming' ? 'bg-blue-100 text-blue-800' : (strtolower($schedule->status) == 'scheduled' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ $schedule->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-500 text-xs md:text-sm">No schedules today</p>
                @endforelse
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-white shadow-sm rounded-lg p-4 md:p-6">
            <div class="flex justify-between items-center mb-3 md:mb-4">
                <h3 class="text-base md:text-lg font-semibold text-gray-800">Pending Tasks</h3>
                @php
                    $urgentTasks = 0;
                    if($overduePaymentSchedules > 0) $urgentTasks++;
                    if($studentsNeedingVerification > 0) $urgentTasks++;
                @endphp
                @if($urgentTasks > 0)
                    <span class="px-1.5 py-0.5 md:px-2 md:py-1 bg-red-100 text-red-800 text-xs rounded-full">{{ $urgentTasks }} Urgent</span>
                @else
                    <span class="px-1.5 py-0.5 md:px-2 md:py-1 bg-green-100 text-green-800 text-xs rounded-full">All Clear</span>
                @endif
            </div>
            <div class="space-y-2 md:space-y-3 max-h-60 md:max-h-80 overflow-y-auto pr-1">
                @forelse($pendingTasks as $task)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-2 md:p-3 border rounded-lg
                        {{ $task->priority == 'urgent' ? 'border-red-200' : ($task->priority == 'today' ? 'border-yellow-200' : 'border-blue-200') }}">
                        <div class="flex items-center space-x-2 md:space-x-3 mb-1 sm:mb-0">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 w-3 h-3 md:w-4 md:h-4">
                            <div class="min-w-0">
                                <p class="text-xs md:text-sm font-medium text-gray-800 truncate">{{ $task->title }}</p>
                            </div>
                        </div>
                        <span class="text-xs md:text-sm {{ $task->priority == 'urgent' ? 'text-red-600' : ($task->priority == 'today' ? 'text-yellow-600' : 'text-blue-600') }} self-start sm:self-auto mt-1 sm:mt-0">
                            {{ ucfirst($task->priority) }}
                        </span>
                    </div>
                @empty
                    <p class="text-center text-gray-500 text-xs md:text-sm">No pending tasks</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card { 
        transition: all 0.3s ease; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.1); 
    }
    .stat-card:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 4px 12px rgba(0,0,0,0.15); 
    }
    
    /* Mobile optimizations */
    @media (max-width: 640px) {
        .grid-cols-3 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .sm\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .space-y-2 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.5rem * var(--tw-space-y-reverse));
        }
        
        .p-2 {
            padding: 0.5rem;
        }
        
        .text-lg {
            font-size: 1rem;
        }
        
        .text-xl {
            font-size: 1.25rem;
        }
        
        .max-h-60 {
            max-height: 15rem;
        }
    }
    
    @media (max-width: 768px) {
        .lg\:grid-cols-2 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .sm\:grid-cols-4 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        
        .text-base {
            font-size: 0.875rem;
        }
        
        .space-x-2 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(0.5rem * var(--tw-space-x-reverse));
            margin-left: calc(0.5rem * calc(1 - var(--tw-space-x-reverse)));
        }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
        .xl\:grid-cols-5 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        
        .lg\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        
        .lg\:p-4 {
            padding: 1rem;
        }
    }
    
    /* Scrollbar styling */
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 2px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 2px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .min-w-0 {
        min-width: 0;
    }
</style>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Task completion
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const taskItem = this.closest('div.flex.items-center.justify-between') || 
                            this.closest('div.flex.flex-col.sm\\:flex-row.sm\\:items-center.sm\\:justify-between');
            if(this.checked){
                taskItem.style.opacity='0.6';
                taskItem.style.textDecoration='line-through';
                // Move completed task to bottom with animation
                setTimeout(() => {
                    const container = taskItem.parentElement;
                    container.appendChild(taskItem);
                    taskItem.style.transition = 'opacity 0.3s ease';
                }, 300);
            }else{
                taskItem.style.opacity='1';
                taskItem.style.textDecoration='none';
            }
        });
    });
    
    // Make stats cards more touch-friendly on mobile
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('touchstart', function() {
            this.style.transform = 'translateY(-1px)';
        });
        
        card.addEventListener('touchend', function() {
            setTimeout(() => {
                this.style.transform = 'translateY(0)';
            }, 150);
        });
    });
});
</script>
@endsection

@endsection