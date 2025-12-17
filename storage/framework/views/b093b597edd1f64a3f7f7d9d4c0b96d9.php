<?php $__env->startSection('header', 'Manage QR Codes'); ?>
<?php $__env->startSection('title', 'Manage QR Codes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    <!-- Header Section -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Manage QR Codes</h1>
                <p class="mt-1 md:mt-2 text-sm text-gray-600">Generate, assign, and manage student QR codes</p>
            </div>
        </div>
    </div>

    <!-- Action Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Generate QR Codes Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Generate QR Codes</h3>
                    <p class="text-sm text-gray-600">Create new QR codes for student identification</p>
                </div>
            </div>

            <form action="<?php echo e(route('reception.qrcodes.generate')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-6">
                    <label for="count" class="block text-sm font-medium text-gray-700 mb-2">
                        Number of QR Codes
                    </label>
                    <div class="relative">
                        <input type="number" name="count" id="count" min="1" max="100" value="10" 
                               class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <span class="text-sm text-gray-500">codes</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Maximum 100 codes per generation</p>
                </div>
                
                <button type="submit" 
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Generate QR Codes
                </button>
            </form>
        </div>

        <!-- Assign QR Code Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 p-3 rounded-lg mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Assign QR Code</h3>
                    <p class="text-sm text-gray-600">Scan and assign QR code to student</p>
                </div>
            </div>

            <!-- QR Scanner -->
            <div class="mb-6">
                <div id="qr-reader-assign" class="rounded-lg overflow-hidden border border-gray-300"></div>
                <div id="qr-reader-results-assign" class="mt-3 text-center text-sm text-gray-600"></div>
            </div>

            <!-- Assignment Form -->
            <form id="assign-form" action="<?php echo e(route('reception.qrcodes.assign')); ?>" method="POST" class="hidden">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div>
                        <label for="qr_code_data" class="block text-sm font-medium text-gray-700 mb-2">
                            Scanned QR Code
                        </label>
                        <div class="relative">
                            <input type="text" name="qr_code" id="qr_code_data" readonly 
                                   class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-green-500" id="qr-scanned-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Student
                        </label>
                        <select name="student_id" id="student_id" 
                                class="block w-full px-3 py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200">
                            <option value="">Select a student...</option>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($student->id); ?>">
                                    <?php echo e($student->name); ?> • <?php echo e($student->registration_number); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Assign QR Code to Student
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Unassigned QR Codes Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Unassigned QR Codes</h3>
                <p class="text-sm text-gray-600 mt-1">Available QR codes ready for assignment</p>
            </div>
            <div class="text-sm text-gray-700">
                <span class="font-semibold"><?php echo e($unassignedQRCodes->total()); ?></span> codes available
            </div>
        </div>

        <?php if($unassignedQRCodes->count()): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                QR Code
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Generated
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $unassignedQRCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qrCode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                        </svg>
                                    </div>
                                    <div class="text-sm font-mono font-medium text-gray-900"><?php echo e($qrCode->code); ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <?php if($qrCode->created_at): ?>
                                        <?php echo e($qrCode->created_at->format('M d, Y')); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </div>
                                <div class="text-xs text-gray-500">
                                    <?php if($qrCode->created_at): ?>
                                        <?php echo e($qrCode->created_at->diffForHumans()); ?>

                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?php echo e(asset($qrCode->qr_image_path)); ?>" download 
                                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Download
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                        Showing <span class="font-semibold"><?php echo e($unassignedQRCodes->firstItem()); ?></span> to 
                        <span class="font-semibold"><?php echo e($unassignedQRCodes->lastItem()); ?></span> of 
                        <span class="font-semibold"><?php echo e($unassignedQRCodes->total()); ?></span> results
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <?php echo e($unassignedQRCodes->links()); ?>

                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mb-4">
                    <svg class="w-16 h-16 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Unassigned QR Codes</h3>
                <p class="text-sm text-gray-600 mb-6 max-w-md mx-auto">
                    All QR codes have been assigned to students. Generate new codes to have available ones.
                </p>
                <a href="#generate" 
                   onclick="document.getElementById('count').focus()"
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Generate New QR Codes
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function onScanSuccessAssign(decodedText, decodedResult) {
        // Handle on success condition with the decoded text or result.
        console.log(`Scan result: ${decodedText}`, decodedResult);
        
        // Update results display
        const resultsDiv = document.getElementById('qr-reader-results-assign');
        resultsDiv.innerHTML = `
            <div class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-800 rounded-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                QR Code Scanned Successfully!
            </div>
        `;
        
        // Set QR code value
        const qrInput = document.getElementById('qr_code_data');
        qrInput.value = decodedText;
        
        // Show assignment form
        const assignForm = document.getElementById('assign-form');
        assignForm.classList.remove('hidden');
        
        // Focus on student selection
        setTimeout(() => {
            document.getElementById('student_id').focus();
        }, 100);
        
        // Stop scanning after success
        html5QrcodeScannerAssign.clear();
    }

    // Initialize QR scanner
    const html5QrcodeScannerAssign = new Html5QrcodeScanner(
        "qr-reader-assign", 
        { 
            fps: 10, 
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0,
            showTorchButtonIfSupported: true
        },
        false
    );
    html5QrcodeScannerAssign.render(onScanSuccessAssign);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Projects\innovior info\Student Management System\resources\views/reception/qrcodes/manage.blade.php ENDPATH**/ ?>