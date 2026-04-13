@extends('layouts.admin')

@php
$isEdit = isset($inspection) && $inspection;
@endphp

@section('title', 'Meat Shop Inspection Form')

@section('header', $isEdit ? 'Edit Meat Shop Inspection' : 'Meat Shop Compliance Inspection')
@section('subheader', $isEdit ? 'Update inspection details' : 'Conduct compliance inspection for meat shops in Dasma')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('meat-inspection.meat-shop.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition font-medium">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Inspections</span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-red-50 to-red-100/50">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="bi bi-clipboard-check text-white text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Meat Shop Compliance Inspection Form</h3>
                    <p class="text-gray-500">Fill in all required information to record the inspection</p>
                </div>
            </div>
        </div>

        <form action="{{ $isEdit ? route('meat-inspection.meat-shop.update', $inspection->id) : route('meat-inspection.meat-shop.store') }}" method="POST" class="p-8">
            @csrf
            @if($isEdit)
                @method('PUT')
            @endif

            <!-- Section I: Header Info -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-info-circle text-blue-600"></i>
                    </span>
                    I. Header Info
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="meat_shop_id" class="block text-sm font-medium text-gray-700 mb-2">Meat Shop Name <span class="text-red-500">*</span></label>
                        <select name="meat_shop_id" id="meat_shop_id"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('meat_shop_id') border-red-500 @enderror"
                            required>
                            <option value="">Select Meat Shop</option>
                            @foreach($meatShops as $shop)
                                <option value="{{ $shop->establishment_id }}" {{ old('meat_shop_id', $isEdit ? $inspection->meat_shop_id : '') == $shop->establishment_id ? 'selected' : '' }}>
                                    {{ $shop->establishment_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('meat_shop_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="inspection_date" class="block text-sm font-medium text-gray-700 mb-2">Date of Inspection <span class="text-red-500">*</span></label>
                        <input type="date" name="inspection_date" id="inspection_date" value="{{ old('inspection_date', $isEdit ? $inspection->inspection_date : date('Y-m-d')) }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('inspection_date') border-red-500 @enderror" required>
                        @error('inspection_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ticket_number" class="block text-sm font-medium text-gray-700 mb-2">Ticket Number</label>
                        <input type="text" name="ticket_number" id="ticket_number" value="{{ old('ticket_number', $isEdit ? $inspection->ticket_number : '') }}"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('ticket_number') border-red-500 @enderror"
                            placeholder="Manual input from printed ticket">
                        @error('ticket_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section II: Compliance Checklist -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-check2-square text-green-600"></i>
                    </span>
                    II. Compliance Checklist
                </h4>

                <div class="space-y-6">
                    <!-- 1. Licensing -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="licensing" value="compliant" {{ old('licensing', $isEdit ? $inspection->licensing : '') == 'compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-gray-700">Compliant</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="licensing" value="non_compliant" {{ old('licensing', $isEdit ? $inspection->licensing : '') == 'non_compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-red-600 focus:ring-red-500">
                                    <span class="text-sm font-medium text-gray-700">Non-Compliant</span>
                                </label>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">1. Licensing</p>
                                <p class="text-sm text-gray-500 mt-1">Possession of appropriate License, Business Permit, Sanitary Permit, Meat Inspection Certificate (MIC) AO No. 5, Section 3.2, 3.3 and COMI; Accredited MTV for delivery.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Storage -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="storage" value="compliant" {{ old('storage', $isEdit ? $inspection->storage : '') == 'compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-gray-700">Compliant</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="storage" value="non_compliant" {{ old('storage', $isEdit ? $inspection->storage : '') == 'non_compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-red-600 focus:ring-red-500">
                                    <span class="text-sm font-medium text-gray-700">Non-Compliant</span>
                                </label>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">2. Storage</p>
                                <p class="text-sm text-gray-500 mt-1">No proper cooling facility (Freezer) for frozen meat as per AO No. 6; correct temperature should be 0°C or below.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Meat Quality -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="meat_quality" value="compliant" {{ old('meat_quality', $isEdit ? $inspection->meat_quality : '') == 'compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-gray-700">Compliant</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="meat_quality" value="non_compliant" {{ old('meat_quality', $isEdit ? $inspection->meat_quality : '') == 'non_compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-red-600 focus:ring-red-500">
                                    <span class="text-sm font-medium text-gray-700">Non-Compliant</span>
                                </label>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">3. Meat Quality</p>
                                <p class="text-sm text-gray-500 mt-1">Improper mixing of meat (Thawed, Frozen, and Fresh) as per AO No. 6, Section 6.1.2.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Sanitation -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="sanitation" value="compliant" {{ old('sanitation', $isEdit ? $inspection->sanitation : '') == 'compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-gray-700">Compliant</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="sanitation" value="non_compliant" {{ old('sanitation', $isEdit ? $inspection->sanitation : '') == 'non_compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-red-600 focus:ring-red-500">
                                    <span class="text-sm font-medium text-gray-700">Non-Compliant</span>
                                </label>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">4. Sanitation</p>
                                <p class="text-sm text-gray-500 mt-1">Dirty surroundings as per AO No. 7.1.4, 7.1.6, 8.3 & 8.7; facility must be kept clean and orderly to avoid vermin or pests.</p>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Lighting -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="lighting" value="compliant" {{ old('lighting', $isEdit ? $inspection->lighting : '') == 'compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-gray-700">Compliant</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="lighting" value="non_compliant" {{ old('lighting', $isEdit ? $inspection->lighting : '') == 'non_compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-red-600 focus:ring-red-500">
                                    <span class="text-sm font-medium text-gray-700">Non-Compliant</span>
                                </label>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">5. Lighting</p>
                                <p class="text-sm text-gray-500 mt-1">Prohibition of colored lights or other deceptive materials that mislead consumers regarding the quality of meat (AO No. 5, Section 6.1.8).</p>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Personal Hygiene -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="personal_hygiene" value="compliant" {{ old('personal_hygiene', $isEdit ? $inspection->personal_hygiene : '') == 'compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-gray-700">Compliant</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="personal_hygiene" value="non_compliant" {{ old('personal_hygiene', $isEdit ? $inspection->personal_hygiene : '') == 'non_compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-red-600 focus:ring-red-500">
                                    <span class="text-sm font-medium text-gray-700">Non-Compliant</span>
                                </label>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">6. Personal Hygiene</p>
                                <p class="text-sm text-gray-500 mt-1">Proper personal hygiene of meat handlers: regular bathing, wearing clean and appropriate clothing, handwashing, and no smoking (AO No. 5, Section 8).</p>
                            </div>
                        </div>
                    </div>

                    <!-- 7. Equipment -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex items-start gap-4">
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="equipment" value="compliant" {{ old('equipment', $isEdit ? $inspection->equipment : '') == 'compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-green-600 focus:ring-green-500">
                                    <span class="text-sm font-medium text-gray-700">Compliant</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="equipment" value="non_compliant" {{ old('equipment', $isEdit ? $inspection->equipment : '') == 'non_compliant' ? 'checked' : '' }}
                                        class="w-5 h-5 text-red-600 focus:ring-red-500">
                                    <span class="text-sm font-medium text-gray-700">Non-Compliant</span>
                                </label>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">7. Equipment</p>
                                <p class="text-sm text-gray-500 mt-1">Use of proper equipment such as Chopping Boards (Sangkalan) without cracks and kept clean; no use of paper/cardboard for wrapping.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section III: Remarks -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle text-yellow-600"></i>
                    </span>
                    III. Remarks
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="apprehension_status" class="block text-sm font-medium text-gray-700 mb-2">Status of Apprehension</label>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="apprehension_status" value="none" {{ old('apprehension_status', $isEdit ? $inspection->apprehension_status : 'none') == 'none' ? 'checked' : '' }}
                                    class="w-5 h-5 text-gray-600 focus:ring-gray-500">
                                <span class="text-sm text-gray-700">None</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="apprehension_status" value="1st_warning" {{ old('apprehension_status', $isEdit ? $inspection->apprehension_status : '') == '1st_warning' ? 'checked' : '' }}
                                    class="w-5 h-5 text-yellow-600 focus:ring-yellow-500">
                                <span class="text-sm text-gray-700">1st Warning</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="apprehension_status" value="2nd_warning" {{ old('apprehension_status', $isEdit ? $inspection->apprehension_status : '') == '2nd_warning' ? 'checked' : '' }}
                                    class="w-5 h-5 text-orange-600 focus:ring-orange-500">
                                <span class="text-sm text-gray-700">2nd Warning</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" name="apprehension_status" value="3rd_warning" {{ old('apprehension_status', $isEdit ? $inspection->apprehension_status : '') == '3rd_warning' ? 'checked' : '' }}
                                    class="w-5 h-5 text-red-600 focus:ring-red-500">
                                <span class="text-sm text-gray-700">3rd Warning</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Additional Remarks</label>
                        <textarea name="remarks" id="remarks" rows="4"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="Additional notes or observations">{{ old('remarks', $isEdit ? $inspection->remarks : '') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Section IV: Inspector Info -->
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-person-badge text-purple-600"></i>
                    </span>
                    IV. Inspector Info
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Apprehended By</label>
                        <div class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 font-medium">
                            {{ auth()->user()->name }}
                        </div>
                        <input type="hidden" name="apprehended_by_user_id" value="{{ auth()->id() }}">
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('meat-inspection.meat-shop.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 hover:bg-gray-100 font-medium rounded-lg transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition shadow-lg hover:shadow-xl flex items-center gap-2">
                    <i class="bi bi-check-lg"></i>{{ $isEdit ? 'Update Inspection' : 'Submit Inspection' }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
