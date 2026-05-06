<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffReport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminStaffReportController extends Controller
{
    public function index()
    {
        // Mark NewReportFiled notifications as read
        \Illuminate\Support\Facades\Auth::user()->unreadNotifications->where('type', 'App\Notifications\NewReportFiled')->markAsRead();

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

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (!empty($ids)) {
            StaffReport::whereIn('id', $ids)->delete();
        }

        return redirect()->route('admin.staff-reports.index')
            ->with('success', 'Selected reports deleted successfully!');
    }

    public function destroy(StaffReport $staffReport)
    {
        $description = Str::limit($staffReport->description, 50);
        $staffReport->delete();

        return redirect()->route('admin.staff-reports.index')
            ->with('success', "Staff report deleted successfully!");
    }
}

