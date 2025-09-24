<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Simple stub for reports page.
     */
    public function index(Request $request)
    {
        // If you have a blade view for reports, return it:
        if (view()->exists('reports.index')) {
            return view('reports.index');
        }

        // Temporary fallback so route:list and access do not fail.
        return response('Reports index (view not created yet).', 200);
    }
}
