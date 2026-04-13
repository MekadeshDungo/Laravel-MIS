@extends('layouts.admin')

@section('title', 'Edit Livestock Record')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Edit Livestock Record</h1>
        <a href="{{ route('livestock.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to List
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('livestock.update', $livestock->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Owner Name -->
                <div>
                    <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Owner Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $livestock->owner_name) }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('owner_name') border-red-500 @enderror"
                        required>
                    @error('owner_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Farm Name -->
                <div>
                    <label for="farm_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Farm Name <span class="text-gray-400">(Optional)</span>
                    </label>
                    <input type="text" name="farm_name" id="farm_name" value="{{ old('farm_name', $livestock->farm_name) }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <!-- Animal Type -->
                <div>
                    <label for="animal_type" class="block text-sm font-medium text-gray-700 mb-1">
                        Animal Type <span class="text-red-500">*</span>
                    </label>
                    <select name="animal_type" id="animal_type" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('animal_type') border-red-500 @enderror"
                        required>
                        <option value="">Select Animal Type</option>
                        @foreach($animalTypes as $type)
                            <option value="{{ $type }}" {{ old('animal_type', $livestock->animal_type) == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                    @error('animal_type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $livestock->quantity) }}" min="1"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('quantity') border-red-500 @enderror"
                        required>
                    @error('quantity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Barangay -->
                <div>
                    <label for="barangay_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Barangay <span class="text-red-500">*</span>
                    </label>
                    <select name="barangay_id" id="barangay_id" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('barangay_id') border-red-500 @enderror"
                        required>
                        <option value="">Select Barangay</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id', $livestock->barangay_id) == $barangay->barangay_id ? 'selected' : '' }}>
                                {{ $barangay->barangay_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('barangay_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Record Info -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500">
                    Record created: {{ $livestock->created_at->format('M d, Y H:i') }} | 
                    Last updated: {{ $livestock->updated_at->format('M d, Y H:i') }}
                </p>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('livestock.index') }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Update Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
