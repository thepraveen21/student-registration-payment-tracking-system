<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class UserApprovalController extends Controller
{
    public function approve(User $user)
    {
        $user->approved = true;
        $user->status = true;
        $user->save();


        // notify creator (if any) about approval via admin_notifications
        if ($user->created_by) {
            AdminNotification::create([
                'admin_id' => $user->created_by,
                'actor_id' => auth()->id(),
                'target_user_id' => $user->id,
                'type' => 'user_approved',
                'data' => [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'approved_by' => auth()->user()?->name,
                ],
            ]);
        }

        // Mark all admin_notifications for this target user as read (processed globally)
        AdminNotification::where('target_user_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('status', 'User approved successfully.');
    }

    public function reject(User $user)
    {
        // Set user as rejected globally so they cannot log in
        $user->approved = false;
        $user->status = false; // mark inactive/rejected
        $user->save();

        // Optionally notify the creator (not implemented here)

        // Mark all admin_notifications for this target user as read (remove from all admins' pending lists)
        AdminNotification::where('target_user_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('status', 'User rejected successfully.');
    }
}
