<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function create()
    {
        return view('centers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:centers,name',
            'location' => 'nullable|string|max:255',
        ]);

        Center::create([
            'name'     => $request->name,
            'location' => $request->location,
        ]);

        return redirect()->back()->with('success', 'Center added successfully!');
    }
}
