<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index(Request $request)
    {
        $query = Notification::with('student')->latest();
        
        // Filter by type if provided
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $notifications = $query->paginate(15);
        
        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Send bulk overdue payment notifications.
     */
    public function sendOverdueNotifications()
    {
        try {
            Artisan::call('payments:detect-overdue', ['--send-notifications' => true]);
            $output = Artisan::output();
            
            return redirect()->route('admin.notifications.index')
                ->with('success', 'Overdue payment notifications sent successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.notifications.index')
                ->with('error', 'Failed to send notifications: ' . $e->getMessage());
        }
    }

    /**
     * Create a manual notification.
     */
    public function create()
    {
        $students = Student::all();
        return view('admin.notifications.create', compact('students'));
    }

    /**
     * Store a manual notification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string|in:overdue_payment,general',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Notification::create([
            'student_id' => $request->student_id,
            'type' => $request->type,
            'message' => $request->title . ': ' . $request->message,
            'delivery_method' => 'email', // Default to email
            'status' => 'sent',
            'sent_at' => now(),
        ]);

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification created successfully.');
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Mark notification as sent.
     */
    public function markAsSent(Notification $notification)
    {
        $notification->update(['status' => 'sent']);
        
        return redirect()->back()->with('success', 'Notification marked as sent.');
    }

    /**
     * Retry failed notifications.
     */
    public function retryFailed()
    {
        Notification::where('status', 'failed')->update(['status' => 'pending']);
        
        return redirect()->back()->with('success', 'Failed notifications queued for retry.');
    }

    /**
     * Delete notification.
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        
        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }

    /**
     * Get overdue payments preview (for dashboard/reports).
     */
    public function overduePreview()
    {
        Artisan::call('payments:detect-overdue');
        $output = Artisan::output();
        
        return response()->json(['output' => $output]);
    }
}
