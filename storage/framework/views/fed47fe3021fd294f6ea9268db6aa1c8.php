

<?php $__env->startSection('header', 'Print QR Codes'); ?>
<?php $__env->startSection('title', 'Print QR Codes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    <!-- Header Section -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Print QR Codes</h1>
                <p class="mt-1 md:mt-2 text-sm text-gray-600">Generate and print unassigned QR codes</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="<?php echo e(route('reception.qrcodes.manage')); ?>" 
                   class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Management
                </a>
            </div>
        </div>
        
        <!-- Success Message -->
        <?php if(session('success')): ?>
        <div class="mt-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Control Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 p-4 md:p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <button onclick="printQRCodes()" 
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Selected QR Codes
                </button>
                
                <label class="inline-flex items-center px-4 py-2.5 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                    <input type="checkbox" id="selectAll" class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 focus:ring-2 transition-colors duration-200">
                    <span class="ml-3 text-sm font-medium text-gray-700">Select All</span>
                </label>
            </div>
            
            <div class="text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-lg">
                <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <?php echo e($unassignedCodes->count()); ?> unassigned QR codes available
            </div>
        </div>
    </div>

    <!-- QR Codes Grid -->
    <div id="printArea" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6">
        <?php if($unassignedCodes->count() > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            <?php $__currentLoopData = $unassignedCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qrCode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="qr-code-card border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 group">
                <label class="inline-flex items-center mb-4 cursor-pointer">
                    <input type="checkbox" 
                           name="qr_codes[]" 
                           value="<?php echo e($qrCode->id); ?>" 
                           class="qr-checkbox h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 focus:ring-2 transition-colors duration-200">
                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors duration-200">
                        Select for printing
                    </span>
                </label>
                
                <div class="flex flex-col items-center">
                    <div class="bg-white p-3 rounded-lg border border-gray-100 mb-3 shadow-inner">
                        <?php echo QrCode::size(160)->margin(1)->generate(route('student.verify', $qrCode->code)); ?>

                    </div>
                    
                    <div class="w-full text-center">
                        <div class="font-mono text-sm font-semibold text-gray-900 bg-gray-50 py-2 px-3 rounded-lg mb-1 break-all">
                            <?php echo e($qrCode->code); ?>

                        </div>
                        
                        <div class="flex items-center justify-center text-xs text-gray-500 mt-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <?php echo e($qrCode->created_at->format('M d, Y')); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="py-12 text-center">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <p class="text-gray-500 text-lg font-medium">No unassigned QR codes available</p>
                <p class="text-gray-400 mt-1 mb-6">Generate new QR codes to start printing</p>
                <a href="<?php echo e(route('reception.qrcodes.manage')); ?>" 
                   class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Generate New QR Codes
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printArea, #printArea * {
            visibility: visible;
        }
        #printArea {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            border: none;
            box-shadow: none;
            background: white;
        }
        .qr-checkbox, 
        .qr-code-card label,
        .bg-gradient-to-r,
        .border-gray-200,
        .hover\\:border-blue-300,
        .hover\\:shadow-md {
            display: none !important;
        }
        .qr-code-card {
            break-inside: avoid;
            page-break-inside: avoid;
            border: 1px solid #e5e7eb !important;
            margin-bottom: 20px;
        }
        .grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 20px !important;
        }
        .bg-gray-50 {
            background-color: #f9fafb !important;
        }
        .shadow-inner {
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06) !important;
        }
    }
    
    /* Custom print button animation */
    @keyframes pulse-print {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }
    
    .print-button:active {
        animation: pulse-print 0.2s ease;
    }
    
    /* QR code hover effect */
    .qr-code-card:hover {
        transform: translateY(-2px);
    }
    
    /* Smooth checkbox transition */
    .qr-checkbox:checked {
        animation: checkmark 0.2s ease;
    }
    
    @keyframes checkmark {
        0% { transform: scale(0.8); }
        100% { transform: scale(1); }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const qrCheckboxes = document.querySelectorAll('.qr-checkbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function(e) {
            qrCheckboxes.forEach(cb => {
                cb.checked = e.target.checked;
                cb.dispatchEvent(new Event('change'));
            });
        });
    }
    
    // Update select all checkbox state when individual checkboxes change
    qrCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(qrCheckboxes).every(cb => cb.checked);
            const someChecked = Array.from(qrCheckboxes).some(cb => cb.checked);
            
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = !allChecked && someChecked;
            }
        });
    });
    
    // Print selected QR codes
    window.printQRCodes = function() {
        const selected = document.querySelectorAll('.qr-checkbox:checked');
        if (selected.length === 0) {
            // Show custom alert
            showNotification('Please select at least one QR code to print', 'warning');
            return;
        }
        
        // Add print animation to button
        const printBtn = document.querySelector('button[onclick="printQRCodes()"]');
        if (printBtn) {
            printBtn.classList.add('print-button');
            setTimeout(() => {
                printBtn.classList.remove('print-button');
            }, 200);
        }
        
        // Show print preview message
        showNotification(`Preparing to print ${selected.length} QR code(s)...`, 'info');
        
        // Trigger print after a short delay
        setTimeout(() => {
            window.print();
        }, 500);
    }
    
    // Custom notification function
    function showNotification(message, type = 'info') {
        // Remove existing notification
        const existingNotification = document.getElementById('custom-notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        // Create notification
        const notification = document.createElement('div');
        notification.id = 'custom-notification';
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg border-l-4 ${
            type === 'warning' 
                ? 'bg-yellow-50 border-yellow-500 text-yellow-800' 
                : 'bg-blue-50 border-blue-500 text-blue-800'
        }`;
        
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    ${
                        type === 'warning'
                            ? '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>'
                            : '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>'
                    }
                </svg>
                <span class="font-medium">${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s ease';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }
    
    // Add keyboard shortcut for print (Ctrl/Cmd + P)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
            e.preventDefault();
            printQRCodes();
        }
    });
    
    // Add print button tooltip
    const printButton = document.querySelector('button[onclick="printQRCodes()"]');
    if (printButton) {
        printButton.setAttribute('title', 'Print selected QR codes (Ctrl+P)');
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Projects\innovior info\Student Management System\resources\views/reception/qrcodes/print-batch.blade.php ENDPATH**/ ?>