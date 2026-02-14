@extends('layouts.admin')

@section('title', 'Dashboard - Barangay')

@section('header', 'Barangay Dashboard')
@section('subheader', 'Welcome, ' . (Auth::user()->name ?? 'Barangay Encoder'))

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stray Reports -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Stray Reports</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\StrayReport::count() }}</p>
            </div>
            <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-exclamation-diamond text-yellow-600 text-2xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('barangay.reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All →</a>
        </div>
    </div>

    <!-- Impound Records -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Impound Records</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\ImpoundRecord::count() }}</p>
            </div>
            <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-box-seam text-red-600 text-2xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('barangay.impounds.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All →</a>
        </div>
    </div>

    <!-- Adoptions -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Adoptions</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\AdoptionRequest::count() }}</p>
            </div>
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-heart text-green-600 text-2xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('barangay.adoptions.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All →</a>
        </div>
    </div>

    <!-- Notifications -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Notifications</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ \App\Models\Notification::count() }}</p>
            </div>
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="bi bi-bell text-blue-600 text-2xl"></i>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('barangay.notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All →</a>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('barangay.reports.create') }}" class="flex flex-col items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-yellow-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-exclamation-circle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Report Stray</span>
        </a>

        <a href="{{ route('barangay.data-entry') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-pencil-square text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Data Entry</span>
        </a>

        <a href="{{ route('barangay.impounds.index') }}" class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-box-seam text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Impounds</span>
        </a>

        <a href="{{ route('barangay.adoptions.index') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-heart text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Adoptions</span>
        </a>
    </div>
</div>

<!-- Recent Stray Reports -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800">Recent Stray Reports</h3>
        <a href="{{ route('barangay.reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800 flex items-center gap-1">
            View All <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\App\Models\StrayReport::latest()->take(5)->get() as $report)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-blue-600">#{{ $report->id }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $report->location }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 capitalize">{{ $report->animal_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $report->report_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @switch($report->status)
                                @case('pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                    @break
                                @case('resolved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Resolved</span>
                                    @break
                                @case('in_progress')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">In Progress</span>
                                    @break
                            @endswitch
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <i class="bi bi-inbox text-4xl mb-2 block"></i>
                            No stray reports yet
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
