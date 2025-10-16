@extends('layouts.reception')

@section('header', 'Student Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-semibold mb-6">Student Details</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                <p class="text-gray-800">{{ $student->first_name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                <p class="text-gray-800">{{ $student->last_name }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <p class="text-gray-800">{{ $student->email }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Student Phone</label>
                <p class="text-gray-800">{{ $student->student_phone }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Parent Phone</label>
                <p class="text-gray-800">{{ $student->parent_phone }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                <p class="text-gray-800">{{ $student->date_of_birth?->format('M j, Y') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                <p class="text-gray-800">{{ $student->course->name ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Registration Number</label>
                <p class="text-gray-800">{{ $student->registration_number }}</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <p class="text-gray-800">{{ $student->address ?: 'Not provided' }}</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">QR Code</label>
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

        <div class="mt-6 flex space-x-2">
            <a href="{{ route('reception.students.edit', $student) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Student
            </a>
            <a href="{{ route('reception.students.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Students
            </a>
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