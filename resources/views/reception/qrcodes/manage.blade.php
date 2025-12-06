@extends('layouts.reception')

@section('header', 'Manage QR Codes')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Generate QR Codes Section -->
        <div class="bg-white shadow-md rounded-lg p-8">
            <h2 class="text-xl font-semibold mb-6">Generate New QR Codes</h2>
            <form action="{{ route('reception.qrcodes.generate') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="count" class="block text-sm font-medium text-gray-700">Number of QR Codes to Generate</label>
                    <input type="number" name="count" id="count" min="1" max="100" value="10" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Generate
                </button>
            </form>
        </div>

        <!-- Assign QR Code Section -->
        <div class="bg-white shadow-md rounded-lg p-8">
            <h2 class="text-xl font-semibold mb-6">Assign QR Code to Student</h2>
            <div id="qr-reader-assign" style="width: 100%;"></div>
            <div id="qr-reader-results-assign" class="mt-4 text-center"></div>

            <form id="assign-form" action="{{ route('reception.qrcodes.assign') }}" method="POST" class="mt-6 hidden">
                @csrf
                <div class="mb-4">
                    <label for="qr_code_data" class="block text-sm font-medium text-gray-700">Scanned QR Code</label>
                    <input type="text" name="qr_code" id="qr_code_data" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                </div>
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Select Student</label>
                    <select name="student_id" id="student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->registration_number }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Assign QR Code
                </button>
            </form>
        </div>
    </div>

    <!-- Unassigned QR Codes Section -->
    <div class="mt-8 bg-white shadow-md rounded-lg p-8">
        <h2 class="text-xl font-semibold mb-6">Unassigned QR Codes</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">QR Code</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($unassignedQRCodes as $qrCode)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $qrCode->code }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ asset($qrCode->qr_image_path) }}" download class="text-blue-500 hover:text-blue-700">Download</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="py-4 px-4 border-b text-center">No unassigned QR codes found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $unassignedQRCodes->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
    function onScanSuccessAssign(decodedText, decodedResult) {
        // Handle on success condition with the decoded text or result.
        console.log(`Scan result: ${decodedText}`, decodedResult);
        document.getElementById('qr-reader-results-assign').innerText = `Scanned: ${decodedText}`;
        document.getElementById('qr_code_data').value = decodedText;
        document.getElementById('assign-form').classList.remove('hidden');
    }

    var html5QrcodeScannerAssign = new Html5QrcodeScanner(
        "qr-reader-assign", { fps: 10, qrbox: 250 });
    html5QrcodeScannerAssign.render(onScanSuccessAssign);
</script>
@endpush
@endsection
