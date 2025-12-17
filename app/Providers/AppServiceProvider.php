<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use App\Models\Student;
use App\Observers\StudentObserver;
use Illuminate\Support\Facades\View;
use App\Models\AdminNotification;
use App\Models\User as AppUser;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
        Student::observe(StudentObserver::class);
        // Compose admin layout with pending admin notifications and ensure per-admin rows exist
        View::composer('layouts.admin', function ($view) {
            if (! auth()->check()) {
                $view->with('pendingAdminNotifications', collect());
                $view->with('pendingAdminCount', 0);
                return;
            }

            $adminId = auth()->id();

            // Create per-admin AdminNotification rows for currently pending users (unapproved and not rejected)
            $unapprovedUsers = AppUser::where('approved', false)->where('status', '!=', false)->get();
            foreach ($unapprovedUsers as $u) {
                AdminNotification::firstOrCreate([
                    'admin_id' => $adminId,
                    'target_user_id' => $u->id,
                    'type' => 'user_approval_requested',
                ], [
                    'actor_id' => $u->created_by,
                    'data' => [
                        'user_id' => $u->id,
                        'user_name' => $u->name,
                        'role' => $u->role,
                        'creator_id' => $u->created_by,
                        'creator_name' => $u->creator?->name,
                        'message' => 'New account created and awaiting approval',
                    ],
                ]);
            }

            $pending = AdminNotification::where('admin_id', $adminId)->whereNull('read_at')->latest()->get();
            $view->with('pendingAdminNotifications', $pending);
            $view->with('pendingAdminCount', $pending->count());
        });
    }
}
