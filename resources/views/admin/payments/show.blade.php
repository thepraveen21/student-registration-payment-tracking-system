@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">Payment Details</h2>
        </div>
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <div class="px-5 py-5 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Student</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $payment->student->first_name }} {{ $payment->student->last_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Amount</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $payment->amount }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Payment Date</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $payment->payment_date }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="mt-1 text-sm text-gray-900">{{ ucfirst($payment->status) }}</p>
                        </div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('admin.payments.edit', $payment->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <a href="{{ route('admin.payments.index') }}" class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
