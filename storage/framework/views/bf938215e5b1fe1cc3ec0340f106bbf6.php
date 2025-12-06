<?php $__env->startSection('header', 'Attendance Records'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">

    <div class="bg-white shadow-md rounded-lg p-8">

        
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Attendance Overview</h1>
                <p class="text-gray-500 text-sm">Today: <?php echo e(now()->format('M d, Y')); ?></p>
            </div>

            <a href="<?php echo e(route('reception.attendance.scan')); ?>" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <i class="fas fa-qrcode mr-2"></i>
                Scan QR Code
            </a>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">Present Today</p>
                <p class="text-3xl font-bold text-gray-800"><?php echo e($todayCount ?? 0); ?></p>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">Courses Today</p>
                <p class="text-3xl font-bold text-gray-800"><?php echo e($uniqueCourses ?? 0); ?></p>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">Last Scan</p>
                <p class="text-xl font-semibold text-gray-800">
                    <?php echo e($latestAttendance ? $latestAttendance->attended_at->format('h:i A') : '—'); ?>

                </p>
            </div>

        </div>

        
        <form method="GET" action="<?php echo e(route('reception.attendance.index')); ?>" class="mb-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                
                <input 
                    type="text" 
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Search student name or ID"
                    class="border rounded-lg px-3 py-2 w-full"
                >

                
                <select name="course" class="border rounded-lg px-3 py-2 w-full">
                    <option value="">All Courses</option>
                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($course->id); ?>" <?php echo e(request('course') == $course->id ? 'selected' : ''); ?>>
                            <?php echo e($course->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                
                <input 
                    type="date" 
                    name="date" 
                    value="<?php echo e(request('date')); ?>"
                    class="border rounded-lg px-3 py-2 w-full"
                >

                
                <a href="<?php echo e(route('reception.attendance.index')); ?>" 
                   class="border px-3 py-2 rounded-lg text-center hover:bg-gray-100">
                    Reset
                </a>
            </div>

            
            <div class="mt-4">
                <button 
                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg">
                    Apply Filters
                </button>
            </div>

        </form>

        
        <div class="overflow-x-auto">

            <?php if($attendances && count($attendances) > 0): ?>

                <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="mb-6 border rounded-lg overflow-hidden shadow">
                        
                        <div class="bg-blue-600 text-white px-4 py-2 text-lg font-semibold">
                            <?php echo e(\Carbon\Carbon::parse($date)->format('M d, Y')); ?>

                        </div>

                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Student ID</th>
                                    <th class="py-2 px-4 border-b">Name</th>
                                    <th class="py-2 px-4 border-b">Phone</th>
                                    <th class="py-2 px-4 border-b">Course</th>
                                    <th class="py-2 px-4 border-b">Time</th>
                                    <th class="py-2 px-4 border-b">Payment Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="py-2 px-4 border-b"><?php echo e($attendance->student->registration_number); ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo e($attendance->student->name); ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo e($attendance->student->student_phone); ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo e($attendance->student->course->name); ?></td>
                                        <td class="py-2 px-4 border-b"><?php echo e($attendance->attended_at->format('h:i A')); ?></td>
                                        <td class="py-2 px-4 border-b">
                                            <?php
                                                $courseFee = $attendance->student->course->fee ?? 0;

                                                // Total paid by this student
                                                $totalPaid = $attendance->student->payments->sum('amount');

                                                // Determine status
                                                $isPaid = $totalPaid >= $courseFee;
                                            ?>

                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                            <?php echo e($isPaid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                                <?php echo e($isPaid ? 'Paid' : 'Unpaid'); ?>

                                            </span>
                                            
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php else: ?>
                <p class="text-center py-4">No attendance records found.</p>
            <?php endif; ?>

        </div>


        
        <?php if(isset($attendances)): ?>
        <div class="mt-4">
            <?php echo e($attendances->appends(request()->query())->links()); ?>

        </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Projects\innovior info\Student Management System\resources\views/reception/attendance/index.blade.php ENDPATH**/ ?>