<?php $__env->startSection('header', 'Dashboard'); ?>
<?php $__env->startSection('title', 'Reception Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Welcome, <?php echo e(Auth::user()->name); ?>!</h1>
                <p class="text-gray-600 mt-1">Here's what's happening today</p>
            </div>
            <div class="text-right">
                <p class="text-lg font-semibold text-gray-800"><?php echo e(now()->format('l, F j, Y')); ?></p>
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
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e(number_format($totalStudents)); ?></h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2"><span class="text-green-600">+<?php echo e($weeklyNewStudents); ?></span> new this week</p>
        </div>

        <!-- Today's Registrations -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Today's Registrations</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($todaysRegistrations); ?></h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-plus text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                <?php if($todaysRegistrations > 0): ?>
                    <span class="text-green-600">Active</span> registration day
                <?php else: ?>
                    <span class="text-gray-600">No</span> registrations yet today
                <?php endif; ?>
            </p>
        </div>

        <!-- QR Code Stats -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-indigo-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Available QR Codes</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e(App\Models\QRCode::whereNull('student_id')->count()); ?></h3>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full">
                    <i class="fas fa-qrcode text-indigo-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                <span class="text-indigo-600"><?php echo e(App\Models\QRCode::whereNotNull('student_id')->count()); ?></span> assigned
            </p>
        </div>

        <!-- Pending Payments -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Pending Payments</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($pendingPayments); ?></h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                <?php if($overduePayments > 0): ?>
                    <span class="text-red-600"><?php echo e($overduePayments); ?></span> overdue
                <?php else: ?>
                    <span class="text-green-600">All up to date</span>
                <?php endif; ?>
            </p>
        </div>

        <!-- Today's Revenue -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Today's Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-800">Rs.<?php echo e(number_format($todaysRevenue, 2)); ?></h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2">
                <?php
                    $revenueChange = $yesterdaysRevenue > 0 ? (($todaysRevenue - $yesterdaysRevenue) / $yesterdaysRevenue) * 100 : 0;
                ?>
                <?php if($revenueChange > 0): ?>
                    <span class="text-green-600">+<?php echo e(number_format($revenueChange, 1)); ?>%</span> from yesterday
                <?php elseif($revenueChange < 0): ?>
                    <span class="text-red-600"><?php echo e(number_format($revenueChange, 1)); ?>%</span> from yesterday
                <?php else: ?>
                    <span class="text-gray-600">Same as</span> yesterday
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions Card -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-3 gap-4">
                <a href="<?php echo e(route('reception.students.create')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-user-plus text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">New Student</span>
                </a>
                <a href="<?php echo e(route('centers.create')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-credit-card text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Add Center</span>
                </a>
                <a href="<?php echo e(route('reception.qrcodes.manage')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-qrcode text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Manage QR Codes</span>
                </a>
                <a href="<?php echo e(route('reception.students.index')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-list text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">View Students</span>
                </a>
                <a href="<?php echo e(route('reception.payments.index')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-receipt text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Payment History</span>
                </a>
                <a href="<?php echo e(route('reception.qrcodes.print-batch')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-print text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Print QR Codes</span>
                </a>
                <a href="<?php echo e(route('courses.create')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
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
                <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-<?php echo e(str_contains(strtolower($activity->action), 'student') ? 'green' : 
                            (str_contains(strtolower($activity->action), 'payment') ? 'blue' : 
                            (str_contains(strtolower($activity->action), 'update') ? 'purple' : 'gray'))); ?>-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-<?php echo e(str_contains(strtolower($activity->action), 'student') ? 'user-plus' : 
                                (str_contains(strtolower($activity->action), 'payment') ? 'credit-card' : 
                                (str_contains(strtolower($activity->action), 'update') ? 'edit' : 'activity'))); ?> text-<?php echo e(str_contains(strtolower($activity->action), 'student') ? 'green' : 
                                (str_contains(strtolower($activity->action), 'payment') ? 'blue' : 
                                (str_contains(strtolower($activity->action), 'update') ? 'purple' : 'gray'))); ?>-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-800"><?php echo e($activity->action); ?></p>
                            <?php if($activity->description): ?>
                                <p class="text-xs text-gray-500"><?php echo e(Str::limit($activity->description, 50)); ?></p>
                            <?php endif; ?>
                        </div>
                        <span class="text-xs text-gray-400"><?php echo e($activity->created_at->diffForHumans()); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-4">
                        <p class="text-sm text-gray-500">No recent activities found</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Today's Schedule & Pending Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Schedule -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Today's Schedule</h3>
                <a href="<?php echo e(route('reception.schedule.index')); ?>" class="text-sm text-primary-600 hover:text-primary-700">View All</a>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $todaySchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between p-3 rounded-lg 
                        <?php echo e(strtolower($schedule->status) == 'upcoming' ? 'bg-blue-50' : (strtolower($schedule->status) == 'scheduled' ? 'bg-green-50' : 'bg-gray-50')); ?>">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-8 rounded-full 
                                <?php echo e(strtolower($schedule->status) == 'upcoming' ? 'bg-blue-500' : (strtolower($schedule->status) == 'scheduled' ? 'bg-green-500' : 'bg-gray-400')); ?>"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-800"><?php echo e($schedule->title); ?></p>
                                <p class="text-xs text-gray-600"><?php echo e(\Carbon\Carbon::parse($schedule->time)->format('h:i A')); ?> - <?php echo e($schedule->location); ?></p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                            <?php echo e(strtolower($schedule->status) == 'upcoming' ? 'bg-blue-100 text-blue-800' : (strtolower($schedule->status) == 'scheduled' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')); ?>">
                            <?php echo e($schedule->status); ?>

                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-center text-gray-500">No schedules today</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pending Tasks</h3>
                <?php
                    $urgentTasks = 0;
                    if($overduePaymentSchedules > 0) $urgentTasks++;
                    if($studentsNeedingVerification > 0) $urgentTasks++;
                ?>
                <?php if($urgentTasks > 0): ?>
                    <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full"><?php echo e($urgentTasks); ?> Urgent</span>
                <?php else: ?>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">All Clear</span>
                <?php endif; ?>
            </div>
            <div class="space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $pendingTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between p-3 border rounded-lg
                        <?php echo e($task->priority == 'urgent' ? 'border-red-200' : ($task->priority == 'today' ? 'border-yellow-200' : 'border-blue-200')); ?>">
                        <div class="flex items-center space-x-3">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <div>
                                <p class="text-sm font-medium text-gray-800"><?php echo e($task->title); ?></p>
                            </div>
                        </div>
                        <span class="text-sm <?php echo e($task->priority == 'urgent' ? 'text-red-600' : ($task->priority == 'today' ? 'text-yellow-600' : 'text-blue-600')); ?>">
                            <?php echo e(ucfirst($task->priority)); ?>

                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-center text-gray-500">No pending tasks</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card { transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
</style>

<?php $__env->startSection('scripts'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Project\Student Management System\resources\views/reception/dashboard.blade.php ENDPATH**/ ?>