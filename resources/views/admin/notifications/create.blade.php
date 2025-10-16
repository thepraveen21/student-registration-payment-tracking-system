@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold leading-tight">Send Manual Notification</h2>
            <a href="{{ route('admin.notifications.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Notifications
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded-lg p-8">
            <form action="{{ route('admin.notifications.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700">Student</label>
                        <select name="student_id" id="student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            <option value="">Select a student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->full_name }} ({{ $student->registration_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Notification Type</label>
                        <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            <option value="">Select type</option>
                            <option value="overdue_payment" {{ old('type') == 'overdue_payment' ? 'selected' : '' }}>Overdue Payment</option>
                            <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required placeholder="Enter notification title">
                </div>

                <div class="mt-6">
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea name="message" id="message" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required placeholder="Enter your message here...">{{ old('message') }}</textarea>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.notifications.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-6 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                        Send Notification
                    </button>
                </div>
            </form>
        </div>

        <!-- Quick Templates -->
        <div class="mt-8 bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium mb-4">Quick Templates</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border rounded-lg p-4 cursor-pointer hover:bg-gray-50" onclick="fillTemplate('overdue_payment', 'Payment Overdue', 'Dear student, your payment is overdue. Please make the payment immediately to avoid any penalties.')">
                    <h4 class="font-medium text-red-600">Overdue Payment</h4>
                    <p class="text-sm text-gray-500 mt-1">Overdue payment notification template</p>
                </div>
                <div class="border rounded-lg p-4 cursor-pointer hover:bg-gray-50" onclick="fillTemplate('general', 'Important Notice', 'We would like to inform you about an important update. Please contact the office for more details.')">
                    <h4 class="font-medium text-green-600">General Notice</h4>
                    <p class="text-sm text-gray-500 mt-1">General information template</p>
                </div>
                <div class="border rounded-lg p-4 cursor-pointer hover:bg-gray-50" onclick="fillTemplate('general', 'Document Submission', 'Please submit the required documents to complete your enrollment process. Contact the office if you need assistance.')">
                    <h4 class="font-medium text-orange-600">Document Request</h4>
                    <p class="text-sm text-gray-500 mt-1">Document submission reminder template</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fillTemplate(type, title, message) {
    document.getElementById('type').value = type;
    document.getElementById('title').value = title;
    document.getElementById('message').value = message;
}
</script>
@endsection