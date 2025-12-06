<?php $__env->startSection('header', 'Attendance Matrix'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">

    <h1 class="text-2xl font-bold mb-4">Attendance Matrix (4 months / 16 weeks)</h1>

    
    <form method="GET" class="mb-4 inline-block w-full">
        <div class="flex flex-col md:flex-row md:items-end md:space-x-4 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700">Course</label>
                <select name="course_id" class="mt-1 block w-full border rounded px-3 py-2">
                    <option value="">All courses</option>
                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c->id); ?>" <?php echo e(request('course_id') == $c->id ? 'selected' : ''); ?>>
                            <?php echo e($c->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="md:ml-auto">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            </div>
        </div>
    </form>

    
    <div class="flex items-center space-x-4 mb-4">
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 bg-green-500 rounded"></div><div class="text-sm">Attended (≥1 day in week)</div>
        </div>
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 bg-red-500 rounded"></div><div class="text-sm">Absent (no days in week)</div>
        </div>
        <div class="ml-6 text-sm text-gray-600">Note: each student's course start = student registration date.</div>
    </div>

    <div class="overflow-auto border rounded bg-white shadow">
        <table class="min-w-max w-full table-auto">
            <thead>
                
                <tr class="bg-gray-100">
                    <th class="px-4 py-3 text-left font-semibold sticky left-0 bg-gray-100 z-10">Student</th>
                    <th class="px-4 py-3 text-left font-semibold sticky left-0 bg-gray-100 z-10">Course</th>
                    <th class="px-4 py-3 text-left font-semibold sticky left-0 bg-gray-100 z-10">Center</th>

                    <?php for($m = 1; $m <= 4; $m++): ?>
                        <th colspan="4" class="px-4 py-3 text-center font-semibold border-l">
                            Month <?php echo e($m); ?>

                        </th>
                    <?php endfor; ?>

                    <th class="px-4 py-3 text-center font-semibold border-l">Presence %</th>
                </tr>

                
                <tr class="bg-gray-200">
                    <th class="px-4 py-2"></th>
                    <th class="px-4 py-2"></th>
                    <th class="px-4 py-2"></th>

                    <?php for($w = 1; $w <= 16; $w++): ?>
                        <th class="px-2 py-2 text-center text-xs font-medium border-l">W<?php echo e($w); ?></th>
                    <?php endfor; ?>

                    <th class="px-4 py-2 text-center text-xs font-medium">%</th>
                </tr>
            </thead>

            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap font-medium sticky left-0 bg-white z-0">
                            <?php echo e($student->name); ?>

                        </td>
                        <td class="px-4 py-3 whitespace-nowrap sticky left-0 bg-white z-0">
                            <?php echo e($student->course->name ?? '-'); ?>

                        </td>
                        <td class="px-4 py-3 whitespace-nowrap sticky left-0 bg-white z-0">
                            <?php echo e($student->center->name ?? '-'); ?>

                        </td>

                        
                        <?php
                            $row = $attendanceMatrix[$student->id] ?? [];
                        ?>

                        <?php for($i = 0; $i < 16; $i++): ?>
                            <?php
                                $cell = $row[$i] ?? null;
                                $attended = $cell['attended'] ?? false;
                                $count = $cell['count'] ?? 0;
                                $start = isset($cell['start']) ? $cell['start']->format('Y-m-d') : '';
                                $end = isset($cell['end']) ? $cell['end']->format('Y-m-d') : '';
                                $title = $start && $end ? "Week ".($i+1).": $start → $end\nAttendances: $count" : "Week ".($i+1);
                            ?>

                            <td class="px-2 py-3 text-center border-l">
                                <div
                                    title="<?php echo e($title); ?>"
                                    class="w-6 h-6 mx-auto rounded transition-shadow"
                                    style="background-color: <?php echo e($attended ? '#16a34a' : '#ef4444'); ?>;">
                                </div>
                            </td>
                        <?php endfor; ?>

                        
                        <?php
                            $st = $stats[$student->id] ?? ['percent' => 0];
                        ?>
                        <td class="px-4 py-3 text-center font-semibold">
                            <?php echo e($st['percent'] ?? 0); ?>%
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="20" class="px-4 py-6 text-center text-gray-500">No students found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Monthly Payment Report -->
<div class="mt-8">
    <h2 class="text-xl font-semibold mb-4">Monthly Payment Report</h2>

    <?php $__empty_1 = true; $__currentLoopData = $paymentReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $payments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $monthLabel = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
            $monthTotal = $payments->sum('amount');
        ?>

        <div class="mb-6 border rounded-lg overflow-hidden shadow-sm">
            <div class="bg-gray-100 px-4 py-2 font-semibold text-gray-700">
                <?php echo e($monthLabel); ?>

            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Student</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Center</th>
                        <th class="px-4 py-2 text-right text-sm font-medium text-gray-700">Payment (Rs.)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-4 py-2">
                                <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?>

                            </td>
                            <td class="px-4 py-2">
                                <?php echo e($row->center_name ?? 'N/A'); ?>

                            </td>
                            <td class="px-4 py-2 text-right font-medium">
                                <?php echo e(number_format($row->amount, 2)); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <!-- Month Total -->
                    <tr class="bg-gray-50 font-semibold">
                        <td colspan="2" class="px-4 py-2 text-right">Total:</td>
                        <td class="px-4 py-2 text-right">
                            <?php echo e(number_format($monthTotal, 2)); ?>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-gray-500">No monthly payments recorded yet.</p>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Projects\innovior info\Student Management System\resources\views/reception/reports/index.blade.php ENDPATH**/ ?>