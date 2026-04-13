@extends('layouts.admin')

@section('title', 'Log Details')
@section('header', 'System Log Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.system-logs.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
        <i class="bi bi-arrow-left mr-2"></i> Back to Logs
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Details -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-6">Log Entry Details</h3>

            <div class="space-y-6">
                <!-- ID & Status -->
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Log ID</p>
                        <p class="text-lg font-semibold text-gray-800">#{{ $log->log_id }}</p>
                    </div>
                    <div>
                        @if($log->status == 'success')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="bi bi-check-circle mr-1"></i> Success
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="bi bi-x-circle mr-1"></i> Failed
                            </span>
                        @endif
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- User Info -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">User</p>
                        <div class="flex items-center mt-1">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                <i class="bi bi-person text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $log->user->name ?? 'System' }}</p>
                                <p class="text-sm text-gray-500">{{ $log->user->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Role</p>
                        <p class="font-medium text-gray-800 mt-1">{{ $log->role ?? 'N/A' }}</p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Action & Module -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Action</p>
                        <p class="font-medium text-gray-800 mt-1">{{ $log->action }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Module</p>
                        <p class="font-medium text-gray-800 mt-1">{{ $log->module }}</p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Record ID & IP -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Record ID</p>
                        <p class="font-medium text-gray-800 mt-1">{{ $log->record_id ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">IP Address</p>
                        <p class="font-mono text-gray-800 mt-1">{{ $log->ip_address ?? 'N/A' }}</p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Description -->
                <div>
                    <p class="text-sm text-gray-500">Description</p>
                    <p class="text-gray-800 mt-1">{{ $log->description ?? 'No description provided' }}</p>
                </div>

                <hr class="border-gray-100">

                <!-- Timestamps -->
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Created At</p>
                        <p class="font-medium text-gray-800 mt-1">{{ $log->created_at->format('F j, Y \a\t g:i:s A') }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Time Elapsed</p>
                        <p class="font-medium text-gray-800 mt-1">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div>
        <!-- Quick Stats -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h4 class="font-semibold text-gray-800 mb-4">Quick Stats</h4>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Total Logs</span>
                    <span class="font-semibold text-gray-800">{{ \App\Models\SystemLog::count() }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Today's Logs</span>
                    <span class="font-semibold text-gray-800">{{ \App\Models\SystemLog::whereDate('created_at', today())->count() }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500">Failed Actions</span>
                    <span class="font-semibold text-red-600">{{ \App\Models\SystemLog::where('status', 'failed')->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Related Logs -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h4 class="font-semibold text-gray-800 mb-4">Related Activity</h4>
            
            @php
                $relatedLogs = \App\Models\SystemLog::where('user_id', $log->user_id)
                    ->where('log_id', '!=', $log->log_id)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            @endphp
            
            @if($relatedLogs->count() > 0)
                <div class="space-y-3">
                    @foreach($relatedLogs as $related)
                        <a href="{{ route('admin.system-logs.show', $related->log_id) }}" class="block p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <p class="text-sm font-medium text-gray-800">{{ $related->action }}</p>
                            <p class="text-xs text-gray-500">{{ $related->created_at->diffForHumans() }}</p>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500">No related activity found</p>
            @endif
        </div>
    </div>
</div>
@endsection
