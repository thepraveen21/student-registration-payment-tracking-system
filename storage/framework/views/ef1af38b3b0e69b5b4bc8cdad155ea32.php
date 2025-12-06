<?php $__env->startSection('header', 'Monthly Payments'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">

    <!-- PAGE HEADER -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Students Monthly Payments</h1>

        <a href="<?php echo e(route('reception.payments.create')); ?>"
           class="bg-green-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-green-700 transition transform hover:scale-105">
            + Record Payment
        </a>
    </div>

    <!-- SUCCESS MESSAGE -->
    <?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-sm mb-6">
            <span><?php echo e(session('success')); ?></span>
        </div>
    <?php endif; ?>

    <!-- =============================== -->
    <!-- SEARCH & FILTER SECTION -->
    <!-- =============================== -->
    <form method="GET"
          action="<?php echo e(route('reception.payments.index')); ?>"
          class="bg-white shadow-lg rounded-xl px-6 py-6 mb-10 border border-gray-200">

        <h2 class="text-lg font-semibold text-gray-700 mb-4">Search & Filters</h2>

        <div class="grid md:grid-cols-3 gap-6">

            <!-- SEARCH STUDENT -->
            <div>
                <label class="text-sm text-gray-600 font-semibold mb-1 block">Search Student</label>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                       placeholder="Search by name or reg no..."
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 shadow-sm" />
            </div>

            <!-- FILTER COURSE -->
            <div>
                <label class="text-sm text-gray-600 font-semibold mb-1 block">Filter by Course</label>
                <select name="course"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 shadow-sm">
                    <option value="">All Courses</option>
                    <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($course->id); ?>" <?php echo e(request('course') == $course->id ? 'selected' : ''); ?>>
                            <?php echo e($course->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- FILTER CENTER -->
            <div>
                <label class="text-sm text-gray-600 font-semibold mb-1 block">Filter by Center</label>
                <select name="center"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 shadow-sm">
                    <option value="">All Centers</option>
                    <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($center->id); ?>" <?php echo e(request('center') == $center->id ? 'selected' : ''); ?>>
                            <?php echo e($center->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

        </div>

        <div class="mt-6 flex justify-end">
            <button class="bg-blue-600 text-white px-5 py-2.5 rounded-lg shadow-md hover:bg-blue-700 transition transform hover:scale-105">
                Apply Filters
            </button>
        </div>

    </form>

    <!-- =============================== -->
    <!-- GROUPED PAYMENT TABLE LIST -->
    <!-- =============================== -->
    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
        <h2 class="text-xl font-bold bg-gray-100 px-6 py-4 border-b text-gray-700">
            Monthly Payment Records
        </h2>

        <?php
            $grouped = $monthlyPayments->groupBy(fn($i) => $i->payment_date->format('Y-m-d'));
        ?>

        <?php $__empty_1 = true; $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

            <!-- DATE HEADER -->
            <div class="bg-blue-50 border-l-4 border-blue-500 px-6 py-4 shadow-sm">
                <h3 class="text-lg font-semibold text-blue-700 tracking-tight">
                    Payments on <?php echo e(\Carbon\Carbon::parse($date)->format('F d, Y')); ?>

                </h3>
            </div>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal mb-10 shadow-sm">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Reg No</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Center</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Month</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Recorded By</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600">Notes</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 border-b"><?php echo e($pay->student->name); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo e($pay->student->reg_no); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo e($pay->course->name); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo e($pay->student->center->name ?? 'N/A'); ?></td>
                                <td class="px-6 py-4 border-b">Month <?php echo e($pay->month_number); ?></td>
                                <td class="px-6 py-4 border-b font-semibold text-gray-800">
                                    Rs. <?php echo e(number_format($pay->amount, 2)); ?>

                                </td>
                                <td class="px-6 py-4 border-b"><?php echo e($pay->payment_date->format('h:i A')); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo e($pay->recordedBy->name ?? 'N/A'); ?></td>
                                <td class="px-6 py-4 border-b"><?php echo e($pay->notes ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-10 text-gray-500 text-lg">
                No monthly payments recorded yet.
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Desktop\New folder (14)\Student Management System\resources\views/reception/payments/index.blade.php ENDPATH**/ ?>