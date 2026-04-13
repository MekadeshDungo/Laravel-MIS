@extends('layouts.admin')

@section('title', 'Edit Adoption Pet')

@section('header', 'Edit Adoption Pet')
@section('subheader', 'Update pet information')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin-staff.adoption-pets.show', $adoptionPet) }}" class="p-2 hover:bg-gray-100 rounded-lg transition">
            <i class="bi bi-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit {{ $adoptionPet->pet_name }}</h1>
            <p class="text-gray-500 mt-1">Update pet information</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm">
        <form method="POST" action="{{ route('admin-staff.adoption-pets.update', $adoptionPet) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pet_name" class="block text-sm font-medium text-gray-700 mb-1">Pet Name <span class="text-red-500">*</span></label>
                    <input type="text" name="pet_name" id="pet_name" value="{{ old('pet_name', $adoptionPet->pet_name) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    @error('pet_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="species" class="block text-sm font-medium text-gray-700 mb-1">Species <span class="text-red-500">*</span></label>
                    <select name="species" id="species" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Select Species</option>
                        <option value="Dog" {{ old('species', $adoptionPet->species) == 'Dog' ? 'selected' : '' }}>Dog</option>
                        <option value="Cat" {{ old('species', $adoptionPet->species) == 'Cat' ? 'selected' : '' }}>Cat</option>
                    </select>
                    @error('species')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="breed" class="block text-sm font-medium text-gray-700 mb-1">Breed</label>
                    <input type="text" name="breed" id="breed" value="{{ old('breed', $adoptionPet->breed) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="e.g., Labrador, Persian">
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender <span class="text-red-500">*</span></label>
                    <select name="gender" id="gender" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender', $adoptionPet->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $adoptionPet->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', $adoptionPet->date_of_birth ? $adoptionPet->date_of_birth->format('Y-m-d') : '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                    <input type="number" name="weight" id="weight" value="{{ old('weight', $adoptionPet->weight) }}" step="0.1" min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-2">
                        <input type="checkbox" name="is_age_estimated" id="is_age_estimated" value="1" 
                            {{ old('is_age_estimated', $adoptionPet->is_age_estimated) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <label for="is_age_estimated" class="text-sm text-gray-700">Age is estimated</label>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('description', $adoptionPet->description) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Traits</label>
                    <div class="flex flex-wrap gap-2">
                        @forelse($traits as $trait)
                            <label class="inline-flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-100">
                                <input type="checkbox" name="traits[]" value="{{ $trait->trait_id }}" 
                                    {{ in_array($trait->trait_id, old('traits', $selectedTraits)) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                <span class="text-sm text-gray-700">{{ $trait->name }}</span>
                            </label>
                        @empty
                            <p class="text-gray-500 text-sm">No traits available.</p>
                        @endforelse
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                    @if($adoptionPet->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $adoptionPet->image) }}" alt="Current photo" class="w-32 h-32 object-cover rounded-lg">
                            <p class="text-xs text-gray-500 mt-1">Current photo</p>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <p class="text-gray-500 text-xs mt-1">Leave empty to keep current photo. Max 2MB.</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('admin-staff.adoption-pets.show', $adoptionPet) }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    <i class="bi bi-check-lg mr-2"></i>Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection