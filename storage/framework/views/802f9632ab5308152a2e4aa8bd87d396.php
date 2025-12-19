<?php $__env->startSection('header', 'Attendance Records'); ?>
<?php $__env->startSection('title', 'Attendance Records'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
    <!-- Header Section -->
    <div class="mb-4 md:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-3 sm:mb-0">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900">Attendance Records</h1>
                <p class="mt-1 text-xs md:text-sm text-gray-600">Track and manage student attendance</p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="<?php echo e(route('reception.attendance.scan')); ?>" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    Scan QR Code
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-4 mb-4 md:mb-6">
        <!-- Present Today -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4 lg:p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 p-2 md:p-3 rounded-lg mr-2 md:mr-3 lg:mr-4 flex-shrink-0">
                    <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs md:text-sm text-gray-600">Present Today</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900"><?php echo e($todayCount ?? 0); ?></p>
                </div>
            </div>
        </div>

        <!-- Courses Today -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4 lg:p-6">
            <div class="flex items-center">
                <div class="bg-green-100 p-2 md:p-3 rounded-lg mr-2 md:mr-3 lg:mr-4 flex-shrink-0">
                    <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs md:text-sm text-gray-600">Courses Today</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900"><?php echo e($uniqueCourses ?? 0); ?></p>
                </div>
            </div>
        </div>

        <!-- Last Scan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4 lg:p-6">
            <div class="flex items-center">
                <div class="bg-yellow-100 p-2 md:p-3 rounded-lg mr-2 md:mr-3 lg:mr-4 flex-shrink-0">
                    <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-xs md:text-sm text-gray-600">Last Scan</p>
                    <p class="text-base md:text-lg lg:text-xl font-bold text-gray-900 truncate">
                        <?php echo e($latestAttendance ? $latestAttendance->attended_at->format('h:i A') : 'No scans yet'); ?>

                    </p>
                    <p class="text-xs text-gray-500 mt-0.5">Today</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4 lg:p-6 mb-4 md:mb-6">
        <h3 class="text-sm md:text-base lg:text-lg font-semibold text-gray-900 mb-3 md:mb-4 pb-2 md:pb-3 border-b border-gray-200">Search & Filters</h3>
        
        <form method="GET" action="<?php echo e(route('reception.attendance.index')); ?>">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                        Search Student
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2 md:pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="<?php echo e($search); ?>"
                               placeholder="Search by name or ID"
                               class="block w-full pl-8 md:pl-10 pr-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                    </div>
                </div>

                <!-- Course Filter -->
                <div>
                    <label for="course" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                        Course
                    </label>
                    <select name="course" id="course"
                            class="block w-full px-2 py-1.5 md:px-3 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base appearance-none">
                        <option value="">All Courses</option>
                        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($course->id); ?>" <?php echo e($selected_course == $course->id ? 'selected' : ''); ?>>
                                <?php echo e($course->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <label for="date" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                        Date
                    </label>
                    <input type="date" name="date" id="date" value="<?php echo e($selected_date); ?>"
                           class="block w-full px-2 py-1.5 md:px-3 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                </div>

                <!-- Action Buttons -->
                <div class="md:col-span-4 flex items-end space-x-2 md:space-x-3">
                    <a href="<?php echo e(route('reception.attendance.index')); ?>" 
                       class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base w-full md:w-auto justify-center">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base w-full md:w-auto justify-center">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Attendance Records -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 bg-gray-50 border-b border-gray-200 flex flex-col sm:flex-row sm:justify-between sm:items-center">
            <div class="mb-2 sm:mb-0">
                <h3 class="text-sm md:text-base lg:text-lg font-semibold text-gray-900">Attendance Records</h3>
                <p class="text-xs md:text-sm text-gray-600 mt-0.5">Today: <?php echo e(now()->format('F d, Y')); ?></p>
            </div>
            <?php if(isset($attendances) && count($attendances)): ?>
            <div class="text-xs md:text-sm text-gray-700">
                <span class="font-semibold"><?php echo e($attendances->total()); ?></span> records
            </div>
            <?php endif; ?>
        </div>

        <?php if($attendances && count($attendances)): ?>
            <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $records): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- Date Group Header - LARGER DATE -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-3 md:px-4 lg:px-6 py-3 md:py-4 lg:py-5 border-b border-blue-100">
                    <div class="flex items-center">
                        <div class="bg-white p-2 md:p-3 rounded-lg shadow-sm mr-2 md:mr-3 lg:mr-4 flex-shrink-0">
                            <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <!-- LARGER DATE -->
                            <h4 class="text-base md:text-lg lg:text-xl font-bold text-gray-900 truncate">
                                <?php echo e(\Carbon\Carbon::parse($date)->format('F d, Y')); ?>

                            </h4>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 mt-0.5 md:mt-1">
                                <span class="text-xs md:text-sm text-gray-600">
                                    <?php echo e(count($records)); ?> attendance<?php echo e(count($records) > 1 ? 's' : ''); ?>

                                </span>
                                <span class="hidden sm:inline text-gray-400">•</span>
                                <span class="text-xs md:text-sm text-gray-600">
                                    <?php echo e(\Carbon\Carbon::parse($date)->format('l')); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student
                                </th>
                                <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    Contact
                                </th>
                                <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                    Course
                                </th>
                                <!-- LARGER TIME COLUMN -->
                                <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Time
                                </th>
                                <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    M1
                                </th>
                                <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    M2
                                </th>
                                <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    M3
                                </th>
                                <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    M4
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- Student Info -->
                                <td class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-8 h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold text-xs md:text-sm">
                                                <?php echo e(substr($attendance->student->name, 0, 1)); ?>

                                            </span>
                                        </div>
                                        <div class="ml-2 md:ml-3 lg:ml-4 min-w-0">
                                            <div class="text-xs md:text-sm font-medium text-gray-900 truncate"><?php echo e($attendance->student->name); ?></div>
                                            <div class="text-xs text-gray-500 truncate"><?php echo e($attendance->student->registration_number); ?></div>
                                            <!-- Mobile: Show course and contact -->
                                            <div class="md:hidden mt-1">
                                                <div class="text-xs text-gray-700 truncate"><?php echo e($attendance->student->course->name ?? 'N/A'); ?></div>
                                                <div class="text-xs text-gray-500 truncate"><?php echo e($attendance->student->student_phone); ?></div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Contact -->
                                <td class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 whitespace-nowrap hidden md:table-cell">
                                    <div class="text-xs md:text-sm text-gray-900 truncate"><?php echo e($attendance->student->student_phone); ?></div>
                                </td>
                                
                                <!-- Course -->
                                <td class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 hidden lg:table-cell">
                                    <div class="text-xs md:text-sm font-medium text-gray-900 truncate"><?php echo e($attendance->student->course->name ?? 'N/A'); ?></div>
                                </td>
                                
                                <!-- Attendance Time - LARGER -->
                                <td class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 md:w-4 md:h-5 lg:w-5 lg:h-5 text-gray-400 mr-1.5 md:mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div class="min-w-0">
                                            <div class="text-sm md:text-base lg:text-lg font-bold text-gray-900 truncate">
                                                <?php echo e($attendance->attended_at->format('h:i A')); ?>

                                            </div>
                                            <div class="text-xs text-gray-500 truncate">
                                                <?php echo e($attendance->attended_at->format('M d')); ?>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <?php $__currentLoopData = $attendance->payment_status_by_month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td class="px-2 md:px-3 lg:px-4 py-2 md:py-3 lg:py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-1.5 py-0.5 md:px-2 md:py-1 rounded-full text-xs font-medium <?php echo e($status == 'Paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php if($status == 'Paid'): ?>
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-0.5 hidden sm:inline" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="hidden sm:inline">P</span>
                                        <span class="sm:hidden">P</span>
                                        <?php else: ?>
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-0.5 hidden sm:inline" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="hidden sm:inline">UP</span>
                                        <span class="sm:hidden">UP</span>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Pagination -->
            <div class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-xs md:text-sm text-gray-700 mb-3 sm:mb-0">
                        <?php if($attendances->total()): ?>
                        Showing <span class="font-semibold"><?php echo e($attendances->firstItem()); ?></span> to 
                        <span class="font-semibold"><?php echo e($attendances->lastItem()); ?></span> of 
                        <span class="font-semibold"><?php echo e($attendances->total()); ?></span> results
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex items-center">
                        <?php echo e($attendances->appends(request()->query())->onEachSide(1)->links()); ?>

                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-8 md:py-10 lg:py-12">
                <div class="mb-3 md:mb-4">
                    <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-3.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                    </svg>
                </div>
                <h3 class="text-sm md:text-base lg:text-lg font-semibold text-gray-900 mb-1.5 md:mb-2">No Attendance Records</h3>
                <p class="text-xs md:text-sm text-gray-600 mb-4 md:mb-6 max-w-md mx-auto px-4">
                    No attendance records found for the selected filters. Try scanning QR codes to record attendance.
                </p>
                <a href="<?php echo e(route('reception.attendance.scan')); ?>" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    Scan QR Code
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Mobile optimizations */
    @media (max-width: 640px) {
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
            margin-left: -0.5rem;
            margin-right: -0.5rem;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            width: calc(100% + 1rem);
        }
        
        table {
            font-size: 0.7rem;
        }
        
        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .text-xs {
            font-size: 0.65rem;
        }
        
        .h-8 {
            height: 1.5rem;
        }
        
        .w-8 {
            width: 1.5rem;
        }
        
        .ml-2 {
            margin-left: 0.25rem;
        }
        
        .text-sm {
            font-size: 0.75rem;
        }
        
        .text-base {
            font-size: 0.875rem;
        }
        
        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .md\:grid-cols-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .md\:col-span-2 {
            grid-column: span 2;
        }
        
        .md\:col-span-4 {
            grid-column: span 2;
        }
        
        .text-lg {
            font-size: 1rem;
        }
        
        .px-3 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .py-3 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .min-w-0 {
            min-width: 0;
        }
    }
    
    /* Tablet optimizations */
    @media (min-width: 769px) and (max-width: 1024px) {
        .md\:grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
        
        .md\:col-span-2 {
            grid-column: span 2;
        }
        
        .overflow-x-auto {
            font-size: 0.8rem;
        }
        
        .hidden.md\:table-cell {
            display: table-cell;
        }
        
        .hidden.lg\:table-cell {
            display: none;
        }
    }
    
    /* Scrollbar styling */
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
    
    /* Custom select styling */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit filters on change
    const courseFilter = document.getElementById('course');
    const dateFilter = document.getElementById('date');
    
    if (courseFilter) {
        courseFilter.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    // Make table rows more touch-friendly on mobile
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('touchstart', function() {
            this.style.backgroundColor = '#f9fafb';
        });
        
        row.addEventListener('touchend', function() {
            setTimeout(() => {
                this.style.backgroundColor = '';
            }, 150);
        });
    });
    
    // Adjust table columns on resize
    function adjustTableColumns() {
        const isMobile = window.innerWidth < 768;
        const isTablet = window.innerWidth >= 768 && window.innerWidth < 1024;
        
        if (isMobile) {
            // On mobile, hide some columns completely
            document.querySelectorAll('.hidden.md\\:table-cell, .hidden.lg\\:table-cell').forEach(cell => {
                cell.style.display = 'none';
            });
        } else if (isTablet) {
            // On tablet, show md columns, hide lg columns
            document.querySelectorAll('.hidden.md\\:table-cell').forEach(cell => {
                cell.style.display = 'table-cell';
            });
            document.querySelectorAll('.hidden.lg\\:table-cell').forEach(cell => {
                cell.style.display = 'none';
            });
        } else {
            // On desktop, show all columns
            document.querySelectorAll('.hidden.md\\:table-cell, .hidden.lg\\:table-cell').forEach(cell => {
                cell.style.display = 'table-cell';
            });
        }
    }
    
    // Initial adjustment
    adjustTableColumns();
    
    // Adjust on resize
    window.addEventListener('resize', adjustTableColumns);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Project\Student Management System\resources\views/reception/attendance/index.blade.php ENDPATH**/ ?>