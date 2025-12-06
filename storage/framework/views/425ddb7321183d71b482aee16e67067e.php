<?php $__env->startSection('header', 'Monthly Payments'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4">
            <h1 class="text-2xl font-semibold">Monthly Payments for <?php echo e($student->name); ?></h1>
            <h2 class="text-lg text-gray-600">Course: <?php echo e($student->course->name); ?></h2>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
                <p class="font-bold">Success</p>
                <p class="text-sm"><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('reception.students.store-monthly-payments', $student)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Month
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Payment Date
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Notes
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i = 1; $i <= 4; $i++): ?>
                            <?php
                                $payment = $student->monthlyPayments->where('month_number', $i)->first();
                            ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap">Month <?php echo e($i); ?></p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <input type="datetime-local" name="monthly_payments[<?php echo e($i); ?>][payment_date]" class="form-input w-full" value="<?php echo e($payment ? $payment->payment_date->format('Y-m-d\TH:i') : ''); ?>">
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <input type="number" step="0.01" name="monthly_payments[<?php echo e($i); ?>][amount]" class="form-input w-full" value="<?php echo e($payment ? $payment->amount : ''); ?>">
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <textarea name="monthly_payments[<?php echo e($i); ?>][notes]" class="form-textarea w-full"><?php echo e($payment ? $payment->notes : ''); ?></textarea>
                                </td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Save Payments
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Desktop\New folder (14)\Student Management System\resources\views/reception/payments/monthly.blade.php ENDPATH**/ ?>