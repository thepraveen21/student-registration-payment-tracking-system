<?php $__env->startSection('header', 'Students'); ?>
<?php $__env->startSection('title', 'Student Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
    <!-- Header Section -->
    <div class="mb-4 md:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-3 sm:mb-0">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900">Student Management</h1>
                <p class="mt-1 text-xs md:text-sm text-gray-600">Manage all student records and information</p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="<?php echo e(route('reception.students.create')); ?>" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Student
                </a>
            </div>
        </div>
        
        <!-- Success Message -->
        <?php if(session('success')): ?>
        <div class="mt-4 md:mt-6 p-3 md:p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm" role="alert">
            <div class="flex items-center">
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
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 lg:gap-6 mb-4 md:mb-6 lg:mb-8">
        <div class="bg-white rounded-xl shadow-md p-3 md:p-4 lg:p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 p-2 md:p-3 rounded-lg">
                    <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-2 md:ml-3 lg:ml-4">
                    <p class="text-xs md:text-sm font-medium text-gray-600">Total Students</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900"><?php echo e($students->total()); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-3 md:p-4 lg:p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 p-2 md:p-3 rounded-lg">
                    <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-2 md:ml-3 lg:ml-4">
                    <p class="text-xs md:text-sm font-medium text-gray-600">Active</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900"><?php echo e($totalActiveStudents); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-3 md:p-4 lg:p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-red-100 p-2 md:p-3 rounded-lg">
                    <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-2 md:ml-3 lg:ml-4">
                    <p class="text-xs md:text-sm font-medium text-gray-600">Inactive</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900"><?php echo e($totalInactiveStudents); ?></p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-md p-3 md:p-4 lg:p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-purple-100 p-2 md:p-3 rounded-lg">
                    <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="ml-2 md:ml-3 lg:ml-4">
                    <p class="text-xs md:text-sm font-medium text-gray-600">This Month</p>
                    <p class="text-lg md:text-xl lg:text-2xl font-bold text-gray-900"><?php echo e($totalThisMonthStudents); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 md:mb-6 p-3 md:p-4 lg:p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 md:gap-4">
            <!-- Search Box -->
            <form action="<?php echo e(route('reception.students.index')); ?>" method="GET" class="flex-grow lg:max-w-md">
                <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                <input type="hidden" name="rows" value="<?php echo e(request('rows', 10)); ?>">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-2 md:pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 md:h-5 md:h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="search" name="search" value="<?php echo e(request('search')); ?>"
                           placeholder="Search students..."
                           class="block w-full pl-8 md:pl-10 pr-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                </div>
            </form>
            
            <!-- Filter Controls -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 md:gap-3">
                <!-- Status Filter Buttons -->
                <div class="flex items-center gap-1.5 md:gap-2 bg-gray-100 p-1 rounded-lg">
                    <a href="<?php echo e(route('reception.students.index', array_merge(request()->except('status'), ['search' => request('search'), 'rows' => request('rows', 10)]))); ?>" 
                       class="px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm font-medium rounded-md transition-all duration-200 <?php echo e(!request('status') ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'); ?>">
                        All
                    </a>
                    <a href="<?php echo e(route('reception.students.index', array_merge(request()->all(), ['status' => 'active']))); ?>" 
                       class="px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm font-medium rounded-md transition-all duration-200 <?php echo e(request('status') == 'active' ? 'bg-white text-green-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'); ?>">
                        Active
                    </a>
                    <a href="<?php echo e(route('reception.students.index', array_merge(request()->all(), ['status' => 'inactive']))); ?>" 
                       class="px-3 py-1.5 md:px-4 md:py-2 text-xs md:text-sm font-medium rounded-md transition-all duration-200 <?php echo e(request('status') == 'inactive' ? 'bg-white text-red-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'); ?>">
                        Inactive
                    </a>
                </div>
                
                <!-- Rows Per Page -->
                <form action="<?php echo e(route('reception.students.index')); ?>" method="GET" class="relative">
                    <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                    <select name="rows" onchange="this.form.submit()" class="appearance-none bg-white border border-gray-300 rounded-lg py-1.5 md:py-2 pl-2 md:pl-3 pr-7 md:pr-8 text-xs md:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <option value="10" <?php echo e(request('rows', 10) == 10 ? 'selected' : ''); ?>>10 rows</option>
                        <option value="25" <?php echo e(request('rows') == 25 ? 'selected' : ''); ?>>25 rows</option>
                        <option value="50" <?php echo e(request('rows') == 50 ? 'selected' : ''); ?>>50 rows</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 md:px-2 text-gray-700">
                        <svg class="fill-current h-3 w-3 md:h-4 md:w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Student
                        </th>
                        <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">
                            Contact Information
                        </th>
                        <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                            Phone Numbers
                        </th>
                        <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-3 md:px-4 lg:px-6 py-2 md:py-3 lg:py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <!-- Student Info -->
                        <td class="px-3 md:px-4 lg:px-6 py-3 md:py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 md:h-9 md:w-9 lg:h-10 lg:w-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold text-xs md:text-sm">
                                        <?php echo e(substr($student->first_name, 0, 1)); ?><?php echo e(substr($student->last_name, 0, 1)); ?>

                                    </span>
                                </div>
                                <div class="ml-2 md:ml-3 lg:ml-4 min-w-0">
                                    <div class="text-xs md:text-sm font-medium text-gray-900 truncate">
                                        <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>

                                    </div>
                                    <div class="text-xs text-gray-500 truncate">
                                        <?php echo e($student->registration_number); ?>

                                    </div>
                                    <!-- Mobile: Show email and phone -->
                                    <div class="md:hidden mt-1">
                                        <div class="text-xs text-gray-700 truncate"><?php echo e($student->email); ?></div>
                                        <div class="text-xs text-gray-500 truncate"><?php echo e($student->student_phone); ?></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Contact Information -->
                        <td class="px-3 md:px-4 lg:px-6 py-3 md:py-4 hidden md:table-cell">
                            <div class="text-xs md:text-sm text-gray-900 truncate"><?php echo e($student->email); ?></div>
                        </td>
                        
                        <!-- Phone Numbers -->
                        <td class="px-3 md:px-4 lg:px-6 py-3 md:py-4 whitespace-nowrap hidden lg:table-cell">
                            <div class="text-xs md:text-sm text-gray-900 truncate"><?php echo e($student->student_phone); ?></div>
                            <div class="text-xs text-gray-500 truncate"><?php echo e($student->parent_phone ?? 'No Parent Phone'); ?></div>
                        </td>
                        
                        <!-- Status -->
                        <td class="px-3 md:px-4 lg:px-6 py-3 md:py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 md:px-3 md:py-1 rounded-full text-xs font-medium <?php echo e($student->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php if($student->status == 'active'): ?>
                                <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <?php else: ?>
                                <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <?php endif; ?>
                                <span class="hidden sm:inline"><?php echo e(ucfirst($student->status)); ?></span>
                                <span class="sm:hidden"><?php echo e(substr(ucfirst($student->status), 0, 1)); ?></span>
                            </span>
                        </td>
                        
                        <!-- Actions -->
                        <td class="px-3 md:px-4 lg:px-6 py-3 md:py-4 whitespace-nowrap text-xs md:text-sm font-medium">
                            <div class="flex items-center space-x-1 md:space-x-2">
                                <a href="<?php echo e(route('reception.students.show', $student)); ?>" 
                                   class="inline-flex items-center px-2 py-1 md:px-3 md:py-1.5 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg class="w-3 h-3 md:w-4 md:h-4 mr-0.5 md:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span class="hidden md:inline">View</span>
                                </a>
                                <a href="<?php echo e(route('reception.students.edit', $student)); ?>" 
                                   class="inline-flex items-center px-2 py-1 md:px-3 md:py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    <svg class="w-3 h-3 md:w-4 md:h-4 mr-0.5 md:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="hidden md:inline">Edit</span>
                                </a>
                                <form action="<?php echo e(route('reception.students.destroy', $student)); ?>" method="POST" class="inline-block">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this student?')"
                                            class="inline-flex items-center px-2 py-1 md:px-3 md:py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-0.5 md:mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span class="hidden md:inline">Delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-8 md:px-6 md:py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-300 mb-3 md:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="text-gray-500 text-base md:text-lg font-medium">No students found</p>
                                <p class="text-gray-400 mt-1 text-xs md:text-sm">Try adjusting your search or filter</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($students->count()): ?>
        <div class="px-3 md:px-4 lg:px-6 py-3 md:py-4 bg-gray-50 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="text-xs md:text-sm text-gray-700 mb-3 md:mb-0">
                    Showing <span class="font-semibold"><?php echo e($students->firstItem()); ?></span> to 
                    <span class="font-semibold"><?php echo e($students->lastItem()); ?></span> of 
                    <span class="font-semibold"><?php echo e($students->total()); ?></span> results
                </div>
                
                <div class="flex items-center">
                    <?php echo e($students->appends(request()->query())->onEachSide(1)->links()); ?>

                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .page-item .page-link {
        padding: 0.25rem 0.5rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #4B5563;
        background-color: white;
        border: 1px solid #D1D5DB;
        transition: all 0.2s;
        font-size: 0.75rem;
    }
    
    @media (min-width: 768px) {
        .page-item .page-link {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }
    }
    
    .page-item:first-child .page-link {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    
    .page-item:last-child .page-link {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    
    .page-item.active .page-link {
        background-color: #3B82F6;
        border-color: #3B82F6;
        color: white;
    }
    
    .page-link:hover {
        background-color: #F9FAFB;
        color: #1F2937;
    }
    
    .page-item.active .page-link:hover {
        background-color: #3B82F6;
        color: white;
    }
    
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
        
        .py-3 {
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
        
        .space-x-1 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(0.25rem * var(--tw-space-x-reverse));
            margin-left: calc(0.25rem * calc(1 - var(--tw-space-x-reverse)));
        }
    }
    
    @media (max-width: 768px) {
        .lg\:grid-cols-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .text-lg {
            font-size: 1rem;
        }
        
        .px-3 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .py-2 {
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
        .lg\:grid-cols-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .overflow-x-auto {
            font-size: 0.8rem;
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Project\Student Management System\resources\views/reception/students/index.blade.php ENDPATH**/ ?>