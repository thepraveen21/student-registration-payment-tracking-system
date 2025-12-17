@extends('layouts.reception')

@section('header', 'Add Payment via QR')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">

        <h1 class="text-2xl font-semibold mb-6">Scan QR to Record Payment</h1>

        {{-- QR Scanner UI --}}
        <div class="mb-4">
            <button id="start-scan" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mb-2">
                Start Scanning
            </button>

            <button id="stop-scan" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded mb-2">
                Stop Scanning
            </button>

            <input type="file" id="qr-file" accept="image/*" class="block mb-3">

            <div id="qr-reader" class="border rounded p-2"></div>
        </div>

    </div>
</div>

{{-- Payment Modal --}}
<div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg transform scale-90 opacity-0 transition-all duration-300" id="paymentModalContent">
        <h2 class="text-xl font-bold mb-4">Record Payment</h2>

        <div id="studentInfo" class="mb-4 p-3 bg-gray-100 rounded"></div>

        <form id="paymentForm">
            @csrf

            {{-- HIDDEN FIELDS --}}
            <input type="hidden" id="student_id" name="student_id">
            <input type="hidden" id="course_id" name="course_id">

            {{-- FIXED DATE FORMAT --}}
            <input type="hidden" name="payment_date" id="payment_date"
                   value="{{ now()->format('Y-m-d\TH:i') }}">

            {{-- MONTH NUMBER --}}
            <label class="block mb-2 font-medium">Month Number</label>
            <select name="month_number" id="month_number" class="w-full p-2 border rounded mb-4" required>
                <option value="">Select Month</option>
                <option value="1">Month 1</option>
                <option value="2">Month 2</option>
                <option value="3">Month 3</option>
                <option value="4">Month 4</option>
            </select>

            {{-- AMOUNT --}}
            <label class="block mb-2 font-medium">Amount</label>
            <input type="number" name="amount" class="w-full p-2 border rounded mb-4" required>

            {{-- PAYMENT METHOD --}}
            <label class="block mb-2 font-medium">Payment Method</label>
            <select name="payment_method" class="w-full p-2 border rounded mb-4" required>
                <option value="">Select method</option>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>

            {{-- NOTES --}}
            <label class="block mb-2 font-medium">Notes (optional)</label>
            <textarea name="notes" class="w-full p-2 border rounded mb-4"></textarea>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Submit Payment
            </button>
        </form>

        <button onclick="closePaymentModal()" class="mt-3 w-full text-gray-600 hover:text-gray-900">
            Close
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    let scanner = null;
    let scanning = false;

    const startBtn = document.getElementById("start-scan");
    const stopBtn = document.getElementById("stop-scan");
    const qrFile = document.getElementById("qr-file");
    const paymentModal = document.getElementById("paymentModal");
    const paymentModalContent = document.getElementById("paymentModalContent");

    // START CAMERA SCANNING
    startBtn.addEventListener("click", () => {
        if (scanning) return;

        scanner = new Html5Qrcode("qr-reader");

        scanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: 250 },
            (decoded) => handleScan(decoded),
            () => {}
        ).then(() => scanning = true)
        .catch(err => alert("Camera error: " + err));
    });

    // STOP CAMERA
    stopBtn.addEventListener("click", () => {
        if (!scanner || !scanning) return;
        scanner.stop().then(() => {
            scanning = false;
            scanner.clear();
        });
    });

    // QR SCAN RESULT (FIXED SAFETY)
    function handleScan(code) {
        if (!scanning) return;

        scanning = false;
        scanner.stop().then(() => {
            scanner.clear();
            fetchStudent(code.trim());
        });
    }

    // SCAN FROM IMAGE (FIXED)
    qrFile.addEventListener("change", async function () {
        const file = this.files[0];
        if (!file) return;

        try {
            // Try real QR decode first
            const decodedText = await Html5Qrcode.scanFile(file, true);
            fetchStudent(decodedText.trim());
        } catch (e) {

            // 🔥 FALLBACK: use filename (QR00012.svg → QR00012)
            const fallbackCode = file.name
                .replace(/\.(png|jpg|jpeg|svg|webp)$/i, '')
                .trim()
                .toUpperCase();

            console.warn("QR image decode failed, using filename:", fallbackCode);
            fetchStudent(fallbackCode);
        }
    });


    // FETCH STUDENT
    function fetchStudent(code) {
        fetch("{{ route('reception.payments.getStudent') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ code })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert(data.message || "No student found for this QR code.");
                return;
            }
            openPaymentModal(data.student);
        });
    }

    // OPEN MODAL
    window.openPaymentModal = function(student) {
        paymentModal.classList.remove("hidden");
        setTimeout(() => {
            paymentModalContent.classList.remove("scale-90", "opacity-0");
            paymentModalContent.classList.add("scale-100", "opacity-100");
        }, 10);

        document.getElementById("studentInfo").innerHTML = `
            <p><strong>Name:</strong> ${student.full_name}</p>
            <p><strong>Registration No:</strong> ${student.registration_number}</p>
            <p><strong>Course:</strong> ${student.course?.name ?? 'N/A'}</p>
            <p><strong>Center:</strong> ${student.center?.name ?? 'N/A'}</p>
            <p><strong>Status:</strong> ${student.status}</p>
        `;

        document.getElementById("student_id").value = student.id;
        document.getElementById("course_id").value = student.course?.id ?? "";
    }

    // CLOSE MODAL
    window.closePaymentModal = function() {
        paymentModalContent.classList.remove("scale-100", "opacity-100");
        paymentModalContent.classList.add("scale-90", "opacity-0");
        setTimeout(() => paymentModal.classList.add("hidden"), 200);
    }

    // SUBMIT PAYMENT
    document.getElementById("paymentForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const data = {
            student_id: student_id.value,
            course_id: course_id.value,
            month_number: month_number.value,
            amount: this.amount.value,
            payment_method: this.payment_method.value,
            notes: this.notes.value,
            payment_date: payment_date.value,
            _token: "{{ csrf_token() }}"
        };

        fetch("{{ route('reception.payments.store') }}", {
            method: "POST",
            headers: { "Content-Type": "application/json", "Accept": "application/json" },
            body: JSON.stringify(data)
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alert("Payment recorded successfully!");
                closePaymentModal();
                this.reset();
            } else {
                alert(data.message || "Failed to record payment.");
            }
        });
    });

});
</script>

<style>
#paymentModal.hidden {
    display: none !important;
    opacity: 0 !important;
}

#paymentModal {
    display: flex;
    align-items: center;
    justify-content: center;
}

#paymentModalContent {
    transition: all 0.25s ease-out;
}

/* Ensure modal content scrolls on small screens */
#paymentModalContent {
    max-height: 90vh;
    overflow-y: auto;
}

.scale-90 { transform: scale(0.9); }
.scale-100 { transform: scale(1); }
.opacity-0 { opacity: 0; }
.opacity-100 { opacity: 1; }
</style>

@endpush
