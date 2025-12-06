<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold leading-tight">Advanced Reports</h2>
            <p class="text-gray-600">Generate detailed reports and analytics for your student management system.</p>
        </div>

        <!-- Quick Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-blue-500 text-white rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-users text-2xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold">Total Students</h3>
                        <p class="text-2xl font-bold"><?php echo e(number_format($stats['total_students'])); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-green-500 text-white rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-rupee-sign text-2xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold">Total Revenue</h3>
                        <p class="text-2xl font-bold">Rs.<?php echo e(number_format($stats['total_payments'], 2)); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-500 text-white rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-clock text-2xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold">Pending</h3>
                        <p class="text-2xl font-bold">Rs.<?php echo e(number_format($stats['pending_payments'], 2)); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-red-500 text-white rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-2xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold">Overdue</h3>
                        <p class="text-2xl font-bold">Rs.<?php echo e(number_format($stats['overdue_payments'], 2)); ?></p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-500 text-white rounded-lg p-6">
                <div class="flex items-center">
                    <i class="fas fa-book text-2xl mr-4"></i>
                    <div>
                        <h3 class="text-lg font-semibold">Total Courses</h3>
                        <p class="text-2xl font-bold"><?php echo e(number_format($stats['total_courses'])); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Categories -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Course Reports -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-4">
                    <i class="fas fa-graduation-cap text-blue-500 text-2xl mr-3"></i>
                    <h3 class="text-xl font-semibold">Course Reports</h3>
                </div>
                <p class="text-gray-600 mb-4">Analyze student enrollment and course performance.</p>
                <div class="space-y-2">
                    <a href="<?php echo e(route('admin.reports.course-wise-students')); ?>" class="block bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-2 rounded transition duration-200">
                        <i class="fas fa-chart-bar mr-2"></i>Course-wise Students
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Innovior\Desktop\4.11 time\Student Management System\resources\views/admin/reports/index.blade.php ENDPATH**/ ?>