<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceptionController extends Controller
{
    public function dashboard()
    {
        return view('Reception');
    }

    public function reports()
    {
        return view('reception.reports');
    }

    public function settings()
    {
        return view('reception.settings');
    }
}
