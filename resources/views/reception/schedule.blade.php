@extends('layouts.reception')

@section('header', 'Schedule')
@section('title', 'Reception Schedule')

@section('content')
<div class="space-y-6">
    <!-- Today's Schedule -->
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Schedule</h3>
        <div class="space-y-3">
            @forelse($schedules as $schedule)
                <div class="flex items-center justify-between p-3 rounded-lg 
                    {{ $schedule['status'] == 'Upcoming' ? 'bg-blue-50' : ($schedule['status'] == 'Scheduled' ? 'bg-green-50' : 'bg-gray-50') }}">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-8 rounded-full 
                            {{ $schedule['status'] == 'Upcoming' ? 'bg-blue-500' : ($schedule['status'] == 'Scheduled' ? 'bg-green-500' : 'bg-gray-400') }}"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $schedule['title'] }}</p>
                            <p class="text-xs text-gray-600">{{ $schedule['time'] }} - {{ $schedule['location'] }}</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ $schedule['status'] == 'Upcoming' ? 'bg-blue-100 text-blue-800' : ($schedule['status'] == 'Scheduled' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                        {{ $schedule['status'] }}
                    </span>
                </div>
            @empty
                <p class="text-center text-gray-500">No schedules found</p>
            @endforelse
        </div>
    </div>

    <!-- Pending Tasks -->
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Pending Tasks</h3>
        <div class="space-y-3">
            @forelse($pendingTasks as $task)
                <div class="flex items-center justify-between p-3 border rounded-lg 
                    {{ $task['priority'] == 'High' ? 'border-red-200' : ($task['priority'] == 'Medium' ? 'border-yellow-200' : 'border-blue-200') }}">
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $task['task'] }}</p>
                            <p class="text-xs text-gray-600">Due: {{ $task['due'] }}</p>
                        </div>
                    </div>
                    <span class="text-sm 
                        {{ $task['priority'] == 'High' ? 'text-red-600' : ($task['priority'] == 'Medium' ? 'text-yellow-600' : 'text-blue-600') }}">
                        {{ $task['priority'] }}
                    </span>
                </div>
            @empty
                <p class="text-center text-gray-500">No pending tasks</p>
            @endforelse
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const taskItem = this.closest('div.flex.items-center.justify-between');
                if (this.checked) {
                    taskItem.style.opacity = '0.6';
                    taskItem.style.textDecoration = 'line-through';
                } else {
                    taskItem.style.opacity = '1';
                    taskItem.style.textDecoration = 'none';
                }
            });
        });
    });
</script>
@endsection
@endsection
