<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mb-4">Payments</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Amount</th>
                <th>Payment Date</th>
                <th>Recorded By</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($payment->id); ?></td>
                    <td><?php echo e($payment->student?->first_name); ?> <?php echo e($payment->student?->last_name); ?></td>
                    <td>$<?php echo e(number_format($payment->amount, 2)); ?></td>
                    <td><?php echo e($payment->payment_date); ?></td>
                    <td><?php echo e($payment->recorded_by); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <?php echo e($payments->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.Admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\Group Project\myproject\resources\views/payments/index.blade.php ENDPATH**/ ?>