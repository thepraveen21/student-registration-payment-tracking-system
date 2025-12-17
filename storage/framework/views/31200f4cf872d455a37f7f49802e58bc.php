<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Payment-wise Student Report</h1>
                <p class="mt-2 text-sm text-gray-600">A comprehensive summary of student payment statuses</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-3">
                    <button onclick="window.print()" 
                           class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Report
                    </button>
                    <a href="<?php echo e(route('admin.reports.payment-wise-students', ['export' => 'pdf'])); ?>" 
                       class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Export to PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Summary -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-6 mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
                <div class="text-center">
                    <p class="text-sm font-medium text-blue-600">Total Students</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1"><?php echo e($students->count()); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-blue-600">Total Paid</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">Rs. <?php echo e(number_format($students->sum('total_paid'), 2)); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-blue-600">Total Due</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">Rs. <?php echo e(number_format($students->sum('total_due'), 2)); ?></p>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium text-blue-600">Overall Balance</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">Rs. <?php echo e(number_format($students->sum('balance'), 2)); ?></p>
                </div>
            </div>
        </div>

        <!-- Main Report Table -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Student Payment Summary</h2>
                    <div class="text-sm text-gray-600">
                        <?php echo e(now()->format('F d, Y')); ?>

                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Student Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Course
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Course Fee
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Total Paid
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Total Due
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Balance
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Student Name -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo e($data['student']->first_name); ?> <?php echo e($data['student']->last_name); ?> (<?php echo e($data['student']->registration_number); ?>)
                            </td>
                            <!-- Course -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($data['student']->course->name ?? 'N/A'); ?>

                            </td>
                            <!-- Course Fee -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                                Rs. <?php echo e(number_format($data['total_course_fee'], 2)); ?>

                            </td>
                            <!-- Total Paid -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                                Rs. <?php echo e(number_format($data['total_paid'], 2)); ?>

                            </td>
                            <!-- Total Due -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                                Rs. <?php echo e(number_format($data['total_due'], 2)); ?>

                            </td>
                            <!-- Balance -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold <?php echo e($data['balance'] > 0 ? 'text-red-600' : 'text-green-600'); ?>">
                                Rs. <?php echo e(number_format($data['balance'], 2)); ?>

                            </td>
                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                    <?php echo e($data['payment_status'] == 'paid' ? 'bg-green-100 text-green-800' : ($data['payment_status'] == 'overdue' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                    <?php echo e(ucfirst($data['payment_status'])); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <h3 class="mt-4 text-lg font-medium text-gray-900">No student payment data found</h3>
                                <p class="mt-1 text-gray-500">There are no student payment records to display.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                        Total students with payment data: <span class="font-semibold"><?php echo e($students->count()); ?></span>
                    </div>
                    <div class="text-sm text-gray-600">
                        Report generated on <?php echo e(now()->format('F d, Y \a\t h:i A')); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .container, .container * {
            visibility: visible;
        }
        .container {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        nav, button, a, .hover\:bg-gray-50, .hover\:bg-blue-200, .hover\:from-red-700, .hover\:to-rose-700,
        .hover\:shadow-lg, .transform, .hover\:-translate-y-0\.5, .transition-all, .transition-colors,
        .transition-transform, [x-cloak], [x-show="false"] {
            display: none !important;
        }
        .bg-white, .rounded-xl, .shadow-lg, .border {
            box-shadow: none !important;
            border: 1px solid #e5e7eb !important;
        }
        .bg-gradient-to-r {
            background: linear-gradient(to right, var(--tw-gradient-stops)) !important;
        }
        [x-show="true"] {
            display: table-row !important;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Desktop\New folder (17)\Student Management System\resources\views/admin/reports/payment-wise-students.blade.php ENDPATH**/ ?>