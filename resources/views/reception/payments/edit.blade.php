@extends('layouts.reception')

@section('header', 'Edit Payment')
@section('title', 'Edit Payment')

@section('content')
<div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
    <!-- Header Section -->
    <div class="mb-4 md:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-3 sm:mb-0">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900">Edit Payment</h1>
                <p class="mt-1 text-xs md:text-sm text-gray-600">Update payment information for {{ $payment->student->name }}</p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="{{ route('reception.payments.index') }}" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Back to Payments
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
        <div class="mt-4 md:mt-6 p-3 md:p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm" role="alert">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-4 w-4 md:h-5 md:w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-2 md:ml-3">
                    <p class="text-xs md:text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="mt-4 md:mt-6 p-3 md:p-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-lg shadow-sm" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-4 w-4 md:h-5 md:w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-2 md:ml-3">
                    <h3 class="text-xs md:text-sm font-medium text-red-800">There were {{ $errors->count() }} error(s) with your submission</h3>
                    <div class="mt-2 text-xs md:text-sm text-red-700">
                        <ul class="list-disc pl-4 md:pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 md:p-4 lg:p-6">
        <form action="{{ route('reception.payments.update', $payment) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 lg:gap-6">
                <!-- Student -->
                <div class="md:col-span-2">
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Student:</label>
                    <div class="flex items-center bg-gray-50 border border-gray-300 rounded-lg p-2 md:p-3">
                        <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center mr-2 md:mr-3">
                            <span class="text-blue-600 font-semibold text-xs md:text-sm">
                                {{ substr($payment->student->first_name, 0, 1) }}{{ substr($payment->student->last_name, 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm md:text-base font-medium text-gray-900">{{ $payment->student->name }}</p>
                            <p class="text-xs text-gray-600">{{ $payment->student->registration_number }}</p>
                        </div>
                    </div>
                    <input type="hidden" name="student_id" value="{{ $payment->student_id }}">
                </div>

                <!-- Course -->
                <div>
                    <label for="course_id" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                        Course
                        <span class="text-red-500">*</span>
                    </label>
                    <select name="course_id" id="course_id" class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base appearance-none" required>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $payment->course_id == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Month Number -->
                <div>
                    <label for="month_number" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                        Month Number
                        <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="month_number" id="month_number" value="{{ $payment->month_number }}" 
                           class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                           required min="1" max="12" placeholder="Enter month number">
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                        Amount (Rs.)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2 md:pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-sm md:text-base"></span>
                        </div>
                        <input type="number" name="amount" id="amount" value="{{ $payment->amount }}" 
                               class="block w-full pl-6 md:pl-8 pr-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                               required step="0.01" placeholder="0.00">
                    </div>
                </div>

                <!-- Payment Date -->
                <div>
                    <label class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Payment Date & Time:</label>
                    <div class="flex items-center bg-gray-50 border border-gray-300 rounded-lg p-2 md:p-3">
                        <svg class="w-4 h-4 md:w-5 md:h-5 text-gray-400 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <p class="text-sm md:text-base font-medium text-gray-900">{{ $payment_date_formatted }}</p>
                            <p class="text-xs text-gray-600">Original payment date</p>
                        </div>
                    </div>
                    <input type="hidden" id="payment_date" value="{{ $payment_date_formatted }}">
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">Notes:</label>
                    <textarea name="notes" id="notes" rows="2" md:rows="3"
                              class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                              placeholder="Enter any additional notes about this payment">{{ $payment->notes }}</textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-4 md:pt-6 border-t border-gray-200 mt-4 md:mt-6">
                <div class="mb-3 sm:mb-0">
                    <a href="{{ route('reception.payments.index') }}" 
                       class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>
                </div>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                    <button type="reset" 
                            class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5 text-sm md:text-base w-full sm:w-auto justify-center">
                        <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Payment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Mobile optimizations */
    @media (max-width: 640px) {
        input, select, textarea {
            font-size: 14px;
        }
        
        .grid-cols-1 > div {
            margin-bottom: 0.75rem;
        }
        
        .gap-3 {
            gap: 0.75rem;
        }
        
        .py-1.5 {
            padding-top: 0.375rem;
            padding-bottom: 0.375rem;
        }
        
        .px-2 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        
        .pl-6 {
            padding-left: 1.5rem;
        }
        
        .w-8 {
            width: 2rem;
        }
        
        .h-8 {
            height: 2rem;
        }
        
        .text-sm {
            font-size: 0.8125rem;
        }
        
        .mr-2 {
            margin-right: 0.5rem;
        }
        
        .mt-4 {
            margin-top: 1rem;
        }
        
        .pt-4 {
            padding-top: 1rem;
        }
    }
    
    @media (max-width: 768px) {
        .md\:grid-cols-2 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
        .p-3 {
            padding: 0.75rem;
        }
        
        .py-2 {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }
        
        .text-sm {
            font-size: 0.8125rem;
        }
        
        .md\:col-span-2 {
            grid-column: span 1 / span 1;
        }
    }
    
    /* Tablet optimizations */
    @media (min-width: 769px) and (max-width: 1024px) {
        .md\:grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
        
        .md\:p-4 {
            padding: 1rem;
        }
        
        .md\:py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        
        .md\:col-span-2 {
            grid-column: span 2 / span 2;
        }
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
    
    /* Disable text selection on non-editable fields */
    .bg-gray-50 {
        user-select: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-format amount field
    const amountField = document.getElementById('amount');
    if (amountField) {
        amountField.addEventListener('blur', function() {
            if (this.value.trim()) {
                const value = parseFloat(this.value);
                if (!isNaN(value)) {
                    this.value = value.toFixed(2);
                }
            }
        });
        
        amountField.addEventListener('input', function() {
            // Remove non-numeric characters except decimal point
            this.value = this.value.replace(/[^0-9.]/g, '');
            
            // Ensure only one decimal point
            const decimalCount = (this.value.match(/\./g) || []).length;
            if (decimalCount > 1) {
                this.value = this.value.slice(0, -1);
            }
        });
    }
    
    // Month number validation
    const monthField = document.getElementById('month_number');
    if (monthField) {
        monthField.addEventListener('change', function() {
            const value = parseInt(this.value);
            if (value < 1) {
                this.value = 1;
            } else if (value > 12) {
                this.value = 12;
            }
        });
        
        monthField.addEventListener('input', function() {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
    
    // Make form more touch-friendly on mobile
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
            
            // Adjust textarea rows for mobile
            const textarea = document.getElementById('notes');
            if (textarea) {
                textarea.rows = 3;
            }
        }
    }
    
    // Initial adjustment
    adjustFormLayout();
    
    // Adjust on resize
    window.addEventListener('resize', adjustFormLayout);
});
</script>
@endsection