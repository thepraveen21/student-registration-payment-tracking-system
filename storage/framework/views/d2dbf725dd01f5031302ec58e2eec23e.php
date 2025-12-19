

<?php $__env->startSection('header', 'Print QR Codes'); ?>
<?php $__env->startSection('title', 'Print QR Codes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
    <!-- Header Section -->
    <div class="mb-4 md:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-3 sm:mb-0">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900">Print QR Codes</h1>
                <p class="mt-1 text-xs md:text-sm text-gray-600">Generate and print unassigned QR codes</p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="<?php echo e(route('reception.qrcodes.manage')); ?>" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Management
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

    <!-- Control Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-4 md:mb-6 p-3 md:p-4 lg:p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
            <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-3">
                <button onclick="printQRCodes()" 
                        class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base w-full sm:w-auto justify-center h-[42px] md:h-[44px]">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span class="hidden sm:inline">Print Selected</span>
                    <span class="sm:hidden">Print</span>
                </button>
                
                <label class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200 text-sm md:text-base w-full sm:w-auto justify-center h-[42px] md:h-[44px]">
                    <input type="checkbox" id="selectAll" class="h-4 w-4 md:h-5 md:w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 focus:ring-2 transition-colors duration-200">
                    <span class="ml-2 md:ml-3 text-xs md:text-sm font-medium text-gray-700">Select All</span>
                </label>
            </div>
            
            <div class="text-xs md:text-sm text-gray-600 bg-gray-50 px-3 py-2 md:px-4 md:py-2 rounded-lg mt-3 md:mt-0 h-[42px] md:h-[44px] flex items-center">
                <svg class="w-3 h-3 md:w-4 md:h-4 inline mr-1 md:mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="truncate"><?php echo e($unassignedCodes->count()); ?> unassigned QR codes available</span>
            </div>
        </div>
    </div>

    <!-- QR Codes Grid -->
    <div id="printArea" class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4 lg:p-6">
        <?php if($unassignedCodes->count() > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-4 lg:gap-6">
            <?php $__currentLoopData = $unassignedCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qrCode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="qr-code-card border border-gray-200 rounded-xl p-3 md:p-4 hover:border-blue-300 hover:shadow-md transition-all duration-200 group flex flex-col">
                <label class="inline-flex items-center mb-2 md:mb-3 lg:mb-4 cursor-pointer">
                    <input type="checkbox" 
                           name="qr_codes[]" 
                           value="<?php echo e($qrCode->id); ?>" 
                           class="qr-checkbox h-4 w-4 md:h-5 md:w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 focus:ring-2 transition-colors duration-200">
                    <span class="ml-2 md:ml-3 text-xs md:text-sm font-medium text-gray-700 group-hover:text-blue-600 transition-colors duration-200 truncate">
                        Select for printing
                    </span>
                </label>
                
                <div class="flex-1 flex flex-col items-center justify-center">
                    <div class="w-full max-w-[200px] mx-auto flex items-center justify-center p-1">
                        <div class="bg-white p-2 md:p-3 rounded-lg border border-gray-100 shadow-inner w-full aspect-square flex items-center justify-center">
                            <div class="w-full h-full flex items-center justify-center">
                                <?php echo QrCode::size(150)->margin(1)->generate(route('student.verify', $qrCode->code)); ?>

                            </div>
                        </div>
                    </div>
                    
                    <div class="w-full text-center mt-2 md:mt-3">
                        <div class="font-mono text-xs md:text-sm font-semibold text-gray-900 bg-gray-50 py-1 md:py-2 px-2 md:px-3 rounded-lg break-all leading-tight">
                            <?php echo e($qrCode->code); ?>

                        </div>
                        
                        <div class="flex items-center justify-center text-xs text-gray-500 mt-1 md:mt-2">
                            <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <div class="py-8 md:py-10 lg:py-12 text-center">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-12 h-12 md:w-16 md:h-16 text-gray-300 mb-3 md:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <p class="text-sm md:text-base lg:text-lg font-medium text-gray-900 mb-1 md:mb-2">No unassigned QR codes available</p>
                <p class="text-xs md:text-sm text-gray-600 mb-4 md:mb-6 max-w-md mx-auto px-4">Generate new QR codes to start printing</p>
                <a href="<?php echo e(route('reception.qrcodes.manage')); ?>" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    /* Hide mobile menu button on this page */
    .mobile-menu-btn {
        display: none !important;
    }
    
    /* Print styles */
    @media print {
        body.is-printing .printable {
            visibility: visible;
        }
        body.is-printing .non-printable {
            display: none !important;
        }

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

        .qr-code-card:not(.selected-for-print) {
            display: none !important;
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
            display: flex !important;
            flex-direction: column !important;
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
        
        /* Print-specific QR code sizing */
        .qr-code-card .bg-white {
            width: 100% !important;
            max-width: 200px !important;
            height: auto !important;
            aspect-ratio: 1 / 1 !important;
            padding: 10px !important;
        }
        
        /* Ensure QR codes are centered and fit properly */
        .qr-code-card > div {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            flex: 1 !important;
        }
    }

    /* Mobile optimizations */
    @media (max-width: 640px) {
        .grid {
            gap: 1rem;
        }
        
        .qr-code-card {
            padding: 0.75rem;
            min-height: 200px;
        }
        
        .p-3 {
            padding: 0.75rem;
        }
        
        .text-xs {
            font-size: 0.65rem;
        }
        
        .text-sm {
            font-size: 0.75rem;
        }
        
        .h-4 {
            height: 1rem;
        }
        
        .w-4 {
            width: 1rem;
        }
        
        .mr-1.5 {
            margin-right: 0.375rem;
        }
        
        .ml-2 {
            margin-left: 0.5rem;
        }
        
        .mb-2 {
            margin-bottom: 0.5rem;
        }
        
        .py-2 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        
        .px-3 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        /* FIXED: Button alignment on mobile */
        .sm\:flex-row {
            flex-direction: row !important;
            align-items: center !important;
        }
        
        .sm\:space-y-0 {
            margin-top: 0 !important;
        }
        
        .space-y-2.sm\:space-y-0 {
            margin-top: 0 !important;
        }
        
        .space-y-2.sm\:space-y-0 > * + * {
            margin-top: 0 !important;
            margin-left: 0.75rem !important;
        }
        
        /* QR Code container fixes */
        .max-w-\[200px\] {
            max-width: 150px !important;
        }
        
        .aspect-square {
            aspect-ratio: 1 / 1;
        }
        
        /* Make QR codes responsive */
        .qr-code-card .bg-white {
            width: 100%;
            max-width: 150px;
            height: auto;
        }
        
        .qr-code-card .bg-white svg {
            width: 100% !important;
            height: 100% !important;
            max-width: 130px;
            max-height: 130px;
        }
        
        /* Better spacing for mobile grid */
        .grid-cols-1 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .gap-3 {
            gap: 0.75rem;
        }
        
        /* Make checkboxes more touch-friendly */
        .qr-checkbox {
            min-height: 1.25rem;
            min-width: 1.25rem;
        }
        
        /* Fix QR code text overflow */
        .break-all {
            word-break: break-all;
            font-size: 0.7rem;
            line-height: 1.2;
        }
        
        /* Fixed button heights for alignment */
        .h-\[42px\] {
            height: 42px !important;
        }
        
        /* Ensure buttons are same height on mobile */
        button, label[class*="inline-flex"] {
            min-height: 42px;
            display: inline-flex !important;
            align-items: center !important;
        }
    }
    
    @media (max-width: 768px) {
        .sm\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .lg\:grid-cols-3 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .xl\:grid-cols-4 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .text-sm {
            font-size: 0.8125rem;
        }
        
        .p-4 {
            padding: 1rem;
        }
        
        .py-4 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        
        /* FIXED: Button alignment improvements */
        .flex-col.md\:flex-row {
            flex-direction: column;
        }
        
        .md\:space-y-0 {
            margin-top: 0 !important;
        }
        
        /* Ensure buttons align properly */
        .flex-col.sm\:flex-row {
            flex-direction: row !important;
            align-items: center !important;
        }
        
        .sm\:space-x-3 > :not([hidden]) ~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(0.75rem * var(--tw-space-x-reverse));
            margin-left: calc(0.75rem * calc(1 - var(--tw-space-x-reverse)));
        }
        
        /* Adjust QR code size for mobile */
        .qr-code-card .bg-white {
            padding: 0.5rem;
        }
        
        /* Truncate long QR code values */
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        /* Ensure QR codes fit properly on tablet */
        .qr-code-card {
            max-width: 100%;
        }
        
        .max-w-\[200px\] {
            max-width: 180px;
        }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
        .lg\:grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        
        .xl\:grid-cols-4 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
        
        .md\:p-4 {
            padding: 1rem;
        }
        
        .md\:py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .md\:gap-4 {
            gap: 1rem;
        }
        
        .md\:px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .md\:ml-3 {
            margin-left: 0.75rem;
        }
        
        /* Fixed: Desktop button alignment */
        .md\:flex-row {
            flex-direction: row !important;
            align-items: center !important;
        }
        
        /* Tablet-specific QR code sizing */
        .qr-code-card .bg-white {
            width: 100%;
            max-width: 180px;
        }
        
        .max-w-\[200px\] {
            max-width: 180px;
        }
        
        /* Fixed: Button heights for alignment */
        .h-\[44px\] {
            height: 44px !important;
        }
    }
    
    @media (min-width: 1025px) {
        .xl\:grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
        
        /* Desktop QR code sizing */
        .qr-code-card .bg-white {
            width: 100%;
            max-width: 200px;
        }
        
        .max-w-\[200px\] {
            max-width: 200px;
        }
        
        /* Fixed: Ensure buttons are properly aligned */
        .flex-col.sm\:flex-row {
            flex-direction: row !important;
            align-items: center !important;
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
    
    /* Touch-friendly improvements */
    @media (max-width: 768px) {
        .qr-code-card {
            touch-action: manipulation;
        }
        
        button, label {
            min-height: 42px;
            display: inline-flex !important;
            align-items: center !important;
        }
        
        input[type="checkbox"] {
            min-height: 1.25rem;
            min-width: 1.25rem;
        }
        
        /* Better focus states for mobile */
        button:focus, input:focus, label:focus {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }
        
        /* Ensure QR codes don't overflow */
        .qr-code-card .bg-white {
            overflow: hidden;
        }
        
        .qr-code-card .bg-white svg {
            max-width: 100%;
            height: auto;
        }
    }
    
    /* FIXED: Button alignment and height consistency */
    .h-\[42px\] {
        height: 42px;
    }
    
    .h-\[44px\] {
        height: 44px;
    }
    
    button, label[class*="inline-flex"] {
        display: inline-flex !important;
        align-items: center !important;
    }
    
    /* Ensure all control elements are same height on mobile */
    @media (max-width: 768px) {
        .flex-col.sm\:flex-row {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        
        .space-y-2.sm\:space-y-0 {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            margin: 0 !important;
            width: 100%;
        }
        
        .space-y-2.sm\:space-y-0 > * {
            margin: 0 !important;
            flex: 1;
        }
        
        .space-y-2.sm\:space-y-0 > * + * {
            margin-left: 0.75rem !important;
        }
    }
    
    /* Ensure QR codes maintain aspect ratio */
    .qr-code-card .bg-white {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .qr-code-card .bg-white svg {
        width: 100%;
        height: 100%;
        max-width: 100%;
        max-height: 100%;
    }
    
    /* Make QR code cards consistent height */
    .qr-code-card {
        display: flex;
        flex-direction: column;
    }
    
    .qr-code-card > div:last-child {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('selectAll');
    const qrCheckboxes = document.querySelectorAll('.qr-checkbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function(e) {
            const isChecked = e.target.checked;
            qrCheckboxes.forEach(cb => {
                cb.checked = isChecked;
                const card = cb.closest('.qr-code-card');
                if (isChecked) {
                    card.classList.add('selected-for-print');
                } else {
                    card.classList.remove('selected-for-print');
                }
            });
        });
    }

    // Update select all checkbox state when individual checkboxes change
    qrCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const card = this.closest('.qr-code-card');
            if (this.checked) {
                card.classList.add('selected-for-print');
            } else {
                card.classList.remove('selected-for-print');
            }

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

        // Add is-printing class to body
        document.body.classList.add('is-printing');

        // Trigger print after a short delay
        setTimeout(() => {
            window.print();
            
            // Remove printing class after print dialog closes
            setTimeout(() => {
                document.body.classList.remove('is-printing');
            }, 500);
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
        notification.className = `fixed top-4 right-4 z-50 p-3 md:p-4 rounded-lg shadow-lg border-l-4 ${
            type === 'warning'
                ? 'bg-yellow-50 border-yellow-500 text-yellow-800'
                : 'bg-blue-50 border-blue-500 text-blue-800'
        } max-w-sm`;

        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    ${
                        type === 'warning'
                            ? '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>'
                            : '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>'
                    }
                </svg>
                <span class="text-xs md:text-sm font-medium">${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Position notification properly on mobile
        if (window.innerWidth < 768) {
            notification.className = notification.className.replace('right-4', 'left-4 right-4');
            notification.classList.add('mx-4');
        }

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

    // Add print button tooltip for desktop
    const printButton = document.querySelector('button[onclick="printQRCodes()"]');
    if (printButton && window.innerWidth > 768) {
        printButton.setAttribute('title', 'Print selected QR codes (Ctrl+P)');
    }

    // Make QR code cards more touch-friendly on mobile
    const qrCards = document.querySelectorAll('.qr-code-card');
    qrCards.forEach(card => {
        card.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.98)';
        });
        
        card.addEventListener('touchend', function() {
            this.style.transform = '';
        });
    });

    // Adjust QR code sizes based on screen size
    function adjustQRSizes() {
        const qrContainers = document.querySelectorAll('.qr-code-card .bg-white');
        const isMobile = window.innerWidth < 768;
        const isTablet = window.innerWidth >= 768 && window.innerWidth < 1024;
        
        qrContainers.forEach(container => {
            const svg = container.querySelector('svg');
            if (svg) {
                if (isMobile) {
                    svg.style.maxWidth = '130px';
                    svg.style.maxHeight = '130px';
                } else if (isTablet) {
                    svg.style.maxWidth = '160px';
                    svg.style.maxHeight = '160px';
                } else {
                    svg.style.maxWidth = '180px';
                    svg.style.maxHeight = '180px';
                }
            }
        });
    }
    
    // Fix button alignment on mobile
    function fixButtonAlignment() {
        const isMobile = window.innerWidth < 768;
        const buttonContainer = document.querySelector('.space-y-2.sm\\:space-y-0');
        
        if (isMobile && buttonContainer) {
            buttonContainer.classList.add('flex', 'flex-row', 'items-center');
            buttonContainer.classList.remove('flex-col', 'space-y-2');
            
            // Ensure buttons have proper spacing
            const buttons = buttonContainer.querySelectorAll('button, label');
            buttons.forEach((btn, index) => {
                if (index > 0) {
                    btn.style.marginLeft = '0.75rem';
                    btn.style.marginTop = '0';
                } else {
                    btn.style.marginTop = '0';
                }
            });
        }
    }
    
    // Initial adjustments
    adjustQRSizes();
    fixButtonAlignment();
    
    // Adjust on resize
    window.addEventListener('resize', function() {
        adjustQRSizes();
        fixButtonAlignment();
    });
    
    // Handle orientation change
    window.addEventListener('orientationchange', function() {
        setTimeout(function() {
            adjustQRSizes();
            fixButtonAlignment();
        }, 100);
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Project\Student Management System\resources\views/reception/qrcodes/print-batch.blade.php ENDPATH**/ ?>