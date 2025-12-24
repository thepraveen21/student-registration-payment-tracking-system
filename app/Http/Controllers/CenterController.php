<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    public function create()
    {
        $centers = Center::latest()->get();
        return view('centers.create', compact('centers'));
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

    public function destroy($id)
    {
        try {
            $center = Center::findOrFail($id);
            
            // Check if center has students
            if ($center->students()->count() > 0) {
                return redirect()->back()->with('error', 'Cannot delete center. It has ' . $center->students()->count() . ' student(s) assigned to it.');
            }
            
            $centerName = $center->name;
            $center->delete();
            
            return redirect()->back()->with('success', 'Center "' . $centerName . '" deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete center: ' . $e->getMessage());
        }
    }
}
