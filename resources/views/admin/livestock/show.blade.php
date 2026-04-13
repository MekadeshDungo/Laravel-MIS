@extends('layouts.admin')

@section('title', 'Livestock Record Details')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Livestock Record Details</h1>
        <div class="flex gap-2">
            <a href="{{ route('livestock.edit', $livestock->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <a href="{{ route('livestock.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Owner Name -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Owner Name</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $livestock->owner_name }}</p>
                </div>

                <!-- Farm Name -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Farm Name</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $livestock->farm_name ?? '-' }}</p>
                </div>

                <!-- Animal Type -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Animal Type</h3>
                    <p class="mt-1">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            {{ ucfirst($livestock->animal_type) }}
                        </span>
                    </p>
                </div>

                <!-- Quantity -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Quantity</h3>
                    <p class="mt-1 text-2xl font-bold text-green-700">{{ $livestock->quantity }}</p>
                </div>

                <!-- Barangay -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Barangay</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $livestock->barangay->barangay_name ?? '-' }}</p>
                </div>

                <!-- Recorded By -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Recorded By</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $livestock->recorder->name ?? '-' }}</p>
                </div>

                <!-- Created At -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Created At</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $livestock->created_at->format('M d, Y H:i') }}</p>
                </div>

                <!-- Updated At -->
                <div class="border-b border-gray-200 pb-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Last Updated</h3>
                    <p class="mt-1 text-lg text-gray-900">{{ $livestock->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>

            <!-- Delete Button -->
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <form action="{{ route('livestock.destroy', $livestock->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Record
                    </button>
                </form>
                <a href="{{ route('livestock.census') }}" class="text-emerald-600 hover:text-emerald-800 flex items-center gap-2">
                    View Census Summary
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
