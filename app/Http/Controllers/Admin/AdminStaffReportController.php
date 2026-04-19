<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffReport;
use Illuminate\Http\Request;

class AdminStaffReportController extends Controller
{
    public function index()
    {
        $reports = StaffReport::with(['room', 'staff'])
            ->latest()
            ->get();

        return view('admin.staff-reports.index', compact('reports'));
    }

    public function update(Request $request, StaffReport $staffReport)
    {
        $request->validate([
            'status' => 'required|in:pending,resolved',
        ]);

        $staffReport->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.staff-reports.index')
            ->with('success', 'Report status updated!');
    }
}

