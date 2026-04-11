@extends('layouts.admin')

@section('title', 'Adoption Pets')

@section('header', 'Adoption Pets')
@section('subheader', 'Manage pets available for adoption')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Adoption Pets</h1>
            <p class="text-gray-500 mt-1">Manage pets available for adoption</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin-staff.adoption-pets.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i class="bi bi-plus-lg"></i>
                Add Pet for Adoption
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Pets</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $adoptionPets->total() }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-paw text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-4 border-b border-gray-100">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" placeholder="Search by name or breed..." 
                        value="{{ request('search') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="w-40">
                    <select name="species" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Species</option>
                        <option value="Dog" {{ request('species') == 'Dog' ? 'selected' : '' }}>Dog</option>
                        <option value="Cat" {{ request('species') == 'Cat' ? 'selected' : '' }}>Cat</option>
                    </select>
                </div>
                <div class="w-40">
                    <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Genders</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    Filter
                </button>
                <a href="{{ route('admin-staff.adoption-pets.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Clear
                </a>
            </form>
        </div>
    </div>

    @if($adoptionPets->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($adoptionPets as $pet)
                <div class="bg-white rounded-xl shadow-sm border overflow-hidden hover:shadow-lg transition">
                    <div class="relative h-48 bg-gray-200">
                        @if($pet->image)
                            <img src="{{ asset('storage/' . $pet->image) }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="bi bi-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 bg-green-600 text-white px-2 py-1 rounded-full text-xs font-medium">
                            {{ $pet->species }}
                        </div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800">{{ $pet->pet_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $pet->breed ?? 'Unknown Breed' }} - {{ ucfirst($pet->gender) }}</p>
                        @if($pet->age)
                            <p class="text-sm text-gray-600 mt-2">{{ $pet->age }} years old</p>
                        @endif
                        @if($pet->traits->count() > 0)
                            <div class="flex flex-wrap gap-1 mt-2">
                                @foreach($pet->traits as $trait)
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">{{ $trait->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('admin-staff.adoption-pets.show', $pet) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                View
                            </a>
                            <a href="{{ route('admin-staff.adoption-pets.edit', $pet) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin-staff.adoption-pets.destroy', $pet) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm" onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $adoptionPets->withQueryString()->links() }}
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <i class="bi bi-inbox text-gray-400 text-5xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">No Adoption Pets</h3>
            <p class="text-gray-500">There are no pets available for adoption yet.</p>
            <a href="{{ route('admin-staff.adoption-pets.create') }}" class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                Add Pet for Adoption
            </a>
        </div>
    @endif
</div>
@endsection