<?php $__env->startSection('header', 'Monthly Payments'); ?>
<?php $__env->startSection('title', 'Monthly Payments'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
    <!-- Header Section -->
    <div class="mb-4 md:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-3 sm:mb-0">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900">Monthly Payments</h1>
                <p class="mt-1 text-xs md:text-sm text-gray-600">View and manage student monthly payment records</p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="<?php echo e(route('reception.payments.create')); ?>" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Record Payment
                </a>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    <?php if(session('success')): ?>
    <div class="mb-4 md:mb-6 p-3 md:p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm" role="alert">
        <div class="flex items-start md:items-center">
            <div class="flex-shrink-0">
                <svg class="h-4 w-4 md:h-5 md:w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-2 md:ml-3">
                <p class="text-xs md:text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    

    <!-- Summary Stats -->
    <?php if($monthlyPayments->count()): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-4 md:mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4">
            <div class="flex items-center">
                <div class="bg-blue-100 p-2 md:p-3 rounded-lg mr-3 md:mr-4">
                    <svg class="w-4 h-4 md:w-6 md:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs md:text-sm text-gray-600">Total Payments</p>
                    <p class="text-lg md:text-xl font-bold text-gray-900"><?php echo e($monthlyPayments->count()); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4">
            <div class="flex items-center">
                <div class="bg-green-100 p-2 md:p-3 rounded-lg mr-3 md:mr-4">
                    <svg class="w-4 h-4 md:w-6 md:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs md:text-sm text-gray-600">Total Amount</p>
                    <p class="text-lg md:text-xl font-bold text-green-700">Rs. <?php echo e(number_format($monthlyPayments->sum('amount'), 2)); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4">
            <div class="flex items-center">
                <div class="bg-purple-100 p-2 md:p-3 rounded-lg mr-3 md:mr-4">
                    <svg class="w-4 h-4 md:w-6 md:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-3.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs md:text-sm text-gray-600">Unique Students</p>
                    <p class="text-lg md:text-xl font-bold text-gray-900"><?php echo e($monthlyPayments->pluck('student_id')->unique()->count()); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4">
            <div class="flex items-center">
                <div class="bg-amber-100 p-2 md:p-3 rounded-lg mr-3 md:mr-4">
                    <svg class="w-4 h-4 md:w-6 md:h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs md:text-sm text-gray-600">Date Range</p>
                    <?php
                        $dates = $monthlyPayments->pluck('payment_date')->sort();
                        $firstDate = $dates->first();
                        $lastDate = $dates->last();
                    ?>
                    <p class="text-xs md:text-sm font-medium text-gray-900 truncate">
                        <?php if($firstDate && $lastDate): ?>
                            <?php echo e($firstDate->format('M d')); ?> - <?php echo e($lastDate->format('M d, Y')); ?>

                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <!-- Filters Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6 mb-4 md:mb-6">
        <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-3 md:mb-4">Search & Filters</h3>
        
        <form method="GET" action="<?php echo e(route('reception.payments.index')); ?>">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 md:gap-4 lg:gap-6">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                        Search Student
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="<?php echo e(request('search')); ?>"
                               placeholder="Search by name or reg no..."
                               class="block w-full pl-9 md:pl-10 pr-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                    </div>
                </div>

                <!-- Course Filter -->
                <div>
                    <label for="course" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                        Course
                    </label>
                    <select name="course" id="course"
                            class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                        <option value="">All Courses</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course->id); ?>" <?php echo e(request('course') == $course->id ? 'selected' : ''); ?>>
                                <?php echo e($course->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Center Filter -->
                <div>
                    <label for="center" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                        Center
                    </label>
                    <select name="center" id="center"
                            class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                        <option value="">All Centers</option>
                        <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($center->id); ?>" <?php echo e(request('center') == $center->id ? 'selected' : ''); ?>>
                                <?php echo e($center->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:justify-end mt-4 md:mt-6 pt-4 md:pt-6 border-t border-gray-200 space-y-3 sm:space-y-0 sm:space-x-3">
                <a href="<?php echo e(route('reception.payments.index')); ?>" 
                   class="inline-flex items-center justify-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200 text-sm md:text-base order-2 sm:order-1">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear Filters
                </a>
                <button type="submit" 
                        class="inline-flex items-center justify-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base order-1 sm:order-2">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Payments List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-4 md:px-6 py-3 md:py-4 bg-gray-50 border-b border-gray-200 flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div class="mb-2 sm:mb-0">
                <h3 class="text-base md:text-lg font-semibold text-gray-900">Payment Records</h3>
                <p class="text-xs md:text-sm text-gray-600 mt-0.5">Grouped by payment date and time</p>
            </div>
            <?php if($monthlyPayments->count()): ?>
            <div class="text-xs md:text-sm text-gray-700">
                <span class="font-semibold"><?php echo e($monthlyPayments->count()); ?></span> records
            </div>
            <?php endif; ?>
        </div>

        <?php
            $grouped = $monthlyPayments->groupBy(fn($i) => $i->payment_date->format('Y-m-d'));
        ?>

        <?php $__empty_1 = true; $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <!-- Date Group Header - LARGER DATE/TIME ONLY -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 md:px-6 py-3 md:py-4 border-b border-blue-100">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                    <div class="flex items-start sm:items-center mb-2 sm:mb-0">
                        <div class="bg-white p-1.5 md:p-2 rounded-lg shadow-sm mr-2 md:mr-3 flex-shrink-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <!-- LARGER DATE -->
                            <h4 class="text-lg md:text-xl font-bold text-gray-900 truncate">
                                <?php echo e(\Carbon\Carbon::parse($date)->format('F d, Y')); ?>

                            </h4>
                            <div class="flex flex-col sm:flex-row sm:items-center mt-0.5 md:mt-1 space-y-1 sm:space-y-0">
                                <span class="text-xs md:text-sm text-gray-600">
                                    <?php echo e(count($records)); ?> payment<?php echo e(count($records) > 1 ? 's' : ''); ?>

                                </span>
                                <span class="hidden sm:inline mx-2 text-gray-400">•</span>
                                <span class="text-xs md:text-sm text-gray-600">
                                    Total: Rs. <?php echo e(number_format($records->sum('amount'), 2)); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-1 md:space-x-2 mt-2 sm:mt-0">
                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-medium whitespace-nowrap">
                            <?php echo e($records->pluck('student_id')->unique()->count()); ?> students
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment Cards for this time group -->
            <div class="divide-y divide-gray-100">
                <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="px-3 md:px-6 py-3 md:py-5 hover:bg-gray-50 transition-colors duration-150">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-3 md:gap-4">
                        <!-- Student Info -->
                        <div class="lg:w-1/4 mb-3 md:mb-0">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-100 to-indigo-200 rounded-xl flex items-center justify-center shadow-sm mr-3 md:mr-4">
                                    <span class="text-blue-700 font-bold text-base md:text-lg">
                                        <?php echo e(substr($pay->student->name, 0, 1)); ?>

                                    </span>
                                </div>
                                <div class="min-w-0 flex-grow">
                                    <h4 class="text-sm font-semibold text-gray-900 truncate">
                                        <?php echo e($pay->student->name); ?>

                                        <?php if($pay->updated_at->ne($pay->created_at)): ?>
                                            <span class="text-xs text-gray-500 font-normal">(edited)</span>
                                        <?php endif; ?>
                                    </h4>
                                    <p class="text-xs text-gray-600 mt-0.5 truncate"><?php echo e($pay->student->reg_no); ?></p>
                                    <div class="flex items-center mt-1 md:mt-2">
                                        <svg class="w-3 h-3 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span class="text-xs text-gray-600 truncate"><?php echo e($pay->course->name); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Center Info -->
                        <div class="lg:w-1/5 mb-3 md:mb-0">
                            <div class="flex items-center text-sm text-gray-700">
                                <svg class="w-3 h-3 md:w-4 md:h-4 text-gray-400 mr-1.5 md:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span class="truncate"><?php echo e($pay->student->center->name ?? 'N/A'); ?></span>
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="lg:w-2/5 mb-3 md:mb-0">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-3 md:p-4 border border-green-100">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Month</p>
                                        <div class="flex items-center mt-1">
                                            <span class="text-xs md:text-sm font-semibold text-gray-900 bg-white px-2 md:px-3 py-1 rounded-lg border border-gray-200">
                                                Month <?php echo e($pay->month_number); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</p>
                                        <p class="text-base md:text-lg font-bold text-green-700 mt-1">Rs. <?php echo e(number_format($pay->amount, 2)); ?></p>
                                    </div>
                                    <!-- PAYMENT TIME -->
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Time</p>
                                        <p class="text-base md:text-lg font-bold text-gray-900 mt-1 flex items-center">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <?php echo e($pay->payment_date->format('h:i A')); ?>

                                        </p>
                                    </div>
                                    <!-- LARGER DATE -->
                                    <div>
                                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Date</p>
                                        <p class="text-base md:text-lg font-bold text-gray-900 mt-1 truncate"><?php echo e($pay->payment_date->format('M d, Y')); ?></p>
                                    </div>
                                </div>
                                <?php if($pay->notes): ?>
                                <div class="mt-2 md:mt-3 pt-2 md:pt-3 border-t border-green-200">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Notes</p>
                                    <p class="text-xs text-gray-700 bg-white px-2 md:px-3 py-1.5 md:py-2 rounded border border-gray-200 line-clamp-2"><?php echo e($pay->notes); ?></p>
                                </div>
                                <?php endif; ?>
                                <?php if($pay->updated_at->ne($pay->created_at)): ?>
                                <div class="mt-2 md:mt-3 pt-2 md:pt-3 border-t border-green-200">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Last Edited</p>
                                    <p class="text-xs text-gray-700 truncate"><?php echo e($pay->updated_at->format('M d, Y, h:i A')); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Recorded By with Iconic Action Buttons -->
                        <div class="lg:w-1/5">
                            <div class="text-left lg:text-right">
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Recorded By</p>
                                <p class="text-sm font-medium text-gray-900 mt-1 truncate"><?php echo e($pay->recordedBy->name ?? 'N/A'); ?></p>
                                <p class="text-xs text-gray-500 mt-0.5">via Reception</p>
                                
                                <!-- Iconic Action Buttons -->
                                <div class="mt-3 md:mt-4 flex lg:justify-end space-x-2">
                                    <!-- Edit Button (Icon Only) -->
                                    <a href="<?php echo e(route('reception.payments.edit', $pay)); ?>" 
                                       class="inline-flex items-center p-1.5 md:p-2 border border-blue-300 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       title="Edit Payment">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    <!-- Delete Button (Icon Only) -->
                                    <form action="<?php echo e(route('reception.payments.destroy', $pay)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment?');" class="inline-block">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                class="inline-flex items-center p-1.5 md:p-2 border border-red-300 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                                title="Delete Payment">
                                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <!-- Empty State -->
            <div class="text-center py-8 md:py-12">
                <div class="mb-3 md:mb-4">
                    <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-1 md:mb-2">No Payment Records</h3>
                <p class="text-xs md:text-sm text-gray-600 mb-4 md:mb-6 max-w-md mx-auto px-4">
                    No monthly payments have been recorded yet. Start by recording a new payment.
                </p>
                <a href="<?php echo e(route('reception.payments.create')); ?>" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Record First Payment
                </a>
            </div>
        <?php endif; ?>

        <?php if($monthlyPayments->count()): ?>
            <!-- Pagination -->
            <div class="px-4 md:px-6 py-3 md:py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-xs md:text-sm text-gray-700 mb-3 sm:mb-0">
                        Showing <span class="font-semibold"><?php echo e($monthlyPayments->firstItem()); ?></span> to 
                        <span class="font-semibold"><?php echo e($monthlyPayments->lastItem()); ?></span> of 
                        <span class="font-semibold"><?php echo e($monthlyPayments->total()); ?></span> payments
                    </div>
                    <div class="flex items-center">
                        <?php echo e($monthlyPayments->appends(request()->query())->onEachSide(1)->links()); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Line clamp for description */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Mobile optimizations */
    @media (max-width: 640px) {
        .grid-cols-1.sm\:grid-cols-2 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .lg\:grid-cols-3 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .text-lg {
            font-size: 1.125rem;
        }
        
        .text-base {
            font-size: 0.875rem;
        }
        
        .px-3 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .py-3 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .gap-3 {
            gap: 0.5rem;
        }
        
        .mr-3 {
            margin-right: 0.5rem;
        }
        
        .w-10 {
            width: 2rem;
        }
        
        .h-10 {
            height: 2rem;
        }
        
        .text-base.font-bold {
            font-size: 1rem;
        }
        
        /* Iconic buttons on mobile */
        .p-1\.5 {
            padding: 0.25rem;
        }
        
        .w-4 {
            width: 0.875rem;
        }
        
        .h-4 {
            height: 0.875rem;
        }
    }
    
    @media (max-width: 768px) {
        .lg\:flex-row {
            flex-direction: column;
        }
        
        .lg\:w-1\/4,
        .lg\:w-1\/5,
        .lg\:w-2\/5 {
            width: 100%;
        }
        
        .bg-gradient-to-r.from-green-50.to-emerald-50 {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
            border-radius: 0;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .grid-cols-2 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .lg\:text-right {
            text-align: left;
        }
        
        .lg\:justify-end {
            justify-content: flex-start;
        }
    }
    
    @media (min-width: 768px) and (max-width: 1024px) {
        .lg\:grid-cols-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .lg\:w-1\/4 {
            width: 30%;
        }
        
        .lg\:w-1\/5 {
            width: 20%;
        }
        
        .lg\:w-2\/5 {
            width: 50%;
        }
    }
    
    /* Hover effects for iconic buttons */
    .border-blue-300:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
    
    .border-red-300:hover {
        border-color: #f87171;
        background-color: #fef2f2;
    }
    
    /* Smooth transitions */
    .transition-colors {
        transition-property: background-color, border-color, color;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 150ms;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Project\Student Management System\resources\views/reception/payments/index.blade.php ENDPATH**/ ?>