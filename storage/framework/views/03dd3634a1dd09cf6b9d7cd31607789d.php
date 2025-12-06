<?php $__env->startSection('header', 'Manage QR Codes'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Generate QR Codes Section -->
        <div class="bg-white shadow-md rounded-lg p-8">
            <h2 class="text-xl font-semibold mb-6">Generate New QR Codes</h2>
            <form action="<?php echo e(route('reception.qrcodes.generate')); ?>" method="POST">
                <?php echo csrf_field(); ?>
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

            <form id="assign-form" action="<?php echo e(route('reception.qrcodes.assign')); ?>" method="POST" class="mt-6 hidden">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label for="qr_code_data" class="block text-sm font-medium text-gray-700">Scanned QR Code</label>
                    <input type="text" name="qr_code" id="qr_code_data" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                </div>
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700">Select Student</label>
                    <select name="student_id" id="student_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($student->id); ?>"><?php echo e($student->name); ?> (<?php echo e($student->registration_number); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php $__empty_1 = true; $__currentLoopData = $unassignedQRCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qrCode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="py-2 px-4 border-b"><?php echo e($qrCode->code); ?></td>
                            <td class="py-2 px-4 border-b">
                                <a href="<?php echo e(asset($qrCode->qr_image_path)); ?>" download class="text-blue-500 hover:text-blue-700">Download</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="2" class="py-4 px-4 border-b text-center">No unassigned QR codes found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <?php echo e($unassignedQRCodes->links()); ?>

        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dell\Desktop\New folder (14)\Student Management System\resources\views/reception/qrcodes/manage.blade.php ENDPATH**/ ?>