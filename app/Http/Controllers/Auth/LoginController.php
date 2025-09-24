<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return route('dashboard');
        } elseif ($user->role === 'receptionist') {
            return route('Reception');
        }
        return '/';
    }
}
