<?php $__env->startSection('header', 'Attendance Matrix'); ?>
<?php $__env->startSection('title', 'Attendance Matrix'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-2 sm:px-4 md:px-6 lg:px-8 py-4 md:py-8">
    <!-- Header Section -->
    <div class="mb-4 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-3 sm:mb-0">
                <h1 class="text-xl md:text-3xl font-bold text-gray-900">Attendance Matrix</h1>
                <p class="mt-1 md:mt-2 text-xs md:text-sm text-gray-600">4 months / 16 weeks attendance overview</p>
            </div>
            <div>
                <a href="<?php echo e(route('reception.reports.export', ['course_id' => request('course_id')])); ?>" class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export Report
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 md:mb-6 p-3 md:p-6">
        <form method="GET">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between space-y-3 md:space-y-4 lg:space-y-0">
                <div class="relative flex-grow">
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Course Filter</label>
                    <select name="course_id" class="appearance-none w-full bg-white border border-gray-300 rounded-lg py-2 md:py-2.5 px-3 md:px-4 pr-8 md:pr-10 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                        <option value="">All Courses</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->id); ?>" <?php echo e(request('course_id') == $c->id ? 'selected' : ''); ?>>
                                <?php echo e($c->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 top-5 md:top-6 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-3 w-3 md:h-4 md:w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3 md:space-x-4">
                    <button type="submit" class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-transparent text-white font-medium rounded-lg shadow-md bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 text-sm md:text-base">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Apply Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Legend Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 md:mb-6 p-3 md:p-6">
        <div class="flex flex-wrap items-center gap-3 md:gap-6">
            <div class="flex items-center space-x-2 md:space-x-3 flex-wrap gap-y-2">
                <div class="flex items-center space-x-1.5 md:space-x-2">
                    <div class="w-4 h-4 md:w-6 md:h-6 bg-green-500 rounded-lg shadow-sm"></div>
                    <span class="text-xs md:text-sm font-medium text-gray-700">Attended (≥1 day)</span>
                </div>
                <div class="flex items-center space-x-1.5 md:space-x-2">
                    <div class="w-4 h-4 md:w-6 md:h-6 bg-red-500 rounded-lg shadow-sm"></div>
                    <span class="text-xs md:text-sm font-medium text-gray-700">Absent (no days)</span>
                </div>
            </div>
            <div class="text-xs md:text-sm text-gray-600 bg-gray-50 px-3 py-1.5 md:px-4 md:py-2 rounded-lg mt-2 md:mt-0">
                <svg class="w-3 h-3 md:w-4 md:h-4 inline mr-1 md:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Note: Start date based on registration date.
            </div>
        </div>
    </div>

    <!-- Attendance Matrix Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6 md:mb-8">
        <div class="matrix-scroll overflow-x-auto overflow-y-visible">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <!-- Top Header: Month Groups -->
                    <tr>
                        <th scope="col" rowspan="2" class="px-2 md:px-4 py-2 md:py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-20 border-r min-w-[80px] md:min-w-[150px]">
                            <div>Student</div>
                        </th>
                        <th scope="col" rowspan="2" class="px-2 md:px-4 py-2 md:py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider sticky left-[80px] md:left-[150px] bg-gray-50 z-20 border-r min-w-[70px] md:min-w-[120px]">
                            <div>Course</div>
                        </th>
                        <th scope="col" rowspan="2" class="px-2 md:px-4 py-2 md:py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider sticky left-[150px] md:left-[270px] bg-gray-50 z-20 border-r min-w-[70px] md:min-w-[120px]">
                            <div>Center</div>
                        </th>

                        <th colspan="4" class="px-2 md:px-4 py-2 md:py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider border-l">
                            Payment Status
                        </th>
                        
                        <?php for($m = 1; $m <= 4; $m++): ?>
                            <th colspan="4" class="px-2 md:px-4 py-2 md:py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider border-l">
                                <div class="flex flex-col items-center">
                                    <span class="font-bold text-gray-700 text-xs md:text-sm">Month <?php echo e($m); ?></span>
                                    <span class="text-xs md:text-sm text-gray-500 font-normal mt-0.5 md:mt-1">W<?php echo e((($m-1)*4)+1); ?>-<?php echo e($m*4); ?></span>
                                </div>
                            </th>
                        <?php endfor; ?>
                        
                        <th scope="col" rowspan="2" class="px-2 md:px-4 py-2 md:py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider border-l">
                            Presence %
                        </th>
                    </tr>
                    
                    <!-- Second Header: Week Labels -->
                    <tr class="bg-gray-100">
                        <?php for($m = 1; $m <= 4; $m++): ?>
                            <th class="px-1.5 md:px-3 py-1.5 md:py-2 text-center text-xs font-medium text-gray-600 border-l">
                                <div class="text-xs md:text-sm">M<?php echo e($m); ?></div>
                            </th>
                        <?php endfor; ?>

                        <?php for($w = 1; $w <= 16; $w++): ?>
                            <th class="px-1.5 md:px-3 py-1.5 md:py-2 text-center text-xs font-medium text-gray-600 border-l">
                                <div class="flex flex-col items-center">
                                    <span class="font-semibold text-xs md:text-sm">W<?php echo e($w); ?></span>
                                </div>
                            </th>
                        <?php endfor; ?>
                        <th class="px-2 md:px-4 py-1.5 md:py-2"></th>
                    </tr>
                </thead>
                
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <!-- Student Info -->
                        <td class="px-2 md:px-4 py-2 md:py-3 whitespace-nowrap sticky left-0 bg-white z-10 border-r min-w-[80px] md:min-w-[150px]">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-6 w-6 md:h-8 md:w-8 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold text-xs">
                                        <?php echo e(substr($student->name, 0, 2)); ?>

                                    </span>
                                </div>
                                <div class="ml-2 md:ml-3">
                                    <div class="text-xs md:text-sm font-medium text-gray-900 truncate max-w-[100px] md:max-w-none">
                                        <?php echo e($student->name); ?>

                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Course Info -->
                        <td class="px-2 md:px-4 py-2 md:py-3 whitespace-nowrap sticky left-[80px] md:left-[150px] bg-white z-10 border-r min-w-[70px] md:min-w-[120px]">
                            <div class="text-xs md:text-sm text-gray-900 truncate"><?php echo e($student->course->name ?? '-'); ?></div>
                        </td>
                        
                        <!-- Center Info -->
                        <td class="px-2 md:px-4 py-2 md:py-3 whitespace-nowrap sticky left-[150px] md:left-[270px] bg-white z-10 border-r min-w-[70px] md:min-w-[120px]">
                            <div class="text-xs md:text-sm text-gray-900 truncate"><?php echo e($student->center->name ?? '-'); ?></div>
                        </td>
                        
                        <!-- Payment Status -->
                        <?php
                            $paymentStatus = $stats[$student->id]['payment_status'] ?? [];
                        ?>
                        <?php for($m = 1; $m <= 4; $m++): ?>
                            <td class="px-1.5 md:px-3 py-2 md:py-3 text-center border-l">
                                <span class="px-1.5 md:px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e(($paymentStatus[$m] ?? 'Unpaid') == 'Paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($paymentStatus[$m] ?? 'Unpaid'); ?>

                                </span>
                            </td>
                        <?php endfor; ?>

                        <!-- 16 Week Boxes -->
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
                                $title = "Week ".($i+1)."\\n";
                                if($start && $end) $title .= "Period: $start to $end\\n";
                                $title .= "Attendances: $count\\n";
                                $title .= "Status: ".($attended ? 'Attended' : 'Absent');
                            ?>

                            <td class="px-1.5 md:px-3 py-2 md:py-3 text-center border-l group relative">
                                <div class="w-4 h-4 md:w-6 md:h-6 mx-auto rounded-lg shadow-sm cursor-help hover:shadow-md transition-shadow duration-200"
                                     style="background-color: <?php echo e($attended ? '#16a34a' : '#ef4444'); ?>;"
                                     data-tooltip="<?php echo e($title); ?>">
                                </div>
                                <!-- Tooltip -->
                                <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-opacity duration-200 bottom-full left-1/2 transform -translate-x-1/2 mb-1 md:mb-2 px-2 py-1 md:px-3 md:py-2 bg-gray-900 text-white text-xs rounded-lg whitespace-pre-line min-w-[150px] md:min-w-[200px]">
                                    <?php echo e(str_replace('\\n', "\n", $title)); ?>

                                    <div class="absolute top-full left-1/2 transform -translate-x-1/2 -mt-0.5 md:-mt-1">
                                        <div class="w-1.5 h-1.5 md:w-2 md:h-2 bg-gray-900 rotate-45"></div>
                                    </div>
                                </div>
                            </td>
                        <?php endfor; ?>
                        
                        <!-- Percentage -->
                        <?php
                            $st = $stats[$student->id] ?? ['percent' => 0];
                            $percent = $st['percent'] ?? 0;
                        ?>
                        <td class="px-2 md:px-4 py-2 md:py-3 whitespace-nowrap text-center border-l">
                            <div class="flex items-center justify-center space-x-1.5 md:space-x-2">
                                <div class="w-12 md:w-20 bg-gray-200 rounded-full h-1.5 md:h-2">
                                    <div class="bg-green-600 h-1.5 md:h-2 rounded-full" style="width: <?php echo e(min($percent, 100)); ?>%"></div>
                                </div>
                                <span class="text-xs md:text-sm font-semibold <?php echo e($percent >= 75 ? 'text-green-600' : ($percent >= 50 ? 'text-yellow-600' : 'text-red-600')); ?>">
                                    <?php echo e($percent); ?>%
                                </span>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="20" class="px-4 py-8 md:px-6 md:py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-300 mb-3 md:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="text-gray-500 text-base md:text-lg font-medium">No students found</p>
                                <p class="text-gray-400 mt-1 text-xs md:text-sm">Try adjusting your filter</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Monthly Payment Report Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-4 py-3 md:px-6 md:py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base md:text-lg font-semibold text-gray-900">Monthly Payment Report</h2>
                    <p class="text-xs md:text-sm text-gray-600 mt-0.5 md:mt-1">Payment records grouped by month</p>
                </div>
            </div>
        </div>
        
        <div class="divide-y divide-gray-200">
            <?php $__empty_1 = true; $__currentLoopData = $paymentReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $payments): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $monthLabel = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
                    $monthTotal = $payments->sum('amount');
                ?>
                
                <div class="p-4 md:p-6 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-3 md:mb-4">
                        <div class="mb-2 md:mb-0">
                            <h3 class="text-sm md:text-base font-semibold text-gray-900"><?php echo e($monthLabel); ?></h3>
                            <p class="text-xs md:text-sm text-gray-600 mt-0.5"><?php echo e($payments->count()); ?> payment records</p>
                        </div>
                        <div class="text-left md:text-right">
                            <div class="text-base md:text-lg font-bold text-gray-900">Rs. <?php echo e(number_format($monthTotal, 2)); ?></div>
                            <div class="text-xs md:text-sm text-gray-600">Total amount</div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto -mx-4 md:mx-0">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Student
                                    </th>
                                    <th scope="col" class="px-3 md:px-4 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Center
                                    </th>
                                    <th scope="col" class="px-3 md:px-4 py-2 md:py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payment (Rs.)
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                                        <div class="text-xs md:text-sm font-medium text-gray-900 truncate max-w-[120px] md:max-w-none">
                                            <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?>

                                        </div>
                                    </td>
                                    <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap">
                                        <div class="text-xs md:text-sm text-gray-900 truncate max-w-[100px] md:max-w-none">
                                            <?php echo e($row->center_name ?? 'N/A'); ?>

                                        </div>
                                    </td>
                                    <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap text-right">
                                        <div class="text-xs md:text-sm font-medium text-gray-900">
                                            <?php echo e(number_format($row->amount, 2)); ?>

                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                
                                <!-- Month Total Row -->
                                <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <td colspan="2" class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap text-right font-semibold text-gray-700 text-xs md:text-sm">
                                        Month Total:
                                    </td>
                                    <td class="px-3 md:px-4 py-2 md:py-3 whitespace-nowrap text-right">
                                        <div class="text-sm md:text-lg font-bold text-gray-900">
                                            Rs. <?php echo e(number_format($monthTotal, 2)); ?>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-8 md:p-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-300 mb-3 md:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 text-base md:text-lg font-medium">No payment records found</p>
                    <p class="text-gray-400 mt-1 text-xs md:text-sm">Monthly payment data will appear here when available.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Proper sticky positioning for table headers and columns */
    .sticky {
        position: sticky;
        background: inherit;
    }
    
    /* Ensure proper stacking context */
    .sticky-left {
        left: 0;
        z-index: 20;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    
    /* Fix for mobile - ensure sticky works */
    @supports (position: sticky) or (position: -webkit-sticky) {
        .sticky {
            position: -webkit-sticky;
            position: sticky;
        }
    }
    
    /* Tooltip styling */
    [data-tooltip] {
        position: relative;
    }
    
    [data-tooltip]:hover::before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 6px 10px;
        background: rgba(17, 24, 39, 0.95);
        color: white;
        font-size: 11px;
        border-radius: 4px;
        white-space: pre-line;
        z-index: 1000;
        min-width: 150px;
        margin-bottom: 6px;
        pointer-events: none;
    }
    
    [data-tooltip]:hover::after {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        border-width: 5px;
        border-style: solid;
        border-color: rgba(17, 24, 39, 0.95) transparent transparent transparent;
        margin-bottom: 1px;
        pointer-events: none;
    }
    
    /* Custom scrollbar for better mobile experience */
    .overflow-x-auto::-webkit-scrollbar {
        height: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 2px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 2px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* Mobile optimizations */
    @media (max-width: 640px) {
        .matrix-scroll {
            font-size: 0.7rem;
        }
        
        .px-2 {
            padding-left: 0.25rem;
            padding-right: 0.25rem;
        }
        
        .py-2 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        
        .min-w-\[70px\] {
            min-width: 60px;
        }
        
        .min-w-\[80px\] {
            min-width: 70px;
        }
        
        .sticky {
            left: 0 !important;
        }
        
        .sticky.left-\[80px\] {
            left: 70px !important;
        }
        
        .sticky.left-\[150px\] {
            left: 140px !important;
        }
        
        .w-4 {
            width: 0.875rem;
            height: 0.875rem;
        }
        
        .h-6 {
            height: 1.25rem;
            width: 1.25rem;
        }
        
        .ml-2 {
            margin-left: 0.25rem;
        }
        
        /* Hide some text on very small screens */
        .text-xs {
            font-size: 0.6rem;
        }
        
        /* Adjust progress bar */
        .w-12 {
            width: 2.5rem;
        }
        
        .h-1\.5 {
            height: 0.25rem;
        }
        
        /* Make table cells more compact */
        td, th {
            padding-left: 0.25rem !important;
            padding-right: 0.25rem !important;
        }
    }
    
    @media (max-width: 768px) {
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }
        
        .matrix-scroll {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            width: calc(100% + 1rem);
        }
        
        .min-w-\[70px\] {
            min-width: 65px;
        }
        
        .min-w-\[80px\] {
            min-width: 75px;
        }
        
        .sticky {
            left: 0 !important;
        }
        
        .sticky.left-\[80px\] {
            left: 75px !important;
        }
        
        .sticky.left-\[150px\] {
            left: 140px !important;
        }
    }
    
    /* Ensure table cells have proper background when sticky */
    .bg-white.sticky {
        background-color: white;
    }
    
    .bg-gray-50.sticky {
        background-color: #f9fafb;
    }

    /* Wrapper for the attendance matrix: horizontal scroll, but allow vertical overflow */
    .matrix-scroll {
        overflow-x: auto;
        overflow-y: visible;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Touch-friendly styles */
    @media (hover: none) and (pointer: coarse) {
        [data-tooltip] {
            cursor: pointer;
        }
        
        [data-tooltip]:active::before,
        [data-tooltip]:focus::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 8px 12px;
            background: rgba(17, 24, 39, 0.95);
            color: white;
            font-size: 12px;
            border-radius: 6px;
            white-space: pre-line;
            z-index: 1000;
            min-width: 180px;
            margin-bottom: 8px;
            pointer-events: none;
        }
        
        [data-tooltip]:active::after,
        [data-tooltip]:focus::after {
            content: '';
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 6px;
            border-style: solid;
            border-color: rgba(17, 24, 39, 0.95) transparent transparent transparent;
            margin-bottom: 2px;
            pointer-events: none;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit filter on course change
        const courseFilter = document.querySelector('select[name="course_id"]');
        const filterForm = document.querySelector('form[method="GET"]');
        
        if (courseFilter && filterForm) {
            courseFilter.addEventListener('change', function() {
                setTimeout(() => {
                    filterForm.submit();
                }, 300);
            });
        }
        
        // Fix for mobile: adjust sticky positions based on screen size
        function adjustStickyColumns() {
            const isMobile = window.innerWidth < 768;
            const studentColumns = document.querySelectorAll('[class*="sticky left-"]');
            
            if (isMobile) {
                // Calculate positions based on actual column widths
                const firstCol = document.querySelector('.sticky.left-0');
                const secondCol = document.querySelector('.sticky.left-\\[80px\\]');
                const thirdCol = document.querySelector('.sticky.left-\\[150px\\]');
                
                if (firstCol && secondCol && thirdCol) {
                    const firstWidth = firstCol.offsetWidth;
                    const secondWidth = secondCol.offsetWidth;
                    
                    // Set positions based on actual widths
                    secondCol.style.left = firstWidth + 'px';
                    thirdCol.style.left = (firstWidth + secondWidth) + 'px';
                }
            } else {
                // On desktop, restore proper left positions
                studentColumns.forEach(col => {
                    const classes = col.className;
                    if (classes.includes('left-[150px]')) {
                        col.style.left = '150px';
                    } else if (classes.includes('left-[270px]')) {
                        col.style.left = '270px';
                    } else if (classes.includes('left-0')) {
                        col.style.left = '0';
                    }
                });
            }
        }
        
        // Initialize tooltips with mobile support
        const weekCells = document.querySelectorAll('[data-tooltip]');
        weekCells.forEach(cell => {
            // Mobile touch support
            cell.addEventListener('touchstart', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Hide all other tooltips first
                document.querySelectorAll('.group .absolute').forEach(t => {
                    t.classList.add('invisible', 'opacity-0');
                });
                
                // Toggle current tooltip
                const tooltip = this.nextElementSibling;
                if (tooltip) {
                    const isVisible = !tooltip.classList.contains('invisible');
                    
                    if (!isVisible) {
                        tooltip.classList.remove('invisible', 'opacity-0');
                        tooltip.classList.add('visible', 'opacity-100');
                        
                        // Auto-hide after 3 seconds on mobile
                        setTimeout(() => {
                            tooltip.classList.add('invisible', 'opacity-0');
                            tooltip.classList.remove('visible', 'opacity-100');
                        }, 3000);
                    } else {
                        tooltip.classList.add('invisible', 'opacity-0');
                        tooltip.classList.remove('visible', 'opacity-100');
                    }
                }
            }, { passive: false });
        });
        
        // Close tooltips when tapping outside
        document.addEventListener('touchstart', function(e) {
            if (!e.target.closest('[data-tooltip]')) {
                document.querySelectorAll('.group .absolute').forEach(tooltip => {
                    tooltip.classList.add('invisible', 'opacity-0');
                    tooltip.classList.remove('visible', 'opacity-100');
                });
            }
        });
        
        // Adjust columns on load and resize
        setTimeout(adjustStickyColumns, 100);
        window.addEventListener('resize', adjustStickyColumns);
        
        // Force scroll to start position for better mobile experience
        setTimeout(() => {
            const tableContainer = document.querySelector('.matrix-scroll');
            if (tableContainer) {
                tableContainer.scrollLeft = 0;
            }
        }, 150);
        
        // Prevent horizontal scroll when vertical scrolling on mobile
        let touchStartX = 0;
        let touchStartY = 0;
        
        document.addEventListener('touchstart', function(e) {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        }, { passive: true });
        
        document.addEventListener('touchmove', function(e) {
            if (!e.target.closest('.matrix-scroll') && !e.target.closest('.overflow-x-auto')) {
                return;
            }
            
            const touchX = e.touches[0].clientX;
            const touchY = e.touches[0].clientY;
            const diffX = Math.abs(touchX - touchStartX);
            const diffY = Math.abs(touchY - touchStartY);
            
            // If vertical scrolling is more dominant, prevent horizontal scroll
            if (diffY > diffX) {
                e.preventDefault();
            }
        }, { passive: false });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Project\Student Management System\resources\views/reception/reports/index.blade.php ENDPATH**/ ?>