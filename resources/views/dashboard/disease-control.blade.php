@extends('layouts.admin')

@section('title', 'Disease Control Dashboard')

@section('header', 'Disease Control')
@section('subheader', 'Disease monitoring and reporting')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-red-600 to-pink-700 rounded-xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">Disease Control Portal</h2>
            <p class="text-red-100">Monitoring and managing animal disease control.</p>
        </div>
        <div class="hidden md:block">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                <i class="bi bi-bug text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Total Cases</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\AnimalBiteReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-red-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Rabies Cases</p>
                <p class="text-2xl font-bold text-red-600">{{ \App\Models\AnimalBiteReport::where('animal_status', 'rabid')->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-bug text-red-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Suspect Cases</p>
                <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\AnimalBiteReport::where('animal_status', 'suspect')->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-exclamation-circle text-yellow-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">This Month</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\AnimalBiteReport::whereMonth('incident_date', now()->month)->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-calendar-check text-blue-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('disease-control.rabies-cases.index') }}" class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-bug text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Rabies Cases</span>
        </a>

        <a href="{{ route('disease-control.animal-bite-reports.index') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-list text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Bite Reports</span>
        </a>
    </div>
</div>

<!-- Case Status Summary -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Bite Report Status</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-clock text-yellow-600"></i>
                    <span class="text-sm text-gray-700">Pending</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\AnimalBiteReport::where('status', 'pending')->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-arrow-repeat text-blue-600"></i>
                    <span class="text-sm text-gray-700">Ongoing</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\AnimalBiteReport::where('status', 'investigating')->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle text-green-600"></i>
                    <span class="text-sm text-gray-700">Completed</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\AnimalBiteReport::where('status', 'resolved')->count() }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Animal Status</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle text-green-600"></i>
                    <span class="text-sm text-gray-700">Healthy</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\AnimalBiteReport::where('animal_status', 'healthy')->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-circle text-yellow-600"></i>
                    <span class="text-sm text-gray-700">Suspect</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\AnimalBiteReport::where('animal_status', 'suspect')->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-bug text-red-600"></i>
                    <span class="text-sm text-gray-700">Rabid</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\AnimalBiteReport::where('animal_status', 'rabid')->count() }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bite Reports -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-6">
    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-semibold text-gray-800">Recent Bite Reports</h3>
        <a href="{{ route('disease-control.animal-bite-reports.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Case No.</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Victim</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Animal</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\App\Models\AnimalBiteReport::latest()->take(5)->get() as $report)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-blue-600">#{{ $report->case_number }}</span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-700">{{ $report->victim_name }}</td>
                        <td class="px-5 py-4 text-sm text-gray-500 capitalize">{{ $report->animal_type }}</td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full capitalize
                                @switch($report->status)
                                    @case('pending') bg-yellow-100 text-yellow-700 @break
                                    @case('ongoing') bg-blue-100 text-blue-700 @break
                                    @case('completed') bg-green-100 text-green-700 @break
                                @endswitch">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $report->incident_date->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-gray-500">
                            <i class="bi bi-inbox text-3xl mb-2 block"></i>
                            <p>No bite reports yet</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
