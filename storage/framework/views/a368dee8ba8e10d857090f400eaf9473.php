<?php $__env->startSection('header', 'Scan Student QR Code'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-xl p-8 border border-gray-100">

        <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">
            Mark Attendance
        </h1>

        <!-- Notification Box -->
        <div id="alert-box" class="hidden p-4 mb-6 rounded-lg text-white text-center font-semibold"></div>

        <!-- QR Scanner Box -->
        <div class="border-2 border-gray-300 rounded-lg p-4 shadow-inner">
            <h2 class="text-lg font-semibold text-center mb-2 text-gray-700">Scan QR Code</h2>
            <div id="qr-reader" style="width: 100%;"></div>
        </div>

        <!-- Scan Result Student Card -->
        <div id="student-card" class="mt-6 hidden">
            <div class="bg-gray-50 border rounded-xl shadow p-5 flex gap-4 items-center">
                <div>
                    <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-gray-500"></i>
                    </div>
                </div>
                <div>
                    <h3 id="student-name" class="text-xl font-bold text-gray-800"></h3>
                    <p id="student-id" class="text-gray-600"></p>
                    <p id="student-course" class="text-gray-700 font-medium"></p>
                    <p id="student-time" class="text-gray-500 text-sm"></p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function showNotification(message, type = 'success') {
        const box = document.getElementById('alert-box');
        box.innerText = message;
        box.classList.remove("hidden");

        if (type === 'success') {
            box.classList.add("bg-green-600");
            box.classList.remove("bg-red-600");
        } else {
            box.classList.add("bg-red-600");
            box.classList.remove("bg-green-600");
        }

        setTimeout(() => {
            box.classList.add("hidden");
        }, 3000);
    }

    function fillStudentCard(data) {
        const card = document.getElementById('student-card');

        document.getElementById('student-name').innerText = data.student_name ?? 'Unknown';
        document.getElementById('student-id').innerText = "ID: " + (data.registration_number ?? 'N/A');
        document.getElementById('student-course').innerText = "Course: " + (data.course ?? 'Not Assigned');
        document.getElementById('student-time').innerText = "Time: " + (data.time ?? '--');

        card.classList.remove('hidden');
    }

    function onScanSuccess(decodedText) {
        fetch('<?php echo e(route('reception.attendance.store')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({
                qr_code: decodedText
            })
        })
        .then(res => res.json())
        .then(data => {
            showNotification(data.message, data.status ?? 'success');

            if (data.student_name) {
                fillStudentCard(data);
            }
        })
        .catch(() => {
            showNotification("Error marking attendance", "error");
        });
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", 
        { fps: 10, qrbox: 250 }
    );
    html5QrcodeScanner.render(onScanSuccess);
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Project\Student Management System\resources\views/reception/attendance/scan.blade.php ENDPATH**/ ?>