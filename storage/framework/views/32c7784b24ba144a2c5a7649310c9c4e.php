

<?php $__env->startSection('header', 'Schedule'); ?>
<?php $__env->startSection('title', 'Reception Schedule'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    <!-- Header Section -->
    <div class="mb-6 md:mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Reception Schedule</h1>
                <p class="mt-1 md:mt-2 text-sm text-gray-600">Manage all scheduled events and pending tasks</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <button type="button" id="add-schedule-btn"
                        class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Schedule
                </button>
            </div>
        </div>
    </div>

    <!-- Events Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Events</h3>
                    <p class="text-sm text-gray-600 mt-1">Upcoming and scheduled events</p>
                </div>
                <div class="flex space-x-2">
                    <button type="button" class="filter-button px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200" data-filter="all">All Events</button>
                    <button type="button" class="filter-button px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200" data-filter="upcoming">Upcoming</button>
                    <button type="button" class="filter-button px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200" data-filter="scheduled">Scheduled</button>
                </div>
            </div>
        </div>
        
        <div class="divide-y divide-gray-200">
            <?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-3 h-3 rounded-full 
                                <?php echo e((strtolower($schedule->status ?? $schedule['status']) == 'upcoming') ? 'bg-blue-500' : ((strtolower($schedule->status ?? $schedule['status']) == 'scheduled') ? 'bg-green-500' : 'bg-gray-400')); ?>">
                            </div>
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center space-x-3">
                                <h4 class="text-sm font-medium text-gray-900"><?php echo e($schedule->title ?? $schedule['title']); ?></h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    <?php echo e((strtolower($schedule->status ?? $schedule['status']) == 'upcoming') ? 'bg-blue-100 text-blue-800' : ((strtolower($schedule->status ?? $schedule['status']) == 'scheduled') ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')); ?>">
                                    <?php echo e(ucfirst($schedule->status ?? $schedule['status'])); ?>

                                </span>
                            </div>
                            <div class="mt-2 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <?php echo e(\Carbon\Carbon::parse($schedule->time ?? $schedule['time'])->format('h:i A')); ?>

                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php echo e($schedule->location ?? $schedule['location']); ?>

                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <?php echo e(\Illuminate\Support\Str::limit($schedule->date ?? ($schedule['date'] ?? ''), 10)); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="<?php echo e(route('reception.schedule.edit', $schedule)); ?>" class="inline-flex items-center p-1.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form action="<?php echo e(route('reception.schedule.destroy', $schedule)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="inline-flex items-center p-1.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="px-6 py-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">No events scheduled</p>
                    <p class="text-gray-400 mt-1">Add new events to get started</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Pending Tasks Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Pending Tasks</h3>
                    <p class="text-sm text-gray-600 mt-1">Tasks that require your attention</p>
                </div>
                <div class="flex space-x-2">
                    <button type="button" class="task-filter-button px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200" data-filter="all">All Tasks</button>
                    <button type="button" class="task-filter-button px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200" data-filter="urgent">Urgent</button>
                    <button type="button" class="task-filter-button px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200" data-filter="today">Today</button>
                    <button type="button" class="task-filter-button px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200" data-filter="normal">Normal</button>
                </div>
            </div>
        </div>
        
        <div class="divide-y divide-gray-200">
            <?php $__empty_1 = true; $__currentLoopData = $pendingTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors duration-150" data-task-id="<?php echo e($task->id ?? $task['id'] ?? ''); ?>">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 mt-1">
                            <input type="checkbox" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 h-4 w-4 transition-colors duration-200 task-checkbox"
                                   data-priority="<?php echo e(strtolower($task->priority ?? $task['priority'])); ?>">
                        </div>
                        <div class="flex-grow">
                            <div class="flex items-center space-x-3">
                                <h4 class="text-sm font-medium text-gray-900 task-title"><?php echo e($task->title ?? $task['title']); ?></h4>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    <?php echo e((strtolower($task->priority ?? $task['priority']) == 'urgent') ? 'bg-red-100 text-red-800' : ((strtolower($task->priority ?? $task['priority']) == 'today') ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800')); ?>">
                                    <?php echo e(ucfirst($task->priority ?? $task['priority'])); ?>

                                </span>
                            </div>
                            <?php if(!empty($task->description ?? ($task['description'] ?? null))): ?>
                            <p class="mt-2 text-sm text-gray-600"><?php echo e($task->description ?? ($task['description'] ?? '')); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="<?php echo e(route('reception.task.edit', $task)); ?>" class="inline-flex items-center p-1.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form action="<?php echo e(route('reception.task.destroy', $task)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="inline-flex items-center p-1.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="px-6 py-12 text-center">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-gray-500 text-lg font-medium">No pending tasks</p>
                    <p class="text-gray-400 mt-1">All tasks are completed</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Schedule/Task Modal -->
<div id="add-schedule-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Add New Schedule / Task</h3>
            <div class="mt-2 px-7 py-3">
                <form action="<?php echo e(route('reception.schedule.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="radio" name="type" value="event" class="form-radio" checked>
                                <span class="ml-2">Event</span>
                            </label>
                            <label class="inline-flex items-center ml-6">
                                <input type="radio" name="type" value="task" class="form-radio">
                                <span class="ml-2">Task</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                        <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <div id="event-fields">
                        <div class="mb-4">
                            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                            <input type="date" name="date" id="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label for="time" class="block text-gray-700 text-sm font-bold mb-2">Time</label>
                            <input type="time" name="time" id="time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label for="location" class="block text-gray-700 text-sm font-bold mb-2">Location</label>
                            <input type="text" name="location" id="location" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="mb-4">
                            <label for="event_status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                            <select name="status" id="event_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="scheduled">Scheduled</option>
                                <option value="upcoming">Upcoming</option>
                            </select>
                        </div>
                    </div>

                    <div id="task-fields" class="hidden">
                        <div class="mb-4">
                            <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">Priority</label>
                            <select name="priority" id="priority" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
                                <option value="normal">Normal</option>
                                <option value="urgent">Urgent</option>
                                <option value="today">Today</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="task_status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                             <select name="status" id="task_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    <div class="items-center px-4 py-3">
                        <button id="ok-btn" type="submit" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Add
                        </button>
                    </div>
                </form>
            </div>
            <div class="items-center px-4 py-3">
                <button id="cancel-btn" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .completed-task {
        opacity: 0.6;
        text-decoration: line-through;
    }
    
    .task-checkbox:checked + .task-title {
        text-decoration: line-through;
        color: #9CA3AF;
    }
    
    .fade-out {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    /* Default button styling */
    .filter-button {
        background-color: #E5E7EB; /* gray-200 */
        color: #4B5563; /* gray-700 */
    }

    /* Active button styling - will be applied by JS */
    .filter-button.bg-blue-600 {
        background-color: #2563EB; /* blue-600 */
    }

    .filter-button.text-white {
        color: #FFFFFF;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal handling
        const modal = document.getElementById('add-schedule-modal');
        const openModalBtn = document.getElementById('add-schedule-btn');
        const cancelBtn = document.getElementById('cancel-btn');

        openModalBtn.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        cancelBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target == modal) {
                modal.style.display = 'none';
            }
        });

        // Form fields toggling
        const typeRadios = document.querySelectorAll('input[name="type"]');
        const eventFields = document.getElementById('event-fields');
        const taskFields = document.getElementById('task-fields');
        
        const eventDate = document.getElementById('date');
        const eventTime = document.getElementById('time');
        const eventLocation = document.getElementById('location');
        const eventStatus = document.getElementById('event_status');
        
        const taskPriority = document.getElementById('priority');
        const taskStatus = document.getElementById('task_status');

        typeRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                if (e.target.value === 'event') {
                    eventFields.style.display = 'block';
                    taskFields.style.display = 'none';
                    
                    eventDate.disabled = false;
                    eventTime.disabled = false;
                    eventLocation.disabled = false;
                    eventStatus.disabled = false;

                    taskPriority.disabled = true;
                    taskStatus.disabled = true;

                } else { // type === 'task'
                    eventFields.style.display = 'none';
                    taskFields.style.display = 'block';
                    
                    eventDate.disabled = true;
                    eventTime.disabled = true;
                    eventLocation.disabled = true;
                    eventStatus.disabled = true;

                    taskPriority.disabled = false;
                    taskStatus.disabled = false;
                }
            });
        });
        
        // Event filtering with buttons
        const eventFilterButtons = document.querySelectorAll('.filter-button');
        const eventItems = document.querySelectorAll('.divide-y > div:not([class*="text-center"])'); // Adjusted selector to be more specific if needed

        function filterEvents(filterValue) {
            eventItems.forEach(item => {
                // Ensure we are getting the status badge from the event item, not task item
                const statusBadge = item.querySelector('h4 + span.inline-flex'); // Selects the span right after an h4, which is the event status badge
                if (statusBadge) {
                    const status = statusBadge.textContent.toLowerCase().trim();
                    if (filterValue === 'all' || status.includes(filterValue)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        }

        eventFilterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active state from all buttons
                eventFilterButtons.forEach(btn => btn.classList.remove('bg-blue-600', 'text-white'));
                eventFilterButtons.forEach(btn => btn.classList.add('bg-gray-200', 'text-gray-700'));

                // Add active state to clicked button
                this.classList.add('bg-blue-600', 'text-white');
                this.classList.remove('bg-gray-200', 'text-gray-700');

                const filterValue = this.dataset.filter;
                filterEvents(filterValue);
            });
        });

        // Initialize default filter (All Events)
        // Find the "All Events" button and trigger its click event to set initial state and filter
        const allEventsButton = document.querySelector('.filter-button[data-filter="all"]');
        if (allEventsButton) {
            allEventsButton.click(); // This will also apply the active styling
        }
        
        // Task filtering with buttons
        const taskFilterButtons = document.querySelectorAll('.task-filter-button');
        const taskItems = document.querySelectorAll('[data-task-id]');

        function filterTasks(filterValue) {
            taskItems.forEach(item => {
                const priorityBadge = item.querySelector('h4 + span.inline-flex'); // Assuming similar structure to events with priority
                if (priorityBadge) {
                    const priority = priorityBadge.textContent.toLowerCase().trim();
                    if (filterValue === 'all' || priority === filterValue) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        }

        taskFilterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active state from all task buttons
                taskFilterButtons.forEach(btn => btn.classList.remove('bg-blue-600', 'text-white'));
                taskFilterButtons.forEach(btn => btn.classList.add('bg-gray-200', 'text-gray-700'));

                // Add active state to clicked button
                this.classList.add('bg-blue-600', 'text-white');
                this.classList.remove('bg-gray-200', 'text-gray-700');

                const filterValue = this.dataset.filter;
                filterTasks(filterValue);
            });
        });

        // Initialize default task filter (All Tasks)
        const allTasksButton = document.querySelector('.task-filter-button[data-filter="all"]');
        if (allTasksButton) {
            allTasksButton.click(); // This will also apply the active styling
        }
        
        // Task completion functionality
        const checkboxes = document.querySelectorAll('.task-checkbox');
        
        checkboxes.forEach(checkbox => {
            // Load saved state from localStorage
            const taskId = checkbox.closest('[data-task-id]').getAttribute('data-task-id');
            if (taskId && localStorage.getItem(`task-${taskId}`) === 'completed') {
                checkbox.checked = true;
                const taskItem = checkbox.closest('[data-task-id]');
                taskItem.classList.add('completed-task');
            }
            
            checkbox.addEventListener('change', function() {
                const taskItem = this.closest('[data-task-id]');
                const taskId = taskItem.getAttribute('data-task-id');
                const priority = this.getAttribute('data-priority');
                
                if (this.checked) {
                    // Add completion styling
                    taskItem.classList.add('completed-task');
                    
                    // Save to localStorage if task has ID
                    if (taskId) {
                        localStorage.setItem(`task-${taskId}`, 'completed');
                    }
                    
                    // If it's urgent or today priority, move to bottom after delay
                    if (priority === 'urgent' || priority === 'today') {
                        setTimeout(() => {
                            taskItem.classList.add('fade-out');
                            setTimeout(() => {
                                const container = taskItem.parentElement;
                                container.appendChild(taskItem);
                                taskItem.classList.remove('fade-out');
                            }, 300);
                        }, 500);
                    }
                } else {
                    // Remove completion styling
                    taskItem.classList.remove('completed-task');
                    
                    // Remove from localStorage
                    if (taskId) {
                        localStorage.removeItem(`task-${taskId}`);
                    }
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.reception', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\Projects\innovior info\66\Student Management System\resources\views/reception/schedule/index.blade.php ENDPATH**/ ?>