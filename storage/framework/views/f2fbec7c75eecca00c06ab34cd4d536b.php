<?php $__env->startSection('header', 'Student Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h1 class="text-2xl font-semibold mb-6">Student Details</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                <p class="text-gray-800"><?php echo e($student->first_name); ?></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                <p class="text-gray-800"><?php echo e($student->last_name); ?></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <p class="text-gray-800"><?php echo e($student->email); ?></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Student Phone</label>
                <p class="text-gray-800"><?php echo e($student->student_phone); ?></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Parent Phone</label>
                <p class="text-gray-800"><?php echo e($student->parent_phone); ?></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                <p class="text-gray-800">
                    <?php echo e($student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M j, Y') : 'N/A'); ?>

                </p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                <p class="text-gray-800"><?php echo e(optional($student->course)->name ?? 'N/A'); ?></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Center</label>
                <p class="text-gray-800"><?php echo e(optional($student->center)->name ?? 'N/A'); ?></p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Registration Number</label>
                <p class="text-gray-800"><?php echo e($student->registration_number); ?></p>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <p class="text-gray-800"><?php echo e($student->address ?: 'Not provided'); ?></p>
            </div>

            
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">QR Code</label>

                <?php if($student->qr_code_path): ?>
                    <div class="mt-2 flex flex-col items-center bg-white p-6 border rounded-lg max-w-xs mx-auto">
                        <div class="mb-4 text-center">
                            <h3 class="text-lg font-semibold"><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></h3>
                            <p class="text-sm text-gray-600"><?php echo e($student->registration_number); ?></p>
                        </div>

                        <div class="qr-code-container border border-gray-200 p-4 rounded bg-white text-center">
                            <img src="<?php echo e(asset($student->qr_code_path)); ?>" alt="QR Code" class="mx-auto" style="width: 200px;">
                            <p class="font-mono text-sm text-gray-900 mt-2">
                                <!-- <?php echo e($student->registration_number); ?> --> 
                                   <?php echo e($student->qr_value ?? 'N/A'); ?>

                            </p>

                            <div class="mt-4 flex justify-center space-x-3">
                                <a href="<?php echo e(asset($student->qr_code_path)); ?>" download class="text-sm bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                                    <i class="fas fa-download mr-1"></i> Download QR
                                </a>
                                <button onclick="printQR()" class="text-sm bg-green-500 hover:bg-green-700 text-white py-2 px-4 rounded">
                                    <i class="fas fa-print mr-1"></i> Print
                                </button>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mt-2 text-center bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-yellow-700 mb-2">No QR code assigned to this student</p>

                        <form action="<?php echo e(route('reception.qrcodes.assign')); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">

                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded text-sm">
                                <i class="fas fa-qrcode mr-1"></i> Assign QR Code
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>

        <div class="mt-6 flex space-x-2">
            <a href="<?php echo e(route('reception.students.edit', $student)); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit Student
            </a>
            <a href="<?php echo e(route('reception.students.index')); ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Students
            </a>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<script>
function printQR() {
    const qrContainer = document.querySelector('.qr-code-container');
    const printWindow = window.open('', '', 'width=600,height=600');
    printWindow.document.write('<html><head><title>Print QR Code</title></head><body>');
    printWindow.document.write(qrContainer.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Projects\innovior info\Student Management System\resources\views/reception/students/show.blade.php ENDPATH**/ ?>