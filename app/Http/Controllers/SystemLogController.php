<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SystemLogController extends Controller
{
    /**
     * Display a listing of the system logs.
     */
    public function index(Request $request)
    {
        $query = SystemLog::with('user');

        // Filter by module
        if ($request->has('module') && $request->module) {
            $query->where('module', $request->module);
        }

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Search in description
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', "%{$request->search}%")
                  ->orWhere('ip_address', 'like', "%{$request->search}%");
            });
        }

        $logs = $query->orderBy('created_at', 'desc')
                      ->paginate(25)
                      ->appends($request->query());

        // Get filter options
        $modules = SystemLog::distinct()->pluck('module')->sort()->values();
        $actions = SystemLog::distinct()->pluck('action')->sort()->values();
        $users = \App\Models\User::orderBy('name')->pluck('name', 'id');

        return view('admin.system-logs.index', compact('logs', 'modules', 'actions', 'users'));
    }

    /**
     * Show a single log entry.
     */
    public function show($id)
    {
        $log = SystemLog::with('user')->findOrFail($id);
        return view('admin.system-logs.show', compact('log'));
    }

    /**
     * Export logs to CSV.
     */
    public function export(Request $request)
    {
        $query = SystemLog::with('user');

        // Apply same filters as index
        if ($request->has('module') && $request->module) {
            $query->where('module', $request->module);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        $csv = collect([
            ['ID', 'User', 'Role', 'Action', 'Module', 'Record ID', 'Description', 'IP Address', 'Status', 'Created At'],
        ]);

        $logs->each(function ($log) use (&$csv) {
            $csv->push([
                $log->log_id,
                $log->user ? $log->user->name : 'N/A',
                $log->role ?? 'N/A',
                $log->action,
                $log->module,
                $log->record_id ?? 'N/A',
                $log->description ?? 'N/A',
                $log->ip_address ?? 'N/A',
                $log->status,
                $log->created_at->format('Y-m-d H:i:s'),
            ]);
        });

        $filename = 'system_logs_' . now()->format('Y-m-d_His') . '.csv';

        return response($csv->map(fn($row) => implode(',', $row))->implode("\n"))
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    /**
     * Clear old logs (retention policy).
     */
    public function clearOld(Request $request)
    {
        $days = $request->get('days', 90); // Default 90 days

        $count = SystemLog::whereDate('created_at', '<', now()->subDays($days))->delete();

        return redirect()->back()->with('success', "Deleted {$count} old log entries.");
    }

    /**
     * Record a new log entry.
     */
    public static function record($action, $module, $recordId = null, $description = null, $status = 'success')
    {
        if (!Auth::check()) {
            return null;
        }

        $user = Auth::user();

        return SystemLog::create([
            'user_id' => $user->id,
            'role' => $user->role,
            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'description' => $description,
            'ip_address' => request()->ip(),
            'status' => $status,
        ]);
    }
}
