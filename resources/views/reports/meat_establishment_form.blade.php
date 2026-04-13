@extends('layouts.admin')

@php
$isEdit = isset($establishment) && $establishment;
@endphp

@section('title', $isEdit ? 'Edit Meat Establishment' : 'Meat Establishment Registration')

@section('header', $isEdit ? 'Edit Meat Establishment' : 'Register Meat Establishment')
@section('subheader', $isEdit ? 'Update meat shop or slaughterhouse details' : 'Register new meat shops and slaughterhouses in Dasma')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('meat-inspection.establishments.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition font-medium">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Establishments</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-red-50 to-red-100/50">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-shop-window text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $isEdit ? 'Edit Meat Establishment' : 'Meat Establishment Registration' }}</h3>
                    <p class="text-gray-500">{{ $isEdit ? 'Update establishment details' : 'Register a new meat shop or slaughterhouse' }}</p>
                </div>
            </div>
        </div>

        <form action="{{ $isEdit ? route('meat-inspection.establishments.update', $establishment->establishment_id) : route('meat-inspection.establishments.store') }}" method="POST" class="p-8">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <div class="mb-8">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-200">Establishment Info</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="establishment_name" class="block text-sm font-medium text-gray-700 mb-2">Establishment Name <span class="text-red-500">*</span></label>
                        <input type="text" name="establishment_name" id="establishment_name" value="{{ old('establishment_name', $isEdit ? $establishment->establishment_name : '') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('establishment_name') border-red-500 @enderror"
                            placeholder="Name of meat shop or slaughterhouse" required>
                        @error('establishment_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="establishment_type" class="block text-sm font-medium text-gray-700 mb-2">Establishment Type <span class="text-red-500">*</span></label>
                        <select name="establishment_type" id="establishment_type"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('establishment_type') border-red-500 @enderror"
                            required>
                            <option value="">Select Type</option>
                            <option value="meat_shop" {{ old('establishment_type', $isEdit ? $establishment->establishment_type : '') == 'meat_shop' ? 'selected' : '' }}>Meat Shop/Meat Retailer</option>
                            <option value="slaughterhouse" {{ old('establishment_type', $isEdit ? $establishment->establishment_type : '') == 'slaughterhouse' ? 'selected' : '' }}>Slaughterhouse</option>
                            <option value="livestock_farm" {{ old('establishment_type', $isEdit ? $establishment->establishment_type : '') == 'livestock_farm' ? 'selected' : '' }}>Livestock Farm</option>
                            <option value="poultry_farm" {{ old('establishment_type', $isEdit ? $establishment->establishment_type : '') == 'poultry_farm' ? 'selected' : '' }}>Poultry Farm</option>
                            <option value="meat_processing_plant" {{ old('establishment_type', $isEdit ? $establishment->establishment_type : '') == 'meat_processing_plant' ? 'selected' : '' }}>Meat Processing Plant</option>
                        </select>
                        @error('establishment_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="permit_no" class="block text-sm font-medium text-gray-700 mb-2">Business Permit No.</label>
                        <input type="text" name="permit_no" id="permit_no" value="{{ old('permit_no', $isEdit ? $establishment->permit_no : '') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('permit_no') border-red-500 @enderror"
                            placeholder="Business permit number">
                        @error('permit_no')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-200">Contact & Ownership</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-gray-700 mb-2">Owner Name</label>
                        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $isEdit ? $establishment->owner_name : '') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('owner_name') border-red-500 @enderror"
                            placeholder="Name of owner">
                        @error('owner_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_person" class="block text-sm font-medium text-gray-700 mb-2">Contact Person</label>
                        <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person', $isEdit ? $establishment->contact_person : '') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('contact_person') border-red-500 @enderror"
                            placeholder="Contact person name">
                        @error('contact_person')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $isEdit ? $establishment->contact_number : '') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('contact_number') border-red-500 @enderror"
                            placeholder="Contact number">
                        @error('contact_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $isEdit ? $establishment->email : '') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('email') border-red-500 @enderror"
                            placeholder="email@example.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4 pb-2 border-b border-gray-200">Location Details</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="barangay_id" class="block text-sm font-medium text-gray-700 mb-2">Barangay <span class="text-red-500">*</span></label>
                        <select name="barangay_id" id="barangay_id"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('barangay_id') border-red-500 @enderror"
                            required>
                            <option value="">Select Barangay</option>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->barangay_id }}" {{ (old('barangay_id', $isEdit ? $establishment->barangay_id : '') == $barangay->barangay_id) ? 'selected' : '' }}>
                                    {{ $barangay->barangay_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('barangay_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="landmark" class="block text-sm font-medium text-gray-700 mb-2">Landmark</label>
                        <input type="text" name="landmark" id="landmark" value="{{ old('landmark', $isEdit ? $establishment->landmark : '') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('landmark') border-red-500 @enderror"
                            placeholder="Nearby landmark (optional)">
                        @error('landmark')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="address_text" class="block text-sm font-medium text-gray-700 mb-2">Exact Address <span class="text-red-500">*</span></label>
                        <textarea name="address_text" id="address_text" rows="3"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('address_text') border-red-500 @enderror"
                            placeholder="Street address, building, etc." required>{{ old('address_text', $isEdit ? $establishment->address_text : '') }}</textarea>
                        @error('address_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 mt-8">
                <a href="{{ route('meat-inspection.establishments.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-100 font-medium rounded-lg transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition shadow-lg hover:shadow-xl flex items-center gap-2">
                    <i class="bi bi-check-lg"></i>{{ $isEdit ? 'Update Establishment' : 'Register Establishment' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection