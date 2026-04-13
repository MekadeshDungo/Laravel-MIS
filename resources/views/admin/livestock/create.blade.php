@extends('layouts.admin')

@section('title', 'Add Livestock Record')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-green-700">Add Livestock Record</h1>
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
        <form action="{{ route('livestock.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Owner Name -->
                <div>
                    <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Owner Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('owner_name') border-red-500 @enderror"
                        required>
                    @error('owner_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Owner Contact -->
                <div>
                    <label for="owner_contact" class="block text-sm font-medium text-gray-700 mb-1">
                        Owner Contact
                    </label>
                    <input type="text" name="owner_contact" id="owner_contact" value="{{ old('owner_contact') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <!-- Species -->
                <div>
                    <label for="species" class="block text-sm font-medium text-gray-700 mb-1">
                        Species <span class="text-red-500">*</span>
                    </label>
                    <select name="species" id="species" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('species') border-red-500 @enderror"
                        required>
                        <option value="">Select Species</option>
                        @foreach($speciesList as $species)
                            <option value="{{ $species }}" {{ old('species') == $species ? 'selected' : '' }}>
                                {{ ucfirst($species) }}
                            </option>
                        @endforeach
                    </select>
                    @error('species')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Breed -->
                <div>
                    <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">
                        Breed
                    </label>
                    <input type="text" name="breed" id="breed" value="{{ old('breed') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">
                        Color
                    </label>
                    <input type="text" name="color" id="color" value="{{ old('color') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">
                        Gender
                    </label>
                    <select name="gender" id="gender" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        @foreach($genders as $gender)
                            <option value="{{ $gender }}" {{ old('gender', 'unknown') == $gender ? 'selected' : '' }}>
                                {{ ucfirst($gender) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Age -->
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-700 mb-1">
                        Age
                    </label>
                    <input type="number" name="age" id="age" value="{{ old('age') }}" min="0"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <!-- Age Unit -->
                <div>
                    <label for="age_unit" class="block text-sm font-medium text-gray-700 mb-1">
                        Age Unit
                    </label>
                    <select name="age_unit" id="age_unit" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        @foreach($ageUnits as $unit)
                            <option value="{{ $unit }}" {{ old('age_unit', 'years') == $unit ? 'selected' : '' }}>
                                {{ ucfirst($unit) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tag Number -->
                <div>
                    <label for="tag_number" class="block text-sm font-medium text-gray-700 mb-1">
                        Tag Number
                    </label>
                    <input type="text" name="tag_number" id="tag_number" value="{{ old('tag_number') }}" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                        Status
                    </label>
                    <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ old('status', 'active') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Barangay -->
                <div>
                    <label for="barangay_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Barangay
                    </label>
                    <select name="barangay_id" id="barangay_id" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <option value="">Select Barangay</option>
                        @foreach($barangays as $barangay)
                            <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                                {{ $barangay->barangay_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                        Address
                    </label>
                    <textarea name="address" id="address" rows="2" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('address') }}</textarea>
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                        Notes
                    </label>
                    <textarea name="notes" id="notes" rows="3" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('livestock.index') }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Save Record
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
