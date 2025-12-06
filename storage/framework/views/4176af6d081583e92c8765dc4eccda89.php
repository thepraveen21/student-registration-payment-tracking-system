

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold leading-tight">Notifications</h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.notifications.create')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Send Manual Notification
                </a>
                <form action="<?php echo e(route('admin.notifications.send-overdue')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Send overdue payment notifications to all affected students?')">
                        Send Overdue Notifications
                    </button>
                </form>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?>

        <!-- Filters -->
        <div class="bg-white shadow rounded-lg p-4 mb-6">
            <form method="GET" action="<?php echo e(route('admin.notifications.index')); ?>">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Types</option>
                            <option value="overdue_payment" <?php echo e(request('type') == 'overdue_payment' ? 'selected' : ''); ?>>Overdue Payment</option>
                            <option value="general" <?php echo e(request('type') == 'general' ? 'selected' : ''); ?>>General</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Status</option>
                            <option value="sent" <?php echo e(request('status') == 'sent' ? 'selected' : ''); ?>>Sent</option>
                            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="failed" <?php echo e(request('status') == 'failed' ? 'selected' : ''); ?>>Failed</option>
                        </select>
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Filter
                        </button>
                        <a href="<?php echo e(route('admin.notifications.index')); ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        <div class="mb-4 flex space-x-2">
            <form action="<?php echo e(route('admin.notifications.retry-failed')); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-sm">
                    Retry Failed Notifications
                </button>
            </form>
        </div>

        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Student
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Type
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Message
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Method
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Sent At
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="<?php echo e(!$notification->is_read ? 'bg-blue-50' : ''); ?>">
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"><?php echo e($notification->student->full_name); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e($notification->student->email); ?></p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                    <?php if($notification->type == 'overdue_payment'): ?> text-red-800 bg-red-200
                                    <?php elseif($notification->type == 'payment_reminder'): ?> text-orange-800 bg-orange-200
                                    <?php elseif($notification->type == 'general'): ?> text-blue-800 bg-blue-200
                                    <?php else: ?> text-green-800 bg-green-200 <?php endif; ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $notification->type))); ?>

                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap font-medium"><?php echo e($notification->title); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e(Str::limit($notification->message, 50)); ?></p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap"><?php echo e($notification->sent_at->format('M d, Y')); ?></p>
                                <p class="text-gray-500 text-xs"><?php echo e($notification->sent_at->format('h:i A')); ?></p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <?php if($notification->is_read): ?>
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">
                                        Read
                                    </span>
                                <?php else: ?>
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full">
                                        Unread
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <?php if(!$notification->is_read): ?>
                                    <form action="<?php echo e(route('admin.notifications.mark-read', $notification)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit" class="text-green-600 hover:text-green-900 mr-3">Mark Read</button>
                                    </form>
                                <?php endif; ?>
                                <form action="<?php echo e(route('admin.notifications.destroy', $notification)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-gray-500">
                                No notifications found.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
                <?php if($notifications->hasPages()): ?>
                <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                    <span class="text-xs xs:text-sm text-gray-900">
                        Showing <?php echo e($notifications->firstItem()); ?> to <?php echo e($notifications->lastItem()); ?> of <?php echo e($notifications->total()); ?> Entries
                    </span>
                    <div class="inline-flex mt-2 xs:mt-0">
                        <?php echo e($notifications->links()); ?>

                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Innovior\Desktop\4.11 time\Student Management System\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>