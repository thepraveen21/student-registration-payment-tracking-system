@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">Student Details</h2>
        </div>
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <div class="px-5 py-5 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">First Name</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->first_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Last Name</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->last_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Student Phone</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->student_phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Parent Phone</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->parent_phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->date_of_birth }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Address</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->address }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Course</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->course->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="mt-1 text-sm text-gray-900">{{ ucfirst($student->status) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Registration Number</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $student->registration_number }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm font-medium text-gray-500">QR Code</p>
                            @if($student->qr_code_path)
                                <div class="mt-2 flex flex-col items-center">
                                    <img src="{{ $student->qr_code_url }}" alt="Student QR Code" class="w-48 h-48 border border-gray-300 rounded">
                                    <div class="mt-2 flex space-x-2">
                                        <a href="{{ $student->qr_code_url }}" download="QR_{{ $student->registration_number }}.svg" 
                                           class="text-sm bg-green-500 hover:bg-green-700 text-white py-1 px-3 rounded">
                                            <i class="fas fa-download mr-1"></i>Download QR
                                        </a>
                                        <button onclick="printQR()" class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded">
                                            <i class="fas fa-print mr-1"></i>Print QR
                                        </button>
                                    </div>
                                </div>
                            @else
                                <p class="mt-1 text-sm text-gray-500">No QR code generated</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('admin.students.edit', $student->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <a href="{{ route('admin.students.index') }}" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printQR() {
    const qrImage = document.querySelector('img[alt="Student QR Code"]');
    if (qrImage) {
        const printWindow = window.open('', '', 'width=600,height=600');
        printWindow.document.write(`
            <html>
                <head>
                    <title>Print QR Code - {{ $student->registration_number }}</title>
                    <style>
                        body { 
                            display: flex; 
                            justify-content: center; 
                            align-items: center; 
                            min-height: 100vh; 
                            margin: 0; 
                            font-family: Arial, sans-serif;
                        }
                        .qr-container {
                            text-align: center;
                            padding: 20px;
                        }
                        .qr-code {
                            width: 300px;
                            height: 300px;
                            margin: 20px auto;
                        }
                        h2 { margin: 10px 0; }
                        p { margin: 5px 0; }
                    </style>
                </head>
                <body>
                    <div class="qr-container">
                        <h2>{{ $student->full_name }}</h2>
                        <p>Registration: {{ $student->registration_number }}</p>
                        <p>Course: {{ $student->course->name ?? 'N/A' }}</p>
                        <img src="${qrImage.src}" alt="QR Code" class="qr-code">
                        <p style="font-size: 12px; color: #666;">Scan this QR code for student identification</p>
                    </div>
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }
}
</script>
@endsection
