

<?php $__env->startSection('header', 'Add New Center'); ?>
<?php $__env->startSection('title', 'Center Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
    <!-- Header Section -->
    <div class="mb-4 md:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-3 sm:mb-0">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900">Add New Center</h1>
                <p class="mt-1 text-xs md:text-sm text-gray-600">Create a new training center location</p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="<?php echo e(url()->previous()); ?>" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Go Back
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

        <!-- Error Messages -->
        <?php if($errors->any()): ?>
        <div class="mt-4 md:mt-6 p-3 md:p-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-lg shadow-sm" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-4 w-4 md:h-5 md:w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-2 md:ml-3">
                    <h3 class="text-xs md:text-sm font-medium text-red-800">There were <?php echo e($errors->count()); ?> error(s) with your submission</h3>
                    <div class="mt-2 text-xs md:text-sm text-red-700">
                        <ul class="list-disc pl-4 md:pl-5 space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-3 md:px-4 lg:px-6 py-3 md:py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center">
                <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-gray-600 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h2 class="text-sm md:text-base lg:text-lg font-semibold text-gray-900">Center Details</h2>
            </div>
            <p class="text-xs md:text-sm text-gray-600 mt-1 ml-5 md:ml-8 lg:ml-9">Fill in the details to create a new center</p>
        </div>
        
        <div class="p-3 md:p-4 lg:p-6">
            <form action="<?php echo e(route('centers.store')); ?>" method="POST" class="space-y-4 md:space-y-5 lg:space-y-6">
                <?php echo csrf_field(); ?>

                <!-- Center Name Field -->
                <div class="space-y-1 md:space-y-2">
                    <label for="name" class="block text-xs md:text-sm font-medium text-gray-700">
                        Center Name
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2 md:pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="<?php echo e(old('name')); ?>"
                               class="block w-full pl-8 md:pl-10 pr-3 py-1.5 md:py-2 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Enter center name"
                               required
                               autofocus>
                    </div>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="flex items-center mt-1 text-red-600 text-xs md:text-sm">
                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e($message); ?>

                    </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Location Field -->
                <div class="space-y-1 md:space-y-2">
                    <label for="location" class="block text-xs md:text-sm font-medium text-gray-700">
                        Location
                        <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2 md:pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="location" 
                               name="location" 
                               value="<?php echo e(old('location')); ?>"
                               class="block w-full pl-8 md:pl-10 pr-3 py-1.5 md:py-2 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 focus:ring-red-500 focus:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Enter center location">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">e.g., City, Street, Building name, etc.</p>
                    <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="flex items-center mt-1 text-red-600 text-xs md:text-sm">
                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e($message); ?>

                    </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Additional Fields (Expandable) -->
                <div x-data="{ showAdditional: false }" class="space-y-3 md:space-y-4">
                    <button type="button" 
                            @click="showAdditional = !showAdditional"
                            class="flex items-center text-xs md:text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200 w-full text-left">
                        <svg :class="showAdditional ? 'transform rotate-90' : ''" class="w-3 h-3 md:w-4 md:h-4 mr-1.5 md:mr-2 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        Add Additional Information
                    </button>
                    
                    <div x-show="showAdditional" x-collapse class="space-y-3 md:space-y-4 pl-4 md:pl-6 border-l-2 border-gray-200">
                        <!-- Contact Person Field -->
                        <div class="space-y-1 md:space-y-2">
                            <label for="contact_person" class="block text-xs md:text-sm font-medium text-gray-700">
                                Contact Person
                            </label>
                            <input type="text" 
                                   id="contact_person" 
                                   name="contact_person" 
                                   value="<?php echo e(old('contact_person')); ?>"
                                   class="block w-full px-2 md:px-3 py-1.5 md:py-2 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                   placeholder="Contact person name">
                        </div>

                        <!-- Contact Phone Field -->
                        <div class="space-y-1 md:space-y-2">
                            <label for="contact_phone" class="block text-xs md:text-sm font-medium text-gray-700">
                                Contact Phone
                            </label>
                            <input type="tel" 
                                   id="contact_phone" 
                                   name="contact_phone" 
                                   value="<?php echo e(old('contact_phone')); ?>"
                                   class="block w-full px-2 md:px-3 py-1.5 md:py-2 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                   placeholder="Phone number">
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-1 md:space-y-2">
                            <label for="email" class="block text-xs md:text-sm font-medium text-gray-700">
                                Email Address
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo e(old('email')); ?>"
                                   class="block w-full px-2 md:px-3 py-1.5 md:py-2 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                   placeholder="Email address">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-4 md:pt-6 border-t border-gray-200 mt-4 md:mt-6">
                    <div class="text-xs md:text-sm text-gray-600 mb-3 sm:mb-0">
                        <p>Fields marked with <span class="text-red-500">*</span> are required</p>
                    </div>
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                        <button type="reset" 
                                class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base w-full sm:w-auto justify-center">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Clear Form
                        </button>
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base w-full sm:w-auto justify-center">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Create Center
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Centers List Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
        <div class="px-3 md:px-4 lg:px-6 py-3 md:py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-gray-600 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <div>
                        <h2 class="text-sm md:text-base lg:text-lg font-semibold text-gray-900">All Centers</h2>
                        <p class="text-xs md:text-sm text-gray-600 mt-0.5">Manage existing training centers</p>
                    </div>
                </div>
                <span class="px-2 md:px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs md:text-sm font-semibold">
                    <?php echo e($centers->count()); ?> <?php echo e($centers->count() === 1 ? 'Center' : 'Centers'); ?>

                </span>
            </div>
        </div>
        
        <div class="p-3 md:p-4 lg:p-6">
            <?php if($centers->isEmpty()): ?>
                <div class="text-center py-8 md:py-12">
                    <svg class="mx-auto h-12 w-12 md:h-16 md:w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <h3 class="mt-2 text-sm md:text-base font-semibold text-gray-900">No centers yet</h3>
                    <p class="mt-1 text-xs md:text-sm text-gray-500">Get started by creating a new center above.</p>
                </div>
            <?php else: ?>
                <div class="space-y-2 md:space-y-3">
                    <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between p-3 md:p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200 bg-white hover:bg-gray-50">
                            <div class="flex-1 min-w-0 mr-3">
                                <div class="flex items-center space-x-2 md:space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-sm md:text-base font-semibold text-gray-900 truncate"><?php echo e($center->name); ?></h3>
                                        <?php if($center->location): ?>
                                            <div class="flex items-center text-xs md:text-sm text-gray-600 mt-0.5">
                                                <svg class="w-3 h-3 md:w-4 md:h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span class="truncate"><?php echo e($center->location); ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <div class="flex items-center text-xs text-gray-500 mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                            </svg>
                                            <?php echo e($center->students_count ?? $center->students()->count()); ?> students
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <form action="<?php echo e(route('centers.destroy', $center->id)); ?>" method="POST" class="delete-center-form inline-block" data-center-name="<?php echo e($center->name); ?>" data-student-count="<?php echo e($center->students()->count()); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button" 
                                            class="delete-center-btn inline-flex items-center px-2 md:px-3 py-1.5 md:py-2 bg-red-600 hover:bg-red-700 text-white text-xs md:text-sm font-medium rounded-lg shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
                                            title="Delete center">
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1 md:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span class="hidden sm:inline">Delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Error Message Alert -->
    <?php if(session('error')): ?>
    <div class="mt-4 md:mt-6 p-3 md:p-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-lg shadow-sm" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-4 w-4 md:h-5 md:w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-2 md:ml-3">
                <p class="text-xs md:text-sm font-medium text-red-800"><?php echo e(session('error')); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
    /* Mobile optimizations */
    @media (max-width: 640px) {
        input, button, select, textarea {
            font-size: 14px;
        }
        
        .space-y-4 > * + * {
            margin-top: 1rem;
        }
        
        .py-1.5 {
            padding-top: 0.375rem;
            padding-bottom: 0.375rem;
        }
        
        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .pl-8 {
            padding-left: 2rem;
        }
        
        .text-xs {
            font-size: 0.65rem;
        }
        
        .ml-5 {
            margin-left: 1.25rem;
        }
        
        .w-3 {
            width: 0.75rem;
        }
        
        .h-3 {
            height: 0.75rem;
        }
        
        .mr-1.5 {
            margin-right: 0.375rem;
        }
        
        .pt-4 {
            padding-top: 1rem;
        }
        
        .mt-4 {
            margin-top: 1rem;
        }
        
        /* Make form more touch-friendly */
        input, textarea, select {
            min-height: 2.5rem;
        }
        
        button {
            min-height: 2.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .sm\:flex-row {
            flex-direction: column;
        }
        
        .sm\:space-x-3 > * + * {
            margin-left: 0;
            margin-top: 0.75rem;
        }
        
        .sm\:mb-0 {
            margin-bottom: 0;
        }
        
        .p-3 {
            padding: 0.75rem;
        }
        
        .py-3 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        
        .text-sm {
            font-size: 0.8125rem;
        }
        
        .space-y-3 > * + * {
            margin-top: 0.75rem;
        }
        
        /* Make expandable section more visible on mobile */
        [x-cloak] {
            display: none;
        }
        
        .border-l-2 {
            border-left-width: 1px;
        }
        
        .pl-4 {
            padding-left: 1rem;
        }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
        .md\:p-4 {
            padding: 1rem;
        }
        
        .md\:py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .md\:px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .md\:space-y-5 > * + * {
            margin-top: 1.25rem;
        }
        
        .md\:pl-6 {
            padding-left: 1.5rem;
        }
    }
    
    /* Form focus animations */
    input:focus, textarea:focus, select:focus {
        transition: all 0.2s ease;
        outline: none;
    }
    
    /* Required field indicator */
    .required::after {
        content: " *";
        color: #ef4444;
    }
    
    /* Smooth collapse transitions */
    [x-cloak] {
        display: none;
    }
    
    /* Form validation styling */
    .form-error {
        border-color: #f87171;
        background-color: #fef2f2;
    }
    
    .form-error:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    /* Success message animation */
    @keyframes slideIn {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .alert-success {
        animation: slideIn 0.3s ease;
    }
    
    /* Loading spinner animation */
    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
    
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    /* Custom focus rings for better mobile visibility */
    @media (max-width: 640px) {
        input:focus, textarea:focus, select:focus, button:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
            border-color: transparent;
        }
    }
    
    /* Better touch targets on mobile */
    @media (max-width: 768px) {
        label {
            margin-bottom: 0.25rem;
        }
        
        input, select, textarea {
            padding: 0.5rem 0.75rem;
        }
        
        button {
            padding: 0.5rem 1rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete center confirmation
    const deleteBtns = document.querySelectorAll('.delete-center-btn');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-center-form');
            const centerName = form.dataset.centerName;
            const studentCount = parseInt(form.dataset.studentCount);
            
            let message = `Are you sure you want to delete "${centerName}"?`;
            
            if (studentCount > 0) {
                message = `Cannot delete "${centerName}" because it has ${studentCount} student(s) assigned to it.\n\nPlease reassign or remove the students first.`;
                alert(message);
                return;
            }
            
            if (confirm(message + '\n\nThis action cannot be undone.')) {
                // Show loading state
                this.disabled = true;
                this.innerHTML = `
                    <svg class="animate-spin w-3 h-3 md:w-4 md:h-4 mr-1 md:mr-1.5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="hidden sm:inline">Deleting...</span>
                `;
                form.submit();
            }
        });
    });

    // Auto-focus on name field
    const nameField = document.getElementById('name');
    if (nameField) {
        nameField.focus();
        
        // Add input validation
        nameField.addEventListener('input', function() {
            if (this.value.trim().length > 0) {
                this.classList.remove('border-red-300');
                const error = this.parentElement.querySelector('.field-error');
                if (error) {
                    error.remove();
                }
            }
        });
    }
    
    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            let hasError = false;
            
            // Validate name field
            const nameField = document.getElementById('name');
            if (nameField && !nameField.value.trim()) {
                e.preventDefault();
                showFieldError(nameField, 'Center name is required');
                nameField.focus();
                hasError = true;
            }
            
            if (hasError) {
                return false;
            }
            
            // Add loading state to submit button
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 md:h-5 md:w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Creating Center...
                `;
                submitBtn.disabled = true;
                submitBtn.classList.remove('hover:-translate-y-0.5', 'hover:shadow-lg');
                
                // Prevent double submission
                setTimeout(() => {
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    }
    
    // Show field error function
    function showFieldError(field, message) {
        // Remove existing error
        const existingError = field.parentElement.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Add error class to field
        field.classList.add('border-red-300');
        field.classList.remove('focus:ring-blue-500', 'focus:border-blue-500');
        field.classList.add('focus:ring-red-500', 'focus:border-red-500');
        
        // Create error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error flex items-center mt-1 text-red-600 text-xs md:text-sm';
        errorDiv.innerHTML = `
            <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            ${message}
        `;
        
        field.parentElement.appendChild(errorDiv);
        
        // Scroll to error on mobile
        if (window.innerWidth < 768) {
            field.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        // Remove error on input
        field.addEventListener('input', function() {
            this.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
            this.classList.add('focus:ring-blue-500', 'focus:border-blue-500');
            const error = this.parentElement.querySelector('.field-error');
            if (error) {
                error.remove();
            }
        }, { once: true });
    }
    
    // Clear form button functionality
    const clearBtn = document.querySelector('button[type="reset"]');
    if (clearBtn) {
        clearBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const confirmed = confirm('Are you sure you want to clear all form fields?');
            if (confirmed) {
                // Reset form
                form.reset();
                
                // Reset Alpine.js state if present
                if (typeof Alpine !== 'undefined') {
                    const alpineElements = document.querySelectorAll('[x-data]');
                    alpineElements.forEach(el => {
                        const alpineData = Alpine.$data(el);
                        if (alpineData && alpineData.showAdditional !== undefined) {
                            alpineData.showAdditional = false;
                        }
                    });
                }
                
                // Clear all errors
                document.querySelectorAll('.border-red-300').forEach(el => {
                    el.classList.remove('border-red-300', 'focus:ring-red-500', 'focus:border-red-500');
                    el.classList.add('focus:ring-blue-500', 'focus:border-blue-500');
                });
                document.querySelectorAll('.field-error').forEach(el => {
                    el.remove();
                });
                
                // Focus on name field after clear
                setTimeout(() => {
                    if (nameField) {
                        nameField.focus();
                    }
                }, 100);
            }
        });
    }
    
    // Phone number formatting
    const phoneField = document.getElementById('contact_phone');
    if (phoneField) {
        phoneField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 10) {
                value = value.slice(0, 10);
            }
            
            // Format as XXX-XXX-XXXX
            if (value.length > 6) {
                value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6);
            } else if (value.length > 3) {
                value = value.slice(0, 3) + '-' + value.slice(3);
            }
            
            e.target.value = value;
        });
    }
    
    // Make form inputs more touch-friendly on mobile
    const formInputs = document.querySelectorAll('input, select, textarea, button');
    formInputs.forEach(input => {
        input.addEventListener('touchstart', function() {
            if (!this.classList.contains('bg-gray-50')) {
                this.style.transform = 'scale(0.98)';
            }
        });
        
        input.addEventListener('touchend', function() {
            this.style.transform = '';
        });
    });
    
    // Adjust form layout on resize
    function adjustFormLayout() {
        const isMobile = window.innerWidth < 768;
        const formCard = document.querySelector('.bg-white.rounded-xl');
        
        if (isMobile) {
            // Add mobile-specific classes
            if (formCard) {
                formCard.classList.add('overflow-hidden');
            }
        }
    }
    
    // Initial adjustment
    adjustFormLayout();
    
    // Adjust on resize
    window.addEventListener('resize', adjustFormLayout);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Project\Student Management System\resources\views/centers/create.blade.php ENDPATH**/ ?>