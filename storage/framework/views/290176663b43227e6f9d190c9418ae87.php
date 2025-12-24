<?php $__env->startSection('header', 'Add Student'); ?>
<?php $__env->startSection('title', 'Add New Student'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
    <!-- Header Section -->
    <div class="mb-4 md:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-3 sm:mb-0">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900">Add New Student</h1>
                <p class="mt-1 text-xs md:text-sm text-gray-600">Create a new student record in the system</p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="<?php echo e(route('reception.students.index')); ?>" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Back to Students
                </a>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-4xl mx-auto">
        <!-- Error Messages -->
        <?php if(session('error')): ?>
        <div class="mb-4 md:mb-6 p-3 md:p-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-lg shadow-sm" role="alert">
            <div class="flex items-center">
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

        <?php if($errors->any()): ?>
        <div class="mb-4 md:mb-6 p-3 md:p-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-lg shadow-sm" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-4 w-4 md:h-5 md:w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-2 md:ml-3">
                    <h3 class="text-xs md:text-sm font-medium text-red-800">There were <?php echo e($errors->count()); ?> error(s) with your submission</h3>
                    <div class="mt-1 md:mt-2 text-xs md:text-sm text-red-700">
                        <ul class="list-disc pl-4 md:pl-5 space-y-0.5 md:space-y-1">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6 lg:p-8">
            <form action="<?php echo e(route('reception.students.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <!-- Personal Information Section -->
                <div class="mb-6 md:mb-8">
                    <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-3 md:mb-4 pb-2 border-b border-gray-200">Personal Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                First Name
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="first_name" id="first_name" value="<?php echo e(old('first_name')); ?>" 
                                   class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                   placeholder="Enter first name"
                                   required>
                        </div>
                        
                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                Last Name
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="last_name" id="last_name" value="<?php echo e(old('last_name')); ?>" 
                                   class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                   placeholder="Enter last name"
                                   required>
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                Email Address
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" 
                                   class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                   placeholder="student@example.com"
                                   required>
                        </div>
                        
                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                Date of Birth
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="<?php echo e(old('date_of_birth')); ?>" 
                                   class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="mb-6 md:mb-8">
                    <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-3 md:mb-4 pb-2 border-b border-gray-200">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <!-- Student Phone -->
                        <div>
                            <label for="student_phone" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                Student Phone
                            </label>
                            <input type="text" name="student_phone" id="student_phone" value="<?php echo e(old('student_phone')); ?>" 
                                   class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                   placeholder="Enter student phone number">
                        </div>
                        
                        <!-- Parent Phone -->
                        <div>
                            <label for="parent_phone" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                Parent Phone
                                <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="parent_phone" id="parent_phone" value="<?php echo e(old('parent_phone')); ?>" 
                                   class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                   placeholder="Enter parent phone number"
                                   required>
                        </div>
                        
                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                Address
                            </label>
                            <textarea name="address" id="address" rows="2" md:rows="3"
                                      class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                      placeholder="Enter student's address"><?php echo e(old('address')); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Course & Center Section -->
                <div class="mb-6 md:mb-8">
                    <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-3 md:mb-4 pb-2 border-b border-gray-200">Course & Center</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <!-- Course -->
                        <div>
                            <label for="course_id" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                Course
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="course_id" id="course_id" 
                                    class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                    required>
                                <option value="">Select a Course</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($course->id); ?>" <?php echo e(old('course_id') == $course->id ? 'selected' : ''); ?>>
                                        <?php echo e($course->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <!-- Center -->
                        <div>
                            <label for="center_id" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                Center
                            </label>
                            <select name="center_id" id="center_id" 
                                    class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                                <option value="">Select a Center (Optional)</option>
                                <?php $__currentLoopData = $centers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $center): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($center->id); ?>" <?php echo e(old('center_id') == $center->id ? 'selected' : ''); ?>>
                                        <?php echo e($center->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                Status
                                <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" 
                                    class="block w-full px-3 py-2 md:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                    required>
                                <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- QR Scanner Section -->
                <div class="mb-6 md:mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-3 md:mb-4 pb-2 border-b border-gray-200">
                        <h3 class="text-base md:text-lg font-semibold text-gray-900 mb-2 sm:mb-0">QR Code Registration</h3>
                        <span class="inline-flex items-center px-2 py-0.5 md:px-2.5 md:py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Required
                        </span>
                    </div>
                    
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 md:p-6 border border-blue-200">
                        <div class="flex flex-col lg:flex-row lg:items-start gap-4 md:gap-6">
                            <!-- QR Scanner -->
                            <div class="lg:w-1/2">
                                <div class="mb-3 md:mb-4">
                                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                        Scan QR Code
                                    </label>
                                    <div id="qr-reader" class="rounded-lg overflow-hidden border border-gray-300"></div>
                                </div>
                                <p class="text-xs text-gray-500">
                                    Position the QR code within the scanner frame. The code will be automatically detected.
                                </p>
                            </div>
                            
                            <!-- QR Input -->
                            <div class="lg:w-1/2">
                                <label for="qr_code" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                                    QR Code
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="qr_code" id="qr_code" 
                                           class="block w-full px-3 py-2 md:py-2.5 pr-8 md:pr-10 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                           placeholder="Scan QR code or enter manually"
                                           value="<?php echo e(old('qr_code')); ?>"
                                           required readonly>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-2 md:pr-3">
                                        <svg class="h-4 w-4 md:h-5 md:w-5 text-green-500" id="qr-status-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="mt-1 md:mt-2 flex items-center text-xs md:text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1 h-3 w-3 md:h-4 md:w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Scan a valid QR code from your inventory
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-4 md:pt-6 border-t border-gray-200">
                    <div class="mb-3 md:mb-4 sm:mb-0">
                        <a href="<?php echo e(route('reception.students.index')); ?>" 
                           class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200 text-sm md:text-base w-full sm:w-auto justify-center">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel
                        </a>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:space-x-3 space-y-2 sm:space-y-0">
                        <button type="reset" 
                                class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-gray-500 transition-colors duration-200 text-sm md:text-base w-full sm:w-auto justify-center">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset
                        </button>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2.5 md:px-6 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base w-full sm:w-auto justify-center">
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Student
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function onScanSuccess(decodedText, decodedResult) {
        // Normalize scanned value: if scanner returns a full URL, extract the
        // last path segment (the actual QR code). Otherwise use the decodedText.
        let code = decodedText;
        try {
            const url = new URL(decodedText);
            const segments = url.pathname.split('/').filter(Boolean);
            if (segments.length) {
                code = segments.pop();
            }
        } catch (e) {
            // not a URL, try splitting by slash just in case
            if (decodedText.indexOf('/') !== -1) {
                const segs = decodedText.split('/').filter(s => s.length);
                code = segs.pop();
            }
        }
        
        // Set QR code value
        const qrInput = document.getElementById('qr_code');
        qrInput.value = code;
        
        // Update status icon
        const qrIcon = document.getElementById('qr-status-icon');
        qrIcon.classList.remove('text-gray-400', 'text-red-500');
        qrIcon.classList.add('text-green-500');
        qrIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
        
        // Show success message
        showToast('QR Code scanned successfully!', 'success');
        
        // Stop scanning after success
        if (typeof html5QrcodeScanner !== 'undefined') {
            html5QrcodeScanner.clear();
        }
    }

    function onScanFailure(error) {
        // Handle scan failure, ignore most errors
        console.warn(`QR scan error: ${error}`);
    }

    // Initialize QR scanner with responsive settings
    const qrBoxSize = window.innerWidth < 768 ? 200 : 250;
    
    const html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", 
        { 
            fps: 10, 
            qrbox: { width: qrBoxSize, height: qrBoxSize },
            aspectRatio: 1.0,
            showTorchButtonIfSupported: true,
            showZoomSliderIfSupported: true,
            defaultZoomValueIfSupported: window.innerWidth < 768 ? 1.5 : 2
        },
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'}"/>
                </svg>
                <span class="text-xs md:text-sm">${message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
            toast.classList.add('translate-x-0');
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.classList.remove('translate-x-0');
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }

    // Manual QR code input validation
    document.getElementById('qr_code').addEventListener('input', function(e) {
        const qrIcon = document.getElementById('qr-status-icon');
        if (e.target.value.trim().length > 0) {
            qrIcon.classList.remove('text-gray-400', 'text-red-500');
            qrIcon.classList.add('text-green-500');
            qrIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
        } else {
            qrIcon.classList.remove('text-green-500', 'text-red-500');
            qrIcon.classList.add('text-gray-400');
            qrIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>';
        }
    });

    // Adjust QR scanner on resize
    window.addEventListener('resize', function() {
        const newQrBoxSize = window.innerWidth < 768 ? 200 : 250;
        // Note: Html5QrcodeScanner doesn't support dynamic resize
        // Re-initialization would be needed for proper resize
    });

    // Form validation on mobile
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Validate required fields on mobile
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#ef4444';
                    field.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    isValid = false;
                    
                    // Add error class
                    field.classList.add('border-red-500');
                    setTimeout(() => {
                        field.classList.remove('border-red-500');
                        field.style.borderColor = '';
                    }, 3000);
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showToast('Please fill in all required fields', 'error');
            }
        });
    }

    // Date input enhancement for mobile
    const dobInput = document.getElementById('date_of_birth');
    if (dobInput) {
        // Set max date to today
        const today = new Date().toISOString().split('T')[0];
        dobInput.setAttribute('max', today);
        
        // Format for mobile browsers
        if (window.innerWidth < 768) {
            dobInput.setAttribute('placeholder', 'YYYY-MM-DD');
        }
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Custom scrollbar for error messages */
    .max-h-64 {
        max-height: 16rem;
    }
    
    /* QR Scanner custom styles */
    #qr-reader {
        border: 2px solid #e5e7eb !important;
        border-radius: 0.5rem;
        overflow: hidden;
        max-height: 300px;
    }
    
    #qr-reader video {
        width: 100% !important;
        height: auto !important;
    }
    
    #qr-reader__scan_region {
        display: flex;
        justify-content: center;
    }
    
    /* Form focus states */
    input:focus, select:focus, textarea:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    /* Required field indicator */
    label span.text-red-500 {
        margin-left: 2px;
    }
    
    /* Toast animation */
    .translate-x-full {
        transform: translateX(100%);
    }
    
    .translate-x-0 {
        transform: translateX(0);
    }
    
    /* Mobile optimizations */
    @media (max-width: 640px) {
        #qr-reader {
            margin-left: -0.5rem;
            margin-right: -0.5rem;
            border-radius: 0;
            border-left: 0;
            border-right: 0;
        }
        
        .p-4 {
            padding: 1rem;
        }
        
        .gap-4 {
            gap: 0.75rem;
        }
        
        .text-sm {
            font-size: 0.75rem;
        }
        
        .py-2 {
            padding-top: 0.375rem;
            padding-bottom: 0.375rem;
        }
        
        input, select, textarea {
            font-size: 16px !important; /* Prevent zoom on iOS */
        }
        
        /* Better touch targets */
        button, a {
            min-height: 44px;
            display: flex;
            align-items: center;
        }
    }
    
    @media (max-width: 768px) {
        .lg\:w-1\/2 {
            width: 100%;
        }
        
        .text-base {
            font-size: 0.875rem;
        }
        
        .border-b {
            border-bottom-width: 1px;
        }
        
        .space-y-2 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-y-reverse: 0;
            margin-top: calc(0.5rem * calc(1 - var(--tw-space-y-reverse)));
            margin-bottom: calc(0.5rem * var(--tw-space-y-reverse));
        }
        
        /* Stack form sections better on mobile */
        .grid-cols-1 {
            grid-template-columns: 1fr;
        }
        
        .md\:grid-cols-2 {
            grid-template-columns: 1fr;
        }
        
        .md\:col-span-2 {
            grid-column: 1 / -1;
        }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
        .lg\:flex-row {
            flex-direction: column;
        }
        
        .lg\:w-1\/2 {
            width: 100%;
        }
        
        .gap-6 {
            gap: 1rem;
        }
    }
    
    /* Prevent iOS form zoom */
    @supports (-webkit-touch-callout: none) {
        input, select, textarea {
            font-size: 16px !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Project\Student Management System\resources\views/reception/students/create.blade.php ENDPATH**/ ?>