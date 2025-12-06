

<?php $__env->startSection('header', 'QR Code Management'); ?>
<?php $__env->startSection('title', 'Manage QR Codes'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total QR Codes</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($totalQRCodes); ?></h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-qrcode text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Assigned</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($assignedQRCodes); ?></h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Available</p>
                    <h3 class="text-2xl font-bold text-gray-800"><?php echo e($unassignedQRCodes); ?></h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-lg p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Generate New QR Codes</h2>
            <a href="<?php echo e(route('reception.qrcodes.print-batch')); ?>" class="btn-secondary">
                <i class="fas fa-print mr-2"></i> Print Batch
            </a>
        </div>
        
        <form action="<?php echo e(route('reception.qrcodes.generate')); ?>" method="POST" class="flex items-end gap-4">
            <?php echo csrf_field(); ?>
            <div class="flex-grow">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                <input type="number" name="quantity" id="quantity" min="1" max="100" value="10"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                <p class="mt-1 text-xs text-gray-500">Generate up to 100 QR codes at once</p>
            </div>
            <button type="submit" class="btn-primary">
                <i class="fas fa-plus mr-2"></i> Generate
            </button>
        </form>
    </div>

    <!-- QR Codes List -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">QR Code List</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned To</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $qrCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qrCode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-mono text-sm text-gray-900"><?php echo e($qrCode->code); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($qrCode->student_id): ?>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                    Assigned
                                </span>
                            <?php else: ?>
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">
                                    Available
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($qrCode->student): ?>
                                <div class="text-sm text-gray-900">
                                    <?php echo e($qrCode->student->full_name); ?>

                                </div>
                                <div class="text-xs text-gray-500">
                                    <?php echo e($qrCode->student->registration_number); ?>

                                </div>
                            <?php else: ?>
                                <span class="text-sm text-gray-500">Not Assigned</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($qrCode->created_at->format('M d, Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <?php if($qrCode->student_id): ?>
                                <form action="<?php echo e(route('reception.qrcodes.unassign', $qrCode)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-unlink"></i> Unassign
                                    </button>
                                </form>
                            <?php else: ?>
                                <button type="button" onclick="showAssignModal('<?php echo e($qrCode->id); ?>')" class="text-primary-600 hover:text-primary-900">
                                    <i class="fas fa-link"></i> Assign
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No QR codes found
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            <?php echo e($qrCodes->links()); ?>

        </div>
    </div>
</div>

<!-- Assign Modal -->
<div id="assignModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full"
    x-data="{ show: false }" x-show="show" x-cloak>
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-semibold text-gray-800">Assign QR Code</h3>
            <form id="assignForm" action="<?php echo e(route('reception.qrcodes.assign')); ?>" method="POST" class="mt-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="qr_code_id" id="assignQrCodeId">
                
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Select Student</label>
                    <select name="student_id" id="student_id" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Choose a student...</option>
                        <?php $__currentLoopData = App\Models\Student::whereDoesntHave('qrCode')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($student->id); ?>">
                                <?php echo e($student->full_name); ?> (<?php echo e($student->registration_number); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="hideAssignModal()"
                        class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function showAssignModal(qrCodeId) {
    document.getElementById('assignQrCodeId').value = qrCodeId;
    document.getElementById('assignModal').classList.remove('hidden');
}

function hideAssignModal() {
    document.getElementById('assignModal').classList.add('hidden');
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Innovior\Student Management System\resources\views/reception/qrcodes/manage.blade.php ENDPATH**/ ?>