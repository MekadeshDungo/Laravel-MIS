@extends('layouts.admin')

@section('title', 'Owner Details')

@section('header', 'Owner Details')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-staff.owners.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-bold text-gray-800">{{ $petOwner ? $petOwner->first_name . ' ' . $petOwner->last_name : $owner->name }}</h1>
            <p class="text-gray-500 mt-1">{{ $owner->email }}</p>
        </div>
        <a href="{{ route('admin-staff.pets.create') }}?owner_id={{ $owner->id }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="bi bi-plus-lg mr-2"></i> Add Pet
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Owner Information</h3>
                </div>
                <div class="p-6 space-y-3">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Name</p>
                        <p class="font-medium text-gray-800">{{ $petOwner ? $petOwner->first_name . ' ' . $petOwner->last_name : $owner->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Email</p>
                        <p class="font-medium text-gray-800">{{ $petOwner->email ?? $owner->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Contact</p>
                        <p class="font-medium text-gray-800">{{ $petOwner->phone_number ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Address</p>
                        <p class="font-medium text-gray-800">{{ $petOwner ? $petOwner->blk_lot_ph . ' ' . $petOwner->street . ', ' . $petOwner->barangay : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Registered</p>
                        <p class="font-medium text-gray-800">{{ $owner->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">Pets ({{ $petOwner ? $petOwner->pets->count() : 0 }})</h3>
                    <a href="{{ route('admin-staff.pets.create') }}?owner_id={{ $owner->id }}" class="text-sm text-blue-600 hover:text-blue-800">
                        <i class="bi bi-plus-lg mr-1"></i> Add Pet
                    </a>
                </div>
                <div class="overflow-x-auto">
                    @if($petOwner && $petOwner->pets->count() > 0)
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pet Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Species</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Breed</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Vaccination</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($petOwner->pets as $pet)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-800">{{ $pet->pet_name }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ ucfirst($pet->species) }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $pet->breed ?? '-' }}</td>
                                        <td class="px-6 py-4">
                                            @switch($pet->vaccination_status)
                                                @case('vaccinated')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Vaccinated</span>
                                                    @break
                                                @case('unvaccinated')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Unvaccinated</span>
                                                    @break
                                                @case('pending')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('admin-staff.pets.show', $pet) }}" class="p-2 text-info hover:bg-info hover:bg-opacity-10 rounded-lg transition" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin-staff.pets.edit', $pet) }}" class="p-2 text-warning hover:bg-warning hover:bg-opacity-10 rounded-lg transition" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-12">
                            <i class="bi bi-heart-pulse text-5xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 mb-4">No pets registered for this owner.</p>
                            <a href="{{ route('admin-staff.pets.create') }}?owner_id={{ $owner->id }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                <i class="bi bi-plus-lg"></i>
                                Register First Pet
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
