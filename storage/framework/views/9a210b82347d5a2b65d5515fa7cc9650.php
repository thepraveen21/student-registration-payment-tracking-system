<?php $__env->startSection('header', 'Edit Payment'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-semibold mb-6">Edit Payment</h1>

        <?php if($errors->any()): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('reception.payments.update', $payment)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Student:</label>
                    <input type="text" value="<?php echo e($payment->student->name); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 leading-tight focus:outline-none focus:shadow-outline" disabled>
                    <input type="hidden" name="student_id" value="<?php echo e($payment->student_id); ?>">
                </div>

                <!-- Course -->
                <div>
                    <label for="course_id" class="block text-gray-700 text-sm font-bold mb-2">Course:</label>
                    <select name="course_id" id="course_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course->id); ?>" <?php echo e($payment->course_id == $course->id ? 'selected' : ''); ?>><?php echo e($course->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Month Number -->
                <div>
                    <label for="month_number" class="block text-gray-700 text-sm font-bold mb-2">Month Number:</label>
                    <input type="number" name="month_number" id="month_number" value="<?php echo e($payment->month_number); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required min="1" max="12">
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Amount:</label>
                    <input type="number" name="amount" id="amount" value="<?php echo e($payment->amount); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required step="0.01">
                </div>

                <!-- Payment Date -->
                <div>
                    <label for="payment_date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                    <input type="date" name="payment_date" id="payment_date" value="<?php echo e($payment->payment_date ? $payment->payment_date->format('Y-m-d') : ''); ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-gray-200 leading-tight focus:outline-none focus:shadow-outline" required readonly>
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes:</label>
                    <textarea name="notes" id="notes" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?php echo e($payment->notes); ?></textarea>
                </div>
            </div>

            <div class="flex items-center justify-between mt-8">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Payment
                </button>
                <a href="<?php echo e(route('reception.payments.index')); ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Desktop\New folder (17)\Student Management System\resources\views/reception/payments/edit.blade.php ENDPATH**/ ?>