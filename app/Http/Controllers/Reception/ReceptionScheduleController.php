<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Task;

class ReceptionScheduleController extends Controller
{
    public function store(Request $request)
    {
        $type = $request->input('type');

        if ($type === 'event') {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'date' => 'required|date',
                'time' => 'required|string',
                'location' => 'nullable|string|max:255',
                'status' => 'required|string|in:scheduled,upcoming',
            ]);
            Schedule::create($validatedData);
        } elseif ($type === 'task') {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'priority' => 'required|string|in:normal,urgent,today',
                'status' => 'required|string|in:pending,completed',
            ]);
            Task::create($validatedData);
        } else {
            return redirect()->back()->with('error', 'Invalid type selected.');
        }

        return redirect()->route('reception.schedule.index')->with('success', ucfirst($type) . ' added successfully.');
    }

    public function edit(Schedule $schedule)
    {
        return view('reception.schedule.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|string|in:scheduled,upcoming',
        ]);

        $schedule->update($validatedData);

        return redirect()->route('reception.schedule.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('reception.schedule.index')->with('success', 'Event deleted successfully.');
    }

    public function editTask(Task $task)
    {
        return view('reception.schedule.edit_task', compact('task'));
    }

    public function updateTask(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'priority' => 'required|string|in:normal,urgent,today',
            'status' => 'required|string|in:pending,completed',
        ]);

        $task->update($validatedData);

        return redirect()->route('reception.schedule.index')->with('success', 'Task updated successfully.');
    }

    public function destroyTask(Task $task)
    {
        $task->delete();
        return redirect()->route('reception.schedule.index')->with('success', 'Task deleted successfully.');
    }
}
