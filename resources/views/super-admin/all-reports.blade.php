@extends('layouts.admin')

@section('title', 'All Reports - Super Admin')

@section('header', 'All Reports')
@section('subheader', 'System-wide reporting and analytics')

@section('content')
<!-- Stats Overview -->
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
    @php
        $stats = [
            ['label' => 'Users', 'count' => \App\Models\User::count(), 'icon' => 'bi-people', 'color' => 'blue'],
            ['label' => 'Announcements', 'count' => \App\Models\Announcement::count(), 'icon' => 'bi-megaphone', 'color' => 'purple'],
            ['label' => 'Bite Reports', 'count' => \App\Models\AnimalBiteReport::count(), 'icon' => 'bi-exclamation-triangle', 'color' => 'red'],
            ['label' => 'Vaccinations', 'count' => \App\Models\RabiesVaccinationReport::count(), 'icon' => 'bi-eyedropper', 'color' => 'green'],
            ['label' => 'Meat Inspections', 'count' => \App\Models\MeatInspectionReport::count(), 'icon' => 'bi-clipboard-check', 'color' => 'yellow'],
            ['label' => 'Stray Reports', 'count' => \App\Models\StrayReport::count(), 'icon' => 'bi-currency-dollar', 'color' => 'gray'],
        ];
    @endphp

    @foreach($stats as $stat)
        @php
            $colors = [
                'blue' => 'bg-blue-100 text-blue-600',
                'purple' => 'bg-purple-100 text-purple-600',
                'red' => 'bg-red-100 text-red-600',
                'green' => 'bg-green-100 text-green-600',
                'yellow' => 'bg-yellow-100 text-yellow-600',
                'gray' => 'bg-gray-100 text-gray-600',
            ];
        @endphp
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xl {{ $colors[$stat['color']] }}"><i class="bi {{ $stat['icon'] }}"></i></span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ $stat['count'] }}</p>
            <p class="text-xs text-gray-500">{{ $stat['label'] }}</p>
        </div>
    @endforeach
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
        <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-person-plus text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Add User</span>
        </a>

        <a href="{{ route('super-admin.announcements.create') }}" class="flex flex-col items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-purple-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-megaphone text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Announcement</span>
        </a>

        <a href="{{ route('admin.bite-reports.index') }}" class="flex flex-col items-center p-4 bg-red-50 hover:bg-red-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-exclamation-triangle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Bite Reports</span>
        </a>

        <a href="{{ route('admin.vaccination-reports.index') }}" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-eyedropper text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Vaccinations</span>
        </a>

        <a href="{{ route('admin.meat-inspection-reports.index') }}" class="flex flex-col items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-yellow-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-clipboard-check text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Meat Inspect</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-gray-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-gear text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Settings</span>
        </a>
    </div>
</div>

<!-- Reports Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Animal Bite Reports Summary -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-red-50 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Animal Bite Reports</h3>
            <span class="text-sm text-red-600 font-medium">{{ \App\Models\AnimalBiteReport::count() }} Total</span>
        </div>
        <div class="p-5">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Pending</span>
                    <span class="text-sm font-medium text-yellow-600">{{ \App\Models\AnimalBiteReport::where('status', 'pending')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Ongoing</span>
                    <span class="text-sm font-medium text-blue-600">{{ \App\Models\AnimalBiteReport::where('status', 'investigating')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Completed</span>
                    <span class="text-sm font-medium text-green-600">{{ \App\Models\AnimalBiteReport::where('status', 'resolved')->count() }}</span>
                </div>
            </div>
            <a href="{{ route('admin.bite-reports.index') }}" class="block mt-4 text-center text-sm text-blue-600 hover:text-blue-800 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                View All Reports
            </a>
        </div>
    </div>

    <!-- Rabies Vaccinations Summary -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-green-50 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Rabies Vaccinations</h3>
            <span class="text-sm text-green-600 font-medium">{{ \App\Models\RabiesVaccinationReport::count() }} Total</span>
        </div>
        <div class="p-5">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Dogs</span>
                    <span class="text-sm font-medium text-gray-800">{{ \App\Models\RabiesVaccinationReport::where('pet_species', 'dog')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Cats</span>
                    <span class="text-sm font-medium text-gray-800">{{ \App\Models\RabiesVaccinationReport::where('pet_species', 'cat')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Other</span>
                    <span class="text-sm font-medium text-gray-800">{{ \App\Models\RabiesVaccinationReport::where('pet_species', 'other')->count() }}</span>
                </div>
            </div>
            <a href="{{ route('admin.vaccination-reports.index') }}" class="block mt-4 text-center text-sm text-blue-600 hover:text-blue-800 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                View All Records
            </a>
        </div>
    </div>

    <!-- Meat Inspection Summary -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-yellow-50 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Meat Inspections</h3>
            <span class="text-sm text-yellow-600 font-medium">{{ \App\Models\MeatInspectionReport::count() }} Total</span>
        </div>
        <div class="p-5">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Passed</span>
                    <span class="text-sm font-medium text-green-600">{{ \App\Models\MeatInspectionReport::where('compliance_status', 'compliant')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Condemned</span>
                    <span class="text-sm font-medium text-red-600">{{ \App\Models\MeatInspectionReport::where('compliance_status', 'non_compliant')->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Pending</span>
                    <span class="text-sm font-medium text-yellow-600">{{ \App\Models\MeatInspectionReport::where('compliance_status', 'pending')->count() }}</span>
                </div>
            </div>
            <a href="{{ route('admin.meat-inspection-reports.index') }}" class="block mt-4 text-center text-sm text-blue-600 hover:text-blue-800 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                View All Records
            </a>
        </div>
    </div>
</div>

<!-- User Distribution -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">User Distribution by Role</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach(['super_admin', 'admin', 'city_vet', 'records_staff', 'viewer'] as $role)
            <div class="text-center p-4 bg-gray-50 rounded-xl">
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\User::where('role', $role)->count() }}</p>
                <p class="text-xs text-gray-500 capitalize">{{ str_replace('_', ' ', $role) }}</p>
            </div>
        @endforeach
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h3 class="font-semibold text-gray-800">Recent System Activity</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Activity</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse(\App\Models\AnimalBiteReport::latest()->take(5)->get() as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm text-gray-700">Bite Report #{{ $item->case_number }}</td>
                        <td class="px-5 py-4 text-sm text-gray-600">{{ $item->victim_name }}</td>
                        <td class="px-5 py-4 text-sm"><span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Report</span></td>
                        <td class="px-5 py-4 text-sm text-gray-500">{{ $item->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-gray-500">
                            <i class="bi bi-inbox text-3xl mb-2 block"></i>
                            <p>No recent activity</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
