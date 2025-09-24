<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 class="mb-4">Students</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Reg. No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Student Phone</th>
                <th>Parent Phone</th>
                <th>Date of Birth</th>
                <th>Course</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($student->id); ?></td>
                    <td><?php echo e($student->registration_number); ?></td>
                    <td><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></td>
                    <td><?php echo e($student->email); ?></td>
                    <td><?php echo e($student->student_phone); ?></td>
                    <td><?php echo e($student->parent_phone); ?></td>
                    <td><?php echo e($student->date_of_birth); ?></td>
                    <td><?php echo e($student->course?->name ?? 'N/A'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <?php echo e($students->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.Admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\Group Project\myproject\resources\views/students/index.blade.php ENDPATH**/ ?>