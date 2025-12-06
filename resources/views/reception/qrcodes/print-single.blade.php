@extends('layouts.reception')

@section('header', 'Print Student QR Code')
@section('title', 'Print QR Code')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">Print Student QR Code</h2>
                <p class="text-sm text-gray-600 mt-1">{{ $student->full_name }} ({{ $student->registration_number }})</p>
            </div>
            <button onclick="window.print()" class="btn-primary">
                <i class="fas fa-print mr-2"></i> Print QR Code
            </button>
        </div>

        <div id="printArea" class="max-w-sm mx-auto bg-white p-6 border rounded-lg">
            <div class="text-center mb-4">
                <h3 class="text-xl font-bold text-gray-900">{{ $student->full_name }}</h3>
                <p class="text-sm text-gray-600">{{ $student->registration_number }}</p>
                <p class="text-sm text-gray-600">{{ optional($student->course)->name }}</p>
            </div>

            <div class="flex justify-center mb-4">
                {!! QrCode::size(200)->generate(route('student.verify', $student->qrCode->code)) !!}
            </div>

            <div class="text-center">
                <div class="font-mono text-sm text-gray-900">{{ $student->qrCode->code }}</div>
                <div class="text-xs text-gray-500 mt-1">Printed: {{ now()->format('M d, Y') }}</div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
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
            left: 50%;
            transform: translateX(-50%);
            top: 1rem;
        }
    }
</style>
@endsection