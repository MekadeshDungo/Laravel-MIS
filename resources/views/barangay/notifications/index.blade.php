@extends('layouts.admin')

@section('title', 'Notifications')

@section('breadcrumb')
    <li class="breadcrumb-item active">Notifications</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-bell-fill me-2"></i>Notifications
        </h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @forelse($notifications as $notification)
            <div class="border-bottom pb-3 mb-3 {{ $notification->is_read ? '' : 'bg-light p-2 rounded' }}">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <strong>{{ $notification->title }}</strong>
                            @if(!$notification->is_read)
                            <span class="badge bg-danger">New</span>
                            @endif
                            <span class="badge {{ $notification->getModuleBadgeColor() }}">
                                {{ str_replace('_', ' ', $notification->related_module) }}
                            </span>
                        </div>
                        <p class="mb-1">{{ $notification->message }}</p>
                        <small class="text-muted">
                            <i class="bi bi-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                        </small>
                    </div>
                    @if(!$notification->is_read)
                    <form action="{{ route('barangay.notifications.mark-read', $notification) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-check-lg"></i> Mark Read
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center text-muted py-5">
                <i class="bi bi-bell-slash fs-1"></i>
                <p class="mt-2">No notifications found</p>
            </div>
            @endforelse
            
            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
