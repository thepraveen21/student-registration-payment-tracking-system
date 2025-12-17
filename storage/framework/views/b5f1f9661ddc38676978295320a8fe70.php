<?php $__env->startSection('header', 'Student Details'); ?>
<?php $__env->startSection('title', 'Student Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    <!-- Header Section -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Student Details</h1>
                <p class="mt-1 md:mt-2 text-sm text-gray-600">Complete information for <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></p>
            </div>
            <div class="mt-4 sm:mt-0 flex space-x-3">
                <a href="<?php echo e(route('reception.students.index')); ?>" 
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Back
                </a>
                <a href="<?php echo e(route('reception.students.edit', $student)); ?>" 
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto">
        <!-- Student Profile Header -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center gap-6">
                <!-- Student Avatar -->
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-200 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-blue-700 font-bold text-3xl">
                            <?php echo e(substr($student->first_name, 0, 1)); ?><?php echo e(substr($student->last_name, 0, 1)); ?>

                        </span>
                    </div>
                </div>
                
                <!-- Student Info -->
                <div class="flex-1">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900"><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></h2>
                            <div class="flex items-center mt-2 space-x-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($student->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php if($student->status == 'active'): ?>
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Active
                                    <?php else: ?>
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Inactive
                                    <?php endif; ?>
                                </span>
                                <span class="text-sm text-gray-600">ID: <?php echo e($student->id); ?></span>
                                <span class="text-sm text-gray-600"><?php echo e($student->registration_number); ?></span>
                            </div>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="mt-4 md:mt-0 grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-xs text-gray-500 mb-1">Course</div>
                                <div class="text-sm font-medium text-gray-900"><?php echo e(optional($student->course)->name ?? 'N/A'); ?></div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-gray-500 mb-1">Center</div>
                                <div class="text-sm font-medium text-gray-900"><?php echo e(optional($student->center)->name ?? 'N/A'); ?></div>
                            </div>
                            <div class="text-center">
                                <div class="text-xs text-gray-500 mb-1">Joined</div>
                                <div class="text-sm font-medium text-gray-900"><?php echo e($student->created_at->format('M Y')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Personal Information -->
            <div class="lg:col-span-2">
                <!-- Contact Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Contact Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div>
                            <div class="flex items-center mb-1">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</label>
                            </div>
                            <p class="text-sm font-medium text-gray-900 pl-6"><?php echo e($student->email); ?></p>
                        </div>
                        
                        <!-- Student Phone -->
                        <div>
                            <div class="flex items-center mb-1">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Student Phone</label>
                            </div>
                            <p class="text-sm font-medium text-gray-900 pl-6"><?php echo e($student->student_phone); ?></p>
                        </div>
                        
                        <!-- Parent Phone -->
                        <div>
                            <div class="flex items-center mb-1">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Parent Phone</label>
                            </div>
                            <p class="text-sm font-medium text-gray-900 pl-6"><?php echo e($student->parent_phone ?? 'Not provided'); ?></p>
                        </div>
                        
                        <!-- Date of Birth -->
                        <div>
                            <div class="flex items-center mb-1">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Birth</label>
                            </div>
                            <p class="text-sm font-medium text-gray-900 pl-6">
                                <?php echo e($student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'Not specified'); ?>

                                <?php if($student->date_of_birth): ?>
                                <span class="text-gray-500 text-sm">(<?php echo e(\Carbon\Carbon::parse($student->date_of_birth)->age); ?> years)</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <!-- Address -->
                        <div class="md:col-span-2">
                            <div class="flex items-center mb-1">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Address</label>
                            </div>
                            <p class="text-sm text-gray-900 pl-6"><?php echo e($student->address ?? 'Not provided'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Academic Information Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-3 border-b border-gray-200">Academic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course -->
                        <div>
                            <div class="flex items-center mb-1">
                                <svg class="w-4 h-4 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Course</label>
                            </div>
                            <p class="text-sm font-medium text-gray-900 pl-6"><?php echo e(optional($student->course)->name ?? 'Not assigned'); ?></p>
                        </div>
                        
                        <!-- Center -->
                        <div>
                            <div class="flex items-center mb-1">
                                <svg class="w-4 h-4 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Center</label>
                            </div>
                            <p class="text-sm font-medium text-gray-900 pl-6"><?php echo e(optional($student->center)->name ?? 'Not assigned'); ?></p>
                        </div>
                        
                        <!-- Registration Date -->
                        <div>
                            <div class="flex items-center mb-1">
                                <svg class="w-4 h-4 text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Registered On</label>
                            </div>
                            <p class="text-sm font-medium text-gray-900 pl-6"><?php echo e($student->created_at->format('M d, Y')); ?></p>
                            <p class="text-xs text-gray-500 pl-6"><?php echo e($student->created_at->diffForHumans()); ?></p>
                        </div>
                        
                        <!-- Registration Number -->
                        <div>
                            <div class="flex items-center mb-1">
                                <svg class="w-4 h-4 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <label class="text-xs font-medium text-gray-500 uppercase tracking-wider">Registration No.</label>
                            </div>
                            <p class="text-sm font-mono font-medium text-gray-900 bg-gray-50 px-3 py-1.5 rounded-lg pl-6"><?php echo e($student->registration_number); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - QR Code & Actions -->
            <div>
                <!-- QR Code Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">QR Code</h3>
                        <?php if($student->qr_code_path): ?>
                        <div class="flex space-x-2">
                            <a href="<?php echo e(asset($student->qr_code_path)); ?>" download 
                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download
                            </a>
                            <button onclick="printQR()" 
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 rounded-lg hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                Print
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if($student->qr_code_path): ?>
                    <div class="text-center">
                        <div class="bg-gradient-to-br from-gray-50 to-white border-2 border-gray-100 rounded-xl p-6 mb-4">
                            <img src="<?php echo e(asset($student->qr_code_path)); ?>" alt="QR Code" class="w-48 h-48 mx-auto">
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">QR Code Value</p>
                            <p class="text-sm font-mono text-gray-900 font-medium break-all bg-white px-3 py-2 rounded border border-gray-200">
                                <?php echo e($student->qr_value ?? $student->registration_number); ?>

                            </p>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-8">
                        <div class="mb-4">
                            <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No QR Code</h3>
                        <p class="text-sm text-gray-600 mb-4">This student doesn't have a QR code assigned yet.</p>
                        
                        <form action="<?php echo e(route('reception.qrcodes.assign')); ?>" method="POST" class="inline-block">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-500 to-amber-600 hover:from-yellow-600 hover:to-amber-700 text-white font-medium rounded-lg shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                                Assign QR Code
                            </button>
                        </form>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    
                    <div class="space-y-3">
                        <a href="<?php echo e(route('reception.payments.index') . '?student=' . $student->id); ?>" 
                           class="flex items-center p-3 bg-blue-50 rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors duration-200">
                            <div class="bg-blue-100 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">View Payments</p>
                                <p class="text-xs text-gray-500">Check payment history</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        
                        <a href="<?php echo e(route('reception.students.edit', $student)); ?>" 
                           class="flex items-center p-3 bg-green-50 rounded-lg border border-green-100 hover:bg-green-100 transition-colors duration-200">
                            <div class="bg-green-100 p-2 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Edit Profile</p>
                                <p class="text-xs text-gray-500">Update student information</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        
                        <form action="<?php echo e(route('reception.students.destroy', $student)); ?>" method="POST" class="block">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this student? This action cannot be undone.')"
                                    class="w-full flex items-center p-3 bg-red-50 rounded-lg border border-red-100 hover:bg-red-100 transition-colors duration-200 text-left">
                                <div class="bg-red-100 p-2 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">Delete Student</p>
                                    <p class="text-xs text-gray-500">Remove from system</p>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function printQR() {
    // Create print window
    const printWindow = window.open('', '', 'width=800,height=600');
    
    // Get student details
    const studentName = "<?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?>";
    const regNumber = "<?php echo e($student->registration_number); ?>";
    const courseName = "<?php echo e(optional($student->course)->name ?? 'No Course'); ?>";
    const qrCodePath = "<?php echo e(asset($student->qr_code_path)); ?>";
    const qrValue = "<?php echo e($student->qr_value ?? $student->registration_number); ?>";
    const printDate = new Date().toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    
    // Create print content
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print QR Code - ${studentName}</title>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    margin: 40px; 
                    text-align: center;
                    color: #333;
                }
                .print-container {
                    max-width: 500px;
                    margin: 0 auto;
                    padding: 20px;
                    border: 2px solid #e5e7eb;
                    border-radius: 12px;
                }
                .header {
                    margin-bottom: 30px;
                }
                .student-info {
                    margin-bottom: 20px;
                }
                .qr-code {
                    margin: 20px 0;
                    padding: 20px;
                    border: 1px dashed #d1d5db;
                    border-radius: 8px;
                    display: inline-block;
                }
                .qr-code img {
                    width: 200px;
                    height: 200px;
                }
                .qr-value {
                    font-family: monospace;
                    font-size: 14px;
                    color: #6b7280;
                    margin-top: 10px;
                }
                .footer {
                    margin-top: 30px;
                    font-size: 12px;
                    color: #9ca3af;
                }
                .institute-name {
                    font-size: 20px;
                    font-weight: bold;
                    color: #1f2937;
                    margin-bottom: 5px;
                }
                .label {
                    font-size: 12px;
                    color: #6b7280;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                    margin-bottom: 5px;
                }
                .value {
                    font-size: 16px;
                    font-weight: 500;
                    color: #111827;
                }
                @media print {
                    body { margin: 0; }
                    .no-print { display: none; }
                    .print-container { border: none; }
                }
            </style>
        </head>
        <body>
            <div class="print-container">
                <div class="header">
                    <div class="institute-name">Student QR Code</div>
                    <div class="label">Generated on: ${printDate}</div>
                </div>
                
                <div class="student-info">
                    <div class="label">Student Name</div>
                    <div class="value">${studentName}</div>
                    
                    <div style="margin-top: 15px;">
                        <div class="label">Registration Number</div>
                        <div class="value">${regNumber}</div>
                    </div>
                    
                    <div style="margin-top: 15px;">
                        <div class="label">Course</div>
                        <div class="value">${courseName}</div>
                    </div>
                </div>
                
                <div class="qr-code">
                    <img src="${qrCodePath}" alt="QR Code">
                    <div class="qr-value">${qrValue}</div>
                </div>
                
                <div class="footer">
                    <p>This QR code is for student identification and access control purposes only.</p>
                    <p>Valid for: ${studentName} | ${regNumber}</p>
                </div>
            </div>
            
            <div class="no-print" style="text-align: center; margin-top: 20px;">
                <button onclick="window.print()" style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 6px; cursor: pointer;">
                    Print Now
                </button>
                <button onclick="window.close()" style="padding: 10px 20px; background: #6b7280; color: white; border: none; border-radius: 6px; margin-left: 10px; cursor: pointer;">
                    Close
                </button>
            </div>
            
            <script>
                window.onload = function() {
                    // Auto-print after a short delay
                    setTimeout(() => {
                        window.print();
                    }, 500);
                };
            <\/script>
        </body>
        </html>
    `);
    
    printWindow.document.close();
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Projects\innovior info\66\Student Management System\resources\views/reception/students/show.blade.php ENDPATH**/ ?>