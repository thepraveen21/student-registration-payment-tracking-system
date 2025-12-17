<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Payment Details</h1>
                <p class="mt-2 text-sm text-gray-600">Viewing details for a monthly payment record</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="<?php echo e(route('admin.payments.index')); ?>" 
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Payments
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Details Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Monthly Payment Information</h2>
        </div>
        <div class="px-6 py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Student</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900"><?php echo e($payment->student->full_name); ?></p>
                    <p class="text-sm text-gray-500"><?php echo e($payment->student->registration_number); ?></p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Course</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900"><?php echo e($payment->course->name); ?></p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Amount</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">Rs.<?php echo e(number_format($payment->amount, 2)); ?></p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Payment Date</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900"><?php echo e($payment->payment_date->format('M d, Y')); ?></p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Month Number</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900">Month <?php echo e($payment->month_number); ?></p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Recorded By</h3>
                    <p class="mt-1 text-lg font-semibold text-gray-900"><?php echo e($payment->recordedBy->name); ?></p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500">Notes</h3>
                    <p class="mt-1 text-base text-gray-700"><?php echo e($payment->notes ?: 'N/A'); ?></p>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex justify-end space-x-3">
                <a href="<?php echo e(route('admin.payments.edit', $payment->id)); ?>" class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
                <form action="<?php echo e(route('admin.payments.destroy', $payment->id)); ?>" method="POST" class="inline-block">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to delete this payment record?')"
                            class="inline-flex items-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Projects\innovior info\Student Management System\resources\views/admin/payments/show.blade.php ENDPATH**/ ?>