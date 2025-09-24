<?php $__env->startSection('content'); ?>
<div class="container">
    <h1>Payments</h1>
    <a href="<?php echo e(route('reception.payments.create')); ?>" class="btn btn-primary mb-3">Add Payment</a>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Student</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($payment->id); ?></td>
                    <td><?php echo e($payment->student->name ?? 'N/A'); ?></td>
                    <td><?php echo e($payment->amount); ?></td>
                    <td><?php echo e($payment->date); ?></td>
                    <td><?php echo e($payment->status); ?></td>
                    <td>
                        <a href="<?php echo e(route('reception.payments.show', $payment)); ?>" class="btn btn-info btn-sm">View</a>
                        <a href="<?php echo e(route('reception.payments.edit', $payment)); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="<?php echo e(route('reception.payments.destroy', $payment)); ?>" method="POST" style="display:inline-block;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="6">No payments found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\Group Project\myproject\resources\views/reception/payments/index.blade.php ENDPATH**/ ?>