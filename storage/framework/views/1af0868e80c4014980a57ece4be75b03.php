<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Students</h2>
    <a href="<?php echo e(route('reception.students.create')); ?>" class="btn btn-primary">Add Student</a>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($student->name); ?></td>
                    <td><?php echo e($student->email); ?></td>
                    <td><?php echo e($student->phone); ?></td>
                    <td>
                        <a href="<?php echo e(route('reception.students.show', $student)); ?>" class="btn btn-info btn-sm">View</a>
                        <a href="<?php echo e(route('reception.students.edit', $student)); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="<?php echo e(route('reception.students.destroy', $student)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this student?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\Group Project\myproject\resources\views/reception/students/index.blade.php ENDPATH**/ ?>