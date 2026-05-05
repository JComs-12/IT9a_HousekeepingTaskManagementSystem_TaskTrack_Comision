<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->get();
        return view('admin.logs.index', compact('logs'));
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (!empty($ids)) {
            ActivityLog::whereIn('id', $ids)->delete();
        }

        return redirect()->route('admin.logs.index')
            ->with('success', 'Selected logs deleted successfully!');
    }
}
