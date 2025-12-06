<?php $__env->startSection('header', 'Scan Student QR Code'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-semibold mb-6 text-center">Scan QR Code for Attendance</h1>

        <div id="qr-reader" style="width: 100%;"></div>
        <div id="qr-reader-results" class="mt-4 text-center"></div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Handle on success condition with the decoded text or result.
        console.log(`Scan result: ${decodedText}`, decodedResult);
        document.getElementById('qr-reader-results').innerText = `Scanned: ${decodedText}`;

        // Send the scanned QR code to the server
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
        .then(response => response.json())
        .then(data => {
            console.log(data);
            alert(data.message);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while marking attendance.');
        });
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Innovior\Student Management System\resources\views/reception/attendance/scan.blade.php ENDPATH**/ ?>