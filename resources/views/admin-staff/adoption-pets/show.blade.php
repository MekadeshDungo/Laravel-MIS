@extends('layouts.admin')

@section('title', 'Adoption Pet Details')

@section('header', 'Adoption Pet Details')
@section('subheader', 'View pet information')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-staff.adoption-pets.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $adoptionPet->pet_name }}</h1>
            <p class="text-gray-500 mt-1">Pet details for adoption</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="h-64 bg-gray-200">
                    @if($adoptionPet->image)
                        <img src="{{ asset('storage/' . $adoptionPet->image) }}" alt="{{ $adoptionPet->pet_name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="bi bi-image text-gray-400 text-5xl"></i>
                        </div>
                    @endif
                </div>
                <div class="p-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin-staff.adoption-pets.edit', $adoptionPet) }}" class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            <i class="bi bi-pencil mr-1"></i>Edit
                        </a>
                        <form action="{{ route('admin-staff.adoption-pets.destroy', $adoptionPet) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition" onclick="return confirm('Are you sure you want to delete this pet?')">
                                <i class="bi bi-trash mr-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Pet Information</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium text-gray-800">{{ $adoptionPet->pet_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Species</p>
                        <p class="font-medium text-gray-800">{{ $adoptionPet->species }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Breed</p>
                        <p class="font-medium text-gray-800">{{ $adoptionPet->breed ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Gender</p>
                        <p class="font-medium text-gray-800">{{ ucfirst($adoptionPet->gender) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Age</p>
                        <p class="font-medium text-gray-800">{{ $adoptionPet->age ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Weight</p>
                        <p class="font-medium text-gray-800">{{ $adoptionPet->weight ?? 'N/A' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Date of Birth</p>
                        <p class="font-medium text-gray-800">{{ $adoptionPet->date_of_birth ? $adoptionPet->date_of_birth->format('M d, Y') : 'Not specified' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Description</p>
                        <p class="font-medium text-gray-800">{{ $adoptionPet->description ?? 'No description' }}</p>
                    </div>
                </div>

                @if($adoptionPet->traits->count() > 0)
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Traits</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($adoptionPet->traits as $trait)
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">{{ $trait->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-6 pt-6 border-t border-gray-100">
                    <p class="text-sm text-gray-500">Added on {{ $adoptionPet->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection