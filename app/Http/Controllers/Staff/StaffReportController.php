<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\StaffReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffReportController extends Controller
{
    public function index()
    {
        $staffId = Auth::user()->staff_id;

        $reports = StaffReport::with(['room'])
            ->where('staff_id', $staffId)
            ->latest()
            ->get();

        return view('staff.reports.index', compact('reports'));
    }

    public function create()
    {
        $rooms = Room::latest()->get();

        return view('staff.reports.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $staffId = Auth::user()->staff_id;

        $request->validate([
            'room_id' => 'nullable|exists:rooms,id',
            'report_type' => 'required|in:damage,discovery,other',
            'description' => 'required|string|max:2000',
        ]);

        StaffReport::create([
            'staff_id' => $staffId,
            'room_id' => $request->room_id,
            'report_type' => $request->report_type,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return redirect()->route('staff.reports.index')
            ->with('success', 'Report submitted successfully!');
    }
}

