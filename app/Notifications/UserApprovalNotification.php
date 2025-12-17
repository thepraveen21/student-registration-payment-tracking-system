<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class UserApprovalNotification extends Notification
{
    use Queueable;

    public $newUser;
    public $creator;

    public function __construct(User $newUser, ?User $creator = null)
    {
        $this->newUser = $newUser;
        $this->creator = $creator;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->newUser->id,
            'user_name' => $this->newUser->name,
            'role' => $this->newUser->role,
            'creator_id' => $this->creator?->id,
            'creator_name' => $this->creator?->name,
            'message' => 'New account created and awaiting approval',
        ];
    }
}
