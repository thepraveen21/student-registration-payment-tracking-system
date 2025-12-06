@extends('layouts.verify')

@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
            <div class="max-w-md mx-auto">
                <div class="divide-y divide-gray-200">
                    <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                        <div class="flex justify-center mb-8">
                            <svg class="w-20 h-20 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Student Verified</h2>
                            <p class="text-gray-500">This QR code belongs to:</p>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Name:</span>
                                    <span class="font-semibold text-gray-900">{{ $student->full_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Registration No:</span>
                                    <span class="font-semibold text-gray-900">{{ $student->registration_number }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Course:</span>
                                    <span class="font-semibold text-gray-900">{{ $student->course->name ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">QR Code:</span>
                                    <span class="font-mono text-sm text-gray-900">{{ $qrCode->code }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 text-center">
                            <p class="text-sm text-gray-500">Verified on {{ now()->format('M d, Y \a\t h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection