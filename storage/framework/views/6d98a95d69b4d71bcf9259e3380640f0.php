

<?php $__env->startSection('header', 'Schedule'); ?>
<?php $__env->startSection('title', 'Reception Schedule'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800">Schedule</h1>
        <p class="text-sm text-gray-600">All scheduled events and pending tasks.</p>
    </div>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Events</h3>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between p-3 rounded-lg 
                    <?php echo e((strtolower($schedule->status ?? $schedule['status']) == 'upcoming') ? 'bg-blue-50' : ((strtolower($schedule->status ?? $schedule['status']) == 'scheduled') ? 'bg-green-50' : 'bg-gray-50')); ?>">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-8 rounded-full 
                            <?php echo e((strtolower($schedule->status ?? $schedule['status']) == 'upcoming') ? 'bg-blue-500' : ((strtolower($schedule->status ?? $schedule['status']) == 'scheduled') ? 'bg-green-500' : 'bg-gray-400')); ?>"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800"><?php echo e($schedule->title ?? $schedule['title']); ?></p>
                            <p class="text-xs text-gray-600">
                                <?php echo e(($schedule->time ?? $schedule['time'])); ?>

                                - <?php echo e($schedule->location ?? $schedule['location']); ?>

                                (<?php echo e(\Illuminate\Support\Str::limit($schedule->date ?? ($schedule['date'] ?? ''), 10)); ?>)
                            </p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        <?php echo e((strtolower($schedule->status ?? $schedule['status']) == 'upcoming') ? 'bg-blue-100 text-blue-800' : ((strtolower($schedule->status ?? $schedule['status']) == 'scheduled') ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')); ?>">
                        <?php echo e($schedule->status ?? $schedule['status']); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-gray-500">No schedules found.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pending Tasks</h3>
        <div class="space-y-3">
            <?php $__empty_1 = true; $__currentLoopData = $pendingTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between p-3 border rounded-lg 
                    <?php echo e((strtolower($task->priority ?? $task['priority']) == 'urgent') ? 'border-red-200' : ((strtolower($task->priority ?? $task['priority']) == 'today') ? 'border-yellow-200' : 'border-blue-200')); ?>">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <div>
                            <p class="text-sm font-medium text-gray-800"><?php echo e($task->title ?? $task['title']); ?></p>
                            <?php if(!empty($task->description ?? ($task['description'] ?? null))): ?>
                                <p class="text-xs text-gray-600"><?php echo e($task->description ?? ($task['description'] ?? '')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <span class="text-sm <?php echo e((strtolower($task->priority ?? $task['priority']) == 'urgent') ? 'text-red-600' : ((strtolower($task->priority ?? $task['priority']) == 'today') ? 'text-yellow-600' : 'text-blue-600')); ?>">
                        <?php echo e(ucfirst($task->priority ?? $task['priority'])); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-gray-500">No pending tasks.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(cb => cb.addEventListener('change', function() {
            const item = this.closest('div.flex.items-center.justify-between');
            if (!item) return;
            if (this.checked) {
                item.style.opacity = '0.6';
                item.style.textDecoration = 'line-through';
            } else {
                item.style.opacity = '1';
                item.style.textDecoration = 'none';
            }
        }));
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Innovior\Student Management System\resources\views/reception/schedule/index.blade.php ENDPATH**/ ?>