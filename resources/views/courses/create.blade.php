@extends('layouts.reception')

@section('header', 'Add New Course')
@section('title', 'Course Management')

@section('content')
<div class="container mx-auto px-3 sm:px-4 md:px-6 lg:px-8 py-4 md:py-6 lg:py-8">
    <!-- Header Section -->
    <div class="mb-4 md:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="mb-3 sm:mb-0">
                <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900">Create New Course</h1>
                <p class="mt-1 text-xs md:text-sm text-gray-600">Add a new training course to the system</p>
            </div>
            <div class="mt-3 sm:mt-0">
                <a href="{{ route('reception.dashboard') ?? url()->previous() }}" 
                   class="inline-flex items-center px-3 py-2 md:px-4 md:py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base">
                    <svg class="w-4 h-4 md:w-5 md:h-5 mr-1.5 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancel
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

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-3 md:px-4 lg:px-6 py-3 md:py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center">
                <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-gray-600 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <h2 class="text-sm md:text-base lg:text-lg font-semibold text-gray-900">Course Details</h2>
            </div>
            <p class="text-xs md:text-sm text-gray-600 mt-1 ml-5 md:ml-8 lg:ml-9">Fill in the course information below</p>
        </div>
        
        <div class="p-3 md:p-4 lg:p-6">
            <form action="{{ route('courses.store') }}" method="POST" class="space-y-4 md:space-y-5 lg:space-y-6">
                @csrf

                <!-- Course Name Field -->
                <div class="space-y-1 md:space-y-2">
                    <label for="name" class="block text-xs md:text-sm font-medium text-gray-700">
                        Course Name
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-2 md:pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="block w-full pl-8 md:pl-10 pr-3 py-1.5 md:py-2 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base @error('name') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                               placeholder="Enter course name"
                               required
                               autofocus>
                    </div>
                    @error('name')
                    <div class="flex items-center mt-1 text-red-600 text-xs md:text-sm">
                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Description Field -->
                <div class="space-y-1 md:space-y-2">
                    <label for="description" class="block text-xs md:text-sm font-medium text-gray-700">
                        Description
                    </label>
                    <div class="relative">
                        <div class="absolute top-2 md:top-3 left-0 pl-2 md:pl-3 pointer-events-none">
                            <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3" md:rows="4"
                                  class="block w-full pl-7 md:pl-10 pr-3 py-1.5 md:py-2 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base @error('description') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                  placeholder="Enter course description">{{ old('description') }}</textarea>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Provide a brief description of the course</p>
                    @error('description')
                    <div class="flex items-center mt-1 text-red-600 text-xs md:text-sm">
                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Duration Field -->
                <div class="space-y-1 md:space-y-2">
                    <label for="duration" class="block text-xs md:text-sm font-medium text-gray-700">
                        Duration
                        <span class="text-red-500">*</span>
                    </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-2 md:pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   id="duration" 
                                   name="duration" 
                                   value="{{ old('duration') }}"
                                   class="block w-full pl-7 md:pl-10 pr-3 py-1.5 md:py-2 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base @error('duration') border-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                   placeholder="e.g., 3 Months, 1 Year"
                                   required>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Examples: 3 Months, 6 Weeks, 1 Year</p>
                        @error('duration')
                        <div class="flex items-center mt-1 text-red-600 text-xs md:text-sm">
                            <svg class="w-3 h-3 md:w-4 md:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
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
                    
                    <div x-show="showAdditional" x-collapse class="space-y-3 md:space-y-4 lg:space-y-6 pl-4 md:pl-6 border-l-2 border-gray-200 pt-2">
                        <!-- Maximum Students Field -->
                        <div class="space-y-1 md:space-y-2">
                            <label for="max_students" class="block text-xs md:text-sm font-medium text-gray-700">
                                Maximum Students
                            </label>
                            <input type="number" 
                                   id="max_students" 
                                   name="max_students" 
                                   value="{{ old('max_students') }}"
                                   min="1"
                                   class="block w-full px-2 md:px-3 py-1.5 md:py-2 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base"
                                   placeholder="Optional">
                            <p class="text-xs text-gray-500 mt-1">Leave empty for unlimited enrollment</p>
                        </div>

                        <!-- Status Field -->
                        <div class="space-y-1 md:space-y-2">
                            <label for="status" class="block text-xs md:text-sm font-medium text-gray-700">
                                Course Status
                            </label>
                            <select id="status" 
                                    name="status"
                                    class="block w-full px-2 md:px-3 py-1.5 md:py-2 lg:py-2.5 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-sm md:text-base appearance-none">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                            </select>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create Course
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Courses List Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
        <div class="px-3 md:px-4 lg:px-6 py-3 md:py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6 text-gray-600 mr-2 md:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <div>
                        <h2 class="text-sm md:text-base lg:text-lg font-semibold text-gray-900">All Courses</h2>
                        <p class="text-xs md:text-sm text-gray-600 mt-0.5">Manage existing courses</p>
                    </div>
                </div>
                <span class="px-2 md:px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs md:text-sm font-semibold">
                    {{ $courses->count() }} {{ $courses->count() === 1 ? 'Course' : 'Courses' }}
                </span>
            </div>
        </div>
        
        <div class="p-3 md:p-4 lg:p-6">
            @if($courses->isEmpty())
                <div class="text-center py-8 md:py-12">
                    <svg class="mx-auto h-12 w-12 md:h-16 md:w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="mt-2 text-sm md:text-base font-semibold text-gray-900">No courses yet</h3>
                    <p class="mt-1 text-xs md:text-sm text-gray-500">Get started by creating a new course above.</p>
                </div>
            @else
                <div class="space-y-2 md:space-y-3">
                    @foreach($courses as $course)
                        <div class="flex items-center justify-between p-3 md:p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-200 bg-white hover:bg-gray-50">
                            <div class="flex-1 min-w-0 mr-3">
                                <div class="flex items-center space-x-2 md:space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3 class="text-sm md:text-base font-semibold text-gray-900 truncate">{{ $course->name }}</h3>
                                        @if($course->description)
                                            <p class="text-xs md:text-sm text-gray-600 mt-0.5 truncate">{{ Str::limit($course->description, 60) }}</p>
                                        @endif
                                        <div class="flex flex-wrap items-center gap-2 md:gap-3 mt-1">
                                            @if($course->duration)
                                                <div class="flex items-center text-xs text-gray-500">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $course->duration }}
                                                </div>
                                            @endif
                                            <div class="flex items-center text-xs text-gray-500">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                                </svg>
                                                {{ $course->students_count ?? 0 }} students
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="delete-course-form inline-block" data-course-name="{{ $course->name }}" data-student-count="{{ $course->students_count ?? 0 }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="delete-course-btn inline-flex items-center px-2 md:px-3 py-1.5 md:py-2 bg-red-600 hover:bg-red-700 text-white text-xs md:text-sm font-medium rounded-lg shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
                                            title="Delete course">
                                        <svg class="w-3 h-3 md:w-4 md:h-4 mr-1 md:mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span class="hidden sm:inline">Delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Error Message Alert -->
    @if (session('error'))
    <div class="mt-4 md:mt-6 p-3 md:p-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 rounded-lg shadow-sm" role="alert">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-4 w-4 md:h-5 md:w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-2 md:ml-3">
                <p class="text-xs md:text-sm font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif
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
        
        .pl-7 {
            padding-left: 1.75rem;
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
        
        textarea {
            min-height: 5rem;
        }
        
        /* Better number input on mobile */
        input[type="number"] {
            -webkit-appearance: none;
            -moz-appearance: textfield;
        }
        
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    }
    
    @media (max-width: 768px) {
        .md\:grid-cols-2 {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
        
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
        
        .pt-2 {
            padding-top: 0.5rem;
        }
        
        .gap-3 {
            gap: 0.75rem;
        }
    }
    
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
        
        .md\:pl-10 {
            padding-left: 2.5rem;
        }
        
        .md\:gap-4 {
            gap: 1rem;
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
    
    /* Textarea specific styling */
    textarea {
        resize: vertical;
        min-height: 5rem;
        max-height: 15rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete course confirmation
    const deleteCourseBtns = document.querySelectorAll('.delete-course-btn');
    deleteCourseBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-course-form');
            const courseName = form.dataset.courseName;
            const studentCount = parseInt(form.dataset.studentCount);
            
            let message = `Are you sure you want to delete "${courseName}"?`;
            
            if (studentCount > 0) {
                message = `Cannot delete "${courseName}" because it has ${studentCount} student(s) enrolled in it.\n\nPlease reassign or remove the students first.`;
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
    
    // Price field formatting
    const priceField = document.getElementById('price');
    if (priceField) {
        priceField.addEventListener('blur', function() {
            if (this.value && !isNaN(this.value)) {
                const value = parseFloat(this.value);
                if (!isNaN(value)) {
                    this.value = value.toFixed(2);
                }
            }
        });
        
        priceField.addEventListener('input', function() {
            // Allow only numbers and one decimal point
            this.value = this.value.replace(/[^0-9.]/g, '');
            
            // Ensure only one decimal point
            const decimalCount = (this.value.match(/\./g) || []).length;
            if (decimalCount > 1) {
                this.value = this.value.slice(0, -1);
            }
            
            // Validate minimum value
            if (this.value && parseFloat(this.value) < 0) {
                this.value = '0';
            }
        });
    }
    
    // Duration field suggestions
    const durationField = document.getElementById('duration');
    if (durationField) {
        const suggestions = ['3 Months', '6 Months', '1 Year', '2 Years', '6 Weeks', '12 Weeks'];
        let suggestionTimeout;
        
        durationField.addEventListener('input', function() {
            clearTimeout(suggestionTimeout);
            const value = this.value.toLowerCase();
            
            if (value.length > 1) {
                suggestionTimeout = setTimeout(() => {
                    const matchedSuggestion = suggestions.find(s => 
                        s.toLowerCase().includes(value)
                    );
                    
                    if (matchedSuggestion && value !== matchedSuggestion.toLowerCase()) {
                        // Show suggestion but don't auto-fill
                        console.log('Suggested:', matchedSuggestion);
                    }
                }, 500);
            }
        });
        
        durationField.addEventListener('blur', function() {
            if (this.value.trim()) {
                // Capitalize first letter
                this.value = this.value.trim().charAt(0).toUpperCase() + 
                            this.value.trim().slice(1);
            }
        });
    }
    
    // Max students field validation
    const maxStudentsField = document.getElementById('max_students');
    if (maxStudentsField) {
        maxStudentsField.addEventListener('input', function() {
            // Allow only numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Validate minimum value
            if (this.value && parseInt(this.value) < 1) {
                this.value = '1';
            }
        });
    }
    
    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            let hasError = false;
            
            // Validate required fields
            const requiredFields = [
                { id: 'name', message: 'Course name is required' },

                { id: 'duration', message: 'Duration is required' }
            ];
            
            requiredFields.forEach(field => {
                const fieldElement = document.getElementById(field.id);
                if (fieldElement && !fieldElement.value.trim()) {
                    e.preventDefault();
                    showFieldError(fieldElement, field.message);
                    if (!hasError) {
                        fieldElement.focus();
                        hasError = true;
                    }
                }
            });
            
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
                    Creating Course...
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
            
            // Adjust textarea rows for mobile
            const textarea = document.getElementById('description');
            if (textarea) {
                textarea.rows = 4;
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