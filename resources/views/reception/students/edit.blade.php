@extends('layouts.reception')

@section('header', 'Edit Student')
@section('title', 'Edit Student')

@section('content')
<div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
    <!-- Header Section -->
    <div class="mb-4 md:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-3 sm:mb-0">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900">Edit Student</h1>
                <p class="mt-1 text-xs md:text-sm text-gray-600">Update information for {{ $student->first_name }} {{ $student->last_name }}</p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="{{ route('reception.students.show', $student) }}" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Back to Profile
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
        <form action="{{ route('reception.students.update', $student) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Student Info Header -->
            <div class="flex items-center mb-4 md:mb-6 lg:mb-8">
                <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg md:rounded-xl flex items-center justify-center shadow-sm mr-3 md:mr-4 lg:mr-6">
                    <span class="text-blue-600 font-semibold text-base md:text-lg lg:text-xl">
                        {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                    </span>
                </div>
                <div class="min-w-0">
                    <h2 class="text-base md:text-lg lg:text-xl font-bold text-gray-900 truncate">{{ $student->first_name }} {{ $student->last_name }}</h2>
                    <div class="flex flex-wrap items-center mt-1 gap-1 md:gap-2">
                        <span class="text-xs text-gray-600">ID: {{ $student->id }}</span>
                        <span class="hidden sm:inline text-xs text-gray-400">•</span>
                        <span class="text-xs font-mono text-gray-600 truncate">{{ $student->registration_number }}</span>
                    </div>
                </div>
            </div>

            <!-- Personal Information Section -->
            <div class="mb-4 md:mb-6 lg:mb-8">
                <h3 class="text-sm md:text-base lg:text-lg font-semibold text-gray-900 mb-3 md:mb-4 pb-2 md:pb-3 border-b border-gray-200">Personal Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 lg:gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            First Name
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $student->first_name) }}" 
                               class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                               placeholder="Enter first name"
                               required>
                    </div>
                    
                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            Last Name
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $student->last_name) }}" 
                               class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                               placeholder="Enter last name"
                               required>
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            Email Address
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" 
                               class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                               placeholder="student@example.com"
                               required>
                    </div>
                    
                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            Date of Birth
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth?->format('Y-m-d')) }}" 
                               class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                               required>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="mb-4 md:mb-6 lg:mb-8">
                <h3 class="text-sm md:text-base lg:text-lg font-semibold text-gray-900 mb-3 md:mb-4 pb-2 md:pb-3 border-b border-gray-200">Contact Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 lg:gap-6">
                    <!-- Student Phone -->
                    <div>
                        <label for="student_phone" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            Student Phone
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="student_phone" id="student_phone" value="{{ old('student_phone', $student->student_phone) }}" 
                               class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                               placeholder="Enter student phone number"
                               required>
                    </div>
                    
                    <!-- Parent Phone -->
                    <div>
                        <label for="parent_phone" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            Parent Phone
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="parent_phone" id="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}" 
                               class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                               placeholder="Enter parent phone number"
                               required>
                    </div>
                    
                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            Address
                        </label>
                        <textarea name="address" id="address" rows="2" md:rows="3"
                                  class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                  placeholder="Enter student's address">{{ old('address', $student->address) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Course & Status Section -->
            <div class="mb-4 md:mb-6 lg:mb-8">
                <h3 class="text-sm md:text-base lg:text-lg font-semibold text-gray-900 mb-3 md:mb-4 pb-2 md:pb-3 border-b border-gray-200">Academic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 lg:gap-6">
                    <!-- Course -->
                    <div>
                        <label for="course_id" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            Course
                            <span class="text-red-500">*</span>
                        </label>
                        <select name="course_id" id="course_id" 
                                class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                required>
                            <option value="">Select a Course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $student->course_id) == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Center -->
                    <div>
                        <label for="center_id" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            Center
                        </label>
                        <select name="center_id" id="center_id" 
                                class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                            <option value="">Select a Center (Optional)</option>
                            @foreach($centers as $center)
                                <option value="{{ $center->id }}" {{ old('center_id', $student->center_id) == $center->id ? 'selected' : '' }}>
                                    {{ $center->name }} - {{ $center->location }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-xs md:text-sm font-medium text-gray-700 mb-1 md:mb-2">
                            Status
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="status" id="status" 
                                    class="block w-full px-2 py-1.5 md:px-3 md:py-2 lg:px-3 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base appearance-none"
                                    required>
                                <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-3 w-3 md:h-4 md:w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2 flex items-center text-xs text-gray-500">
                            @if(old('status', $student->status) == 'active')
                            <span class="inline-flex items-center px-2 py-0.5 md:px-2 md:py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span class="hidden sm:inline">Currently Active</span>
                                <span class="sm:hidden">Active</span>
                            </span>
                            @else
                            <span class="inline-flex items-center px-2 py-0.5 md:px-2 md:py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <span class="hidden sm:inline">Currently Inactive</span>
                                <span class="sm:hidden">Inactive</span>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pt-4 md:pt-6 border-t border-gray-200">
                <div class="mb-3 sm:mb-0">
                    <a href="{{ route('reception.students.show', $student) }}" 
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
                        Update Student
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
        
        .w-10 {
            width: 2.5rem;
        }
        
        .h-10 {
            height: 2.5rem;
        }
        
        .text-base {
            font-size: 1rem;
        }
        
        .mr-3 {
            margin-right: 0.75rem;
        }
        
        .mb-4 {
            margin-bottom: 1rem;
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
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-capitalize first letter of name fields
    const nameFields = ['first_name', 'last_name'];
    
    nameFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            // Capitalize on blur (when user leaves the field)
            field.addEventListener('blur', function() {
                if (this.value.trim()) {
                    this.value = this.value.trim().charAt(0).toUpperCase() + 
                                this.value.trim().slice(1).toLowerCase();
                }
            });
            
            // Capitalize first letter while typing
            field.addEventListener('input', function() {
                if (this.value.length === 1) {
                    this.value = this.value.toUpperCase();
                }
            });
        }
    });
    
    // Make form more touch-friendly on mobile
    const formInputs = document.querySelectorAll('input, select, textarea, button');
    formInputs.forEach(input => {
        input.addEventListener('touchstart', function() {
            this.style.transform = 'scale(0.98)';
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
@endsection