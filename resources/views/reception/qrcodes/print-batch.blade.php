@extends('layouts.reception')

@section('header', 'Print QR Codes')
@section('title', 'Print QR Codes')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-800">Print QR Codes</h2>
            <a href="{{ route('reception.qrcodes.manage') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Back to Management
            </a>
        </div>

        <div class="mb-6">
            <div class="flex items-center gap-4">
                <button onclick="printQRCodes()" class="btn-primary">
                    <i class="fas fa-print mr-2"></i> Print Selected
                </button>
                <label class="inline-flex items-center">
                    <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Select All</span>
                </label>
            </div>
        </div>

        <div id="printArea" class="grid grid-cols-3 gap-4">
            @forelse($unassignedCodes as $qrCode)
            <div class="qr-code-card border rounded-lg p-4 text-center">
                <label class="inline-flex items-center mb-4">
                    <input type="checkbox" name="qr_codes[]" value="{{ $qrCode->id }}" class="qr-checkbox rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Select for printing</span>
                </label>
                <div class="flex justify-center mb-2">
                    {!! QrCode::size(150)->generate(route('student.verify', $qrCode->code)) !!}
                </div>
                <div class="font-mono text-sm text-gray-900 mt-2">{{ $qrCode->code }}</div>
                <div class="text-xs text-gray-500 mt-1">Generated: {{ $qrCode->created_at->format('M d, Y') }}</div>
            </div>
            @empty
            <div class="col-span-3 text-center py-8">
                <p class="text-gray-500">No unassigned QR codes available for printing.</p>
                <a href="{{ route('reception.qrcodes.manage') }}" class="btn-primary inline-block mt-4">
                    Generate New QR Codes
                </a>
            </div>
            @endforelse
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
            left: 0;
            top: 0;
            width: 100%;
        }
        .qr-checkbox, label {
            display: none !important;
        }
        .qr-code-card {
            break-inside: avoid;
            page-break-inside: avoid;
            border: none !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
document.getElementById('selectAll').addEventListener('change', function(e) {
    document.querySelectorAll('.qr-checkbox').forEach(cb => {
        cb.checked = e.target.checked;
    });
});

function printQRCodes() {
    const selected = document.querySelectorAll('.qr-checkbox:checked');
    if (selected.length === 0) {
        alert('Please select at least one QR code to print');
        return;
    }
    window.print();
}
</script>
@endsection