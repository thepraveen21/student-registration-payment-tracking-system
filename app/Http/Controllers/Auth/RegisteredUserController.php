<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AdminNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,receptionist'], // match table default
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => 1, // default active
            'approved' => false,
            'created_by' => Auth::id(),
        ]);

        event(new Registered($user));
        // Notify admins (create admin_notifications entries)
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            AdminNotification::create([
                'admin_id' => $admin->id,
                'actor_id' => Auth::id(),
                'target_user_id' => $user->id,
                'type' => 'user_approval_requested',
                'data' => [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'role' => $user->role,
                    'creator_id' => Auth::id(),
                    'creator_name' => Auth::user()?->name,
                    'message' => 'New account created and awaiting approval',
                ],
            ]);
        }

        // Do not auto-login. Inform user their account is pending approval.
        return redirect()->route('login')->with('status', 'Account created and pending admin approval.');
    }
}
