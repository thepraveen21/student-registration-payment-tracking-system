<?php $__env->startSection('header', 'Attendance Records'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Attendance</h1>
            <a href="<?php echo e(route('reception.attendance.scan')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-qrcode mr-2"></i>
                Scan QR Code
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Student ID</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Phone Number</th>
                        <th class="py-2 px-4 border-b">Course</th>
                        <th class="py-2 px-4 border-b">Time</th>
                        <th class="py-2 px-4 border-b">Date</th>
                        <th class="py-2 px-4 border-b">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($attendances) && $attendances->count() > 0): ?>
                        <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="py-2 px-4 border-b"><?php echo e($attendance->student->registration_number); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo e($attendance->student->name); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo e($attendance->student->student_phone); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo e($attendance->student->course->name); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo e($attendance->attended_at->format('h:i A')); ?></td>
                                <td class="py-2 px-4 border-b"><?php echo e($attendance->attended_at->format('M d, Y')); ?></td>
                                <td class="py-2 px-4 border-b">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($attendance->student->payment_status === 'Paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($attendance->student->payment_status); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="py-4 px-4 border-b text-center">No attendance records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(isset($attendances)): ?>
        <div class="mt-4">
            <?php echo e($attendances->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Innovior\Student Management System\resources\views/reception/attendance/index.blade.php ENDPATH**/ ?>