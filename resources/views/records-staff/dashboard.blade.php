@extends('layouts.admin')

@section('title', 'Records Staff Dashboard')

@section('header', 'Records Staff Dashboard')

@section('subheader', 'Welcome back, ' . (auth()->user()->name ?? 'Records Staff'))

@section('content')
<div class="p-4 md:p-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Pets</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_pets'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-heart-fill text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-info">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pet Owners</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_owners'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-info bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-people text-info text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-success">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Vaccinated</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['vaccinated_pets'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-success bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-check-circle text-success text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-warning">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Unvaccinated</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['unvaccinated_pets'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-warning bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-exclamation-circle text-warning text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-secondary">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Vaccinations</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_vaccinations'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-secondary bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-syringe text-secondary text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-dark">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pending Vaccinations</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['pending_vaccinations'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-dark bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-clock text-dark text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-danger">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Bite Reports</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['bite_reports'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-danger bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-exclamation-triangle text-danger text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-warning">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pending Bite Reports</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $stats['pending_bite_reports'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-warning bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="bi bi-exclamation-circle text-warning text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Pet Registrations -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h5 class="font-semibold text-gray-800">Recent Pet Registrations</h5>
                <a href="{{ route('records-staff.pets.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="p-6">
                @if($recentPets->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs font-semibold text-gray-500 uppercase">
                                    <th class="pb-3">Pet Name</th>
                                    <th class="pb-3">Species</th>
                                    <th class="pb-3">Owner</th>
                                    <th class="pb-3">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($recentPets as $pet)
                                    <tr>
                                        <td class="py-3 font-medium text-gray-800">{{ $pet->name }}</td>
                                        <td class="py-3 text-gray-600">{{ ucfirst($pet->species) }}</td>
                                        <td class="py-3 text-gray-600">{{ $pet->owner->name ?? 'N/A' }}</td>
                                        <td class="py-3 text-gray-500 text-sm">{{ $pet->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="bi bi-heart-pulse text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No pets registered yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Vaccinations -->
        <div class="bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h5 class="font-semibold text-gray-800">Recent Vaccinations</h5>
                <a href="{{ route('records-staff.vaccinations.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
            </div>
            <div class="p-6">
                @if($recentVaccinations->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-xs font-semibold text-gray-500 uppercase">
                                    <th class="pb-3">Patient</th>
                                    <th class="pb-3">Pet Name</th>
                                    <th class="pb-3">Vaccine</th>
                                    <th class="pb-3">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($recentVaccinations as $vaccination)
                                    <tr>
                                        <td class="py-3 font-medium text-gray-800">{{ $vaccination->patient_name }}</td>
                                        <td class="py-3 text-gray-600">{{ $vaccination->pet_name }}</td>
                                        <td class="py-3 text-gray-600">{{ $vaccination->vaccine_brand }}</td>
                                        <td class="py-3 text-gray-500 text-sm">{{ $vaccination->vaccination_date->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="bi bi-shield-check text-4xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500">No vaccination records yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="px-6 py-4 border-b border-gray-100">
            <h5 class="font-semibold text-gray-800">Quick Actions</h5>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('records-staff.pets.create') }}" class="flex items-center gap-3 p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="bi bi-plus-lg text-white"></i>
                    </div>
                    <span class="font-medium text-gray-800">Register New Pet</span>
                </a>
                <a href="{{ route('records-staff.vaccinations.create') }}" class="flex items-center gap-3 p-4 bg-success bg-opacity-10 hover:bg-success hover:bg-opacity-20 rounded-lg transition">
                    <div class="w-10 h-10 bg-success rounded-lg flex items-center justify-center">
                        <i class="bi bi-syringe text-white"></i>
                    </div>
                    <span class="font-medium text-gray-800">Encode Vaccination</span>
                </a>
                <a href="{{ route('records-staff.owners.index') }}" class="flex items-center gap-3 p-4 bg-info bg-opacity-10 hover:bg-info hover:bg-opacity-20 rounded-lg transition">
                    <div class="w-10 h-10 bg-info rounded-lg flex items-center justify-center">
                        <i class="bi bi-people text-white"></i>
                    </div>
                    <span class="font-medium text-gray-800">View Owners</span>
                </a>
                <a href="{{ route('records-staff.search') }}" class="flex items-center gap-3 p-4 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                    <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center">
                        <i class="bi bi-search text-white"></i>
                    </div>
                    <span class="font-medium text-gray-800">Search Records</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
