@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Notifications</h1>
        @if($notifications->where('is_read', false)->count() > 0)
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Mark all as read
                </button>
            </form>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100">
        @forelse($notifications as $notification)
            <div class="p-4 border-b border-slate-100 last:border-0 {{ $notification->is_read ? 'bg-slate-50' : 'bg-white' }}">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $notification->priority === 'high' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-4">
                            <h3 class="font-semibold text-slate-800">{{ $notification->title }}</h3>
                            <span class="text-xs text-slate-400">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-slate-600 mt-1">{{ $notification->message }}</p>
                        @if(!$notification->is_read)
                            <form action="{{ route('notifications.mark-read', $notification) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="text-sm text-blue-600 hover:text-blue-800">Mark as read</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-slate-500">
                <i class="bi bi-bell-slash text-4xl mb-4 block"></i>
                <p>No notifications</p>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection