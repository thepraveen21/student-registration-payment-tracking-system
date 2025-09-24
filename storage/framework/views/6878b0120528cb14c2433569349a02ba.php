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
                <p class="text-gray-600"><?php echo e(now()->format('g:i A')); ?></p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Students -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-blue-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Total Students</p>
                    <h3 class="text-2xl font-bold text-gray-800">1,245</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-user-graduate text-blue-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2"><span class="text-green-600">+12</span> new this week</p>
        </div>

        <!-- Today's Registrations -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Today's Registrations</p>
                    <h3 class="text-2xl font-bold text-gray-800">8</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-user-plus text-green-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2"><span class="text-green-600">+2</span> from yesterday</p>
        </div>

        <!-- Pending Payments -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-yellow-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Pending Payments</p>
                    <h3 class="text-2xl font-bold text-gray-800">23</h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2"><span class="text-red-600">5</span> overdue</p>
        </div>

        <!-- Today's Revenue -->
        <div class="stat-card bg-white rounded-lg p-6 border-l-4 border-purple-500">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Today's Revenue</p>
                    <h3 class="text-2xl font-bold text-gray-800">$2,340</h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-dollar-sign text-purple-600 text-xl"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2"><span class="text-green-600">+15%</span> from yesterday</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions Card -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="<?php echo e(route('reception.students.create')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-user-plus text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">New Student</span>
                </a>
                <a href="<?php echo e(route('reception.payments.create')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-credit-card text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Record Payment</span>
                </a>
                <a href="<?php echo e(route('reception.students.index')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-list text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">View Students</span>
                </a>
                <a href="<?php echo e(route('reception.payments.index')); ?>" class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors group">
                    <i class="fas fa-receipt text-2xl text-gray-400 group-hover:text-primary-600 mb-2"></i>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-primary-700">Payment History</span>
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
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-plus text-green-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">New student registration</p>
                        <p class="text-xs text-gray-500">John Doe - Web Development</p>
                    </div>
                    <span class="text-xs text-gray-400">10:30 AM</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-credit-card text-blue-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">Payment received</p>
                        <p class="text-xs text-gray-500">Jane Smith - $500</p>
                    </div>
                    <span class="text-xs text-gray-400">09:45 AM</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope text-yellow-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">Reminder sent</p>
                        <p class="text-xs text-gray-500">Payment due - Mike Johnson</p>
                    </div>
                    <span class="text-xs text-gray-400">09:15 AM</span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-edit text-purple-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800">Student information updated</p>
                        <p class="text-xs text-gray-500">Sarah Wilson - Contact details</p>
                    </div>
                    <span class="text-xs text-gray-400">Yesterday</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Schedule & Pending Tasks -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Schedule -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Today's Schedule</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-8 bg-blue-500 rounded-full"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Student Orientation</p>
                            <p class="text-xs text-gray-600">10:00 AM - Conference Room</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Upcoming</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-8 bg-green-500 rounded-full"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Payment Collection</p>
                            <p class="text-xs text-gray-600">2:00 PM - Reception</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Scheduled</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-8 bg-gray-400 rounded-full"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Staff Meeting</p>
                            <p class="text-xs text-gray-600">4:00 PM - Manager's Office</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Later</span>
                </div>
            </div>
        </div>

        <!-- Pending Tasks -->
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pending Tasks</h3>
                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">3 Urgent</span>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 border border-red-200 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <div>
                            <p class="text-sm font-medium text-gray-800">Follow up on overdue payments</p>
                            <p class="text-xs text-gray-600">5 payments pending > 30 days</p>
                        </div>
                    </div>
                    <span class="text-red-600 text-sm">Urgent</span>
                </div>
                <div class="flex items-center justify-between p-3 border border-yellow-200 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                        <div>
                            <p class="text-sm font-medium text-gray-800">Update student records</p>
                            <p class="text-xs text-gray-600">12 records need verification</p>
                        </div>
                    </div>
                    <span class="text-yellow-600 text-sm">Today</span>
                </div>
                <div class="flex items-center justify-between p-3 border border-blue-200 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <div>
                            <p class="text-sm font-medium text-gray-800">Prepare weekly report</p>
                            <p class="text-xs text-gray-600">Due by Friday EOD</p>
                        </div>
                    </div>
                    <span class="text-blue-600 text-sm">This week</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .stat-card {
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Task completion functionality
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const taskItem = this.closest('.flex.items-center.justify-between');
                if (this.checked) {
                    taskItem.style.opacity = '0.6';
                    taskItem.style.textDecoration = 'line-through';
                } else {
                    taskItem.style.opacity = '1';
                    taskItem.style.textDecoration = 'none';
                }
            });
        });

        // Real-time clock update
        function updateClock() {
            const now = new Date();
            const timeElement = document.querySelector('.text-gray-600');
            if (timeElement) {
                timeElement.textContent = now.toLocaleTimeString('en-US', { 
                    hour: 'numeric', 
                    minute: '2-digit', 
                    hour12: true 
                });
            }
        }
        
        // Update clock every minute
        setInterval(updateClock, 60000);
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Projects\Laravel\Project\myproject\resources\views/reception/dashboard.blade.php ENDPATH**/ ?>