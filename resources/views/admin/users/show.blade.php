@extends('layouts.admin')

@section('title', 'View User')

@section('header', 'User Details')
@section('subheader', 'View user information')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Users</span>
        </a>
    </div>

    <!-- User Details Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">User Information</h3>
        </div>

        <div class="p-6">
            <div class="flex items-center gap-6 mb-6">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-600 font-bold text-2xl">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h4>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-2 capitalize">
                        {{ str_replace('_', ' ', $user->role) }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Role</p>
                    <p class="font-medium text-gray-800 capitalize">{{ str_replace('_', ' ', $user->role) }}</p>
                </div>

                @if($user->secondary_role)
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Secondary Role</p>
                    <p class="font-medium text-gray-800 capitalize">{{ str_replace('_', ' ', $user->secondary_role) }}</p>
                </div>
                @endif

                @if($user->barangay)
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Barangay</p>
                    <p class="font-medium text-gray-800">{{ $user->barangay }}</p>
                </div>
                @endif

                @if($user->clinic_name)
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Clinic Name</p>
                    <p class="font-medium text-gray-800">{{ $user->clinic_name }}</p>
                </div>
                @endif

                @if($user->contact_number)
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Contact Number</p>
                    <p class="font-medium text-gray-800">{{ $user->contact_number }}</p>
                </div>
                @endif

                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Created At</p>
                    <p class="font-medium text-gray-800">{{ $user->created_at->format('M d, Y h:i A') }}</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-1">Status</p>
                    <p class="font-medium text-gray-800 capitalize">{{ $user->status ?? 'Active' }}</p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-4">
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="bi bi-pencil"></i>
                <span>Edit User</span>
            </a>
        </div>
    </div>
</div>
@endsection
