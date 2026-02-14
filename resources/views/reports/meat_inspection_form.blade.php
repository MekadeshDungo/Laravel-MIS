@extends('layouts.admin')

@section('title', 'Meat Inspection Certificate')

@section('header', 'Meat Inspection Certificate')
@section('subheader', 'Issue inspection certificate for meat products')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.meat-inspection-reports.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Inspection Records</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-red-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-clipboard-check text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Meat Inspection Certificate</h3>
                    <p class="text-sm text-gray-500">Fill in all required information to issue an inspection certificate</p>
                </div>
            </div>
        </div>

        <form action="{{ route('meat-inspection.reports.store') }}" method="POST" class="p-6">
            @csrf

            <!-- Certificate Info -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-award text-red-600"></i> Certificate Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Certificate Number -->
                    <div>
                        <label for="certificate_number" class="block text-sm font-medium text-gray-700 mb-2">Certificate Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="certificate_number" id="certificate_number" 
                                value="{{ old('certificate_number', 'MI-' . date('Y') . '-' . str_pad(\App\Models\MeatInspectionReport::count() + 1, 6, '0', STR_PAD_LEFT)) }}" 
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-gray-50 @error('certificate_number') border-red-500 @enderror"
                                required readonly>
                            <button type="button" onclick="generateCertNumber()" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">
                                Regenerate
                            </button>
                        </div>
                        @error('certificate_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Inspection Date -->
                    <div>
                        <label for="inspection_date" class="block text-sm font-medium text-gray-700 mb-2">Inspection Date <span class="text-red-500">*</span></label>
                        <input type="date" name="inspection_date" id="inspection_date" value="{{ old('inspection_date', date('Y-m-d')) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('inspection_date') border-red-500 @enderror" required>
                        @error('inspection_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Establishment Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-shop text-blue-600"></i> Establishment Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Establishment Name -->
                    <div>
                        <label for="establishment_name" class="block text-sm font-medium text-gray-700 mb-2">Establishment Name <span class="text-red-500">*</span></label>
                        <input type="text" name="establishment_name" id="establishment_name" value="{{ old('establishment_name') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('establishment_name') border-red-500 @enderror"
                            placeholder="Name of slaughterhouse/abattoir" required>
                        @error('establishment_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Establishment Type -->
                    <div>
                        <label for="establishment_type" class="block text-sm font-medium text-gray-700 mb-2">Establishment Type <span class="text-red-500">*</span></label>
                        <select name="establishment_type" id="establishment_type" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('establishment_type') border-red-500 @enderror" required>
                            <option value="">Select type</option>
                            <option value="slaughterhouse" {{ old('establishment_type') == 'slaughterhouse' ? 'selected' : '' }}>Slaughterhouse</option>
                            <option value="meat_shop" {{ old('establishment_type') == 'meat_shop' ? 'selected' : '' }}>Meat Shop</option>
                            <option value="cold_storage" {{ old('establishment_type') == 'cold_storage' ? 'selected' : '' }}>Cold Storage</option>
                            <option value="processing_plant" {{ old('establishment_type') == 'processing_plant' ? 'selected' : '' }}>Processing Plant</option>
                            <option value="market" {{ old('establishment_type') == 'market' ? 'selected' : '' }}>Public Market</option>
                        </select>
                        @error('establishment_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- License Number -->
                    <div>
                        <label for="license_number" class="block text-sm font-medium text-gray-700 mb-2">License Number</label>
                        <input type="text" name="license_number" id="license_number" value="{{ old('license_number') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="LTO/LTO number">
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label for="contact_number" class="block text-sm font-medium text-gray-700 mb-2">Contact Number</label>
                        <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="Contact number">
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address <span class="text-red-500">*</span></label>
                        <textarea name="address" id="address" rows="2"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('address') border-red-500 @enderror"
                            placeholder="Complete address" required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Meat Details -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-box-seam text-red-600"></i> Meat Details
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Animal Type -->
                    <div>
                        <label for="animal_type" class="block text-sm font-medium text-gray-700 mb-2">Animal Type <span class="text-red-500">*</span></label>
                        <select name="animal_type" id="animal_type" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('animal_type') border-red-500 @enderror" required>
                            <option value="">Select animal</option>
                            <option value="cattle" {{ old('animal_type') == 'cattle' ? 'selected' : '' }}>Cattle</option>
                            <option value="carabao" {{ old('animal_type') == 'carabao' ? 'selected' : '' }}>Carabao</option>
                            <option value="swine" {{ old('animal_type') == 'swine' ? 'selected' : '' }}>Swine</option>
                            <option value="goat" {{ old('animal_type') == 'goat' ? 'selected' : '' }}>Goat</option>
                            <option value="sheep" {{ old('animal_type') == 'sheep' ? 'selected' : '' }}>Sheep</option>
                            <option value="chicken" {{ old('animal_type') == 'chicken' ? 'selected' : '' }}>Chicken</option>
                            <option value="horse" {{ old('animal_type') == 'horse' ? 'selected' : '' }}>Horse</option>
                            <option value="other" {{ old('animal_type') == 'other' ? 'selected' : 'other' }}>Other</option>
                        </select>
                        @error('animal_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('quantity') border-red-500 @enderror"
                            required>
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Unit -->
                    <div>
                        <label for="quantity_unit" class="block text-sm font-medium text-gray-700 mb-2">Unit <span class="text-red-500">*</span></label>
                        <select name="quantity_unit" id="quantity_unit" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('quantity_unit') border-red-500 @enderror" required>
                            <option value="heads" {{ old('quantity_unit') == 'heads' ? 'selected' : '' }}>Heads</option>
                            <option value="kg" {{ old('quantity_unit') == 'kg' ? 'selected' : 'kg' }}>Kilograms</option>
                            <option value="pieces" {{ old('quantity_unit') == 'pieces' ? 'selected' : '' }}>Pieces</option>
                            <option value="carcasses" {{ old('quantity_unit') == 'carcasses' ? 'selected' : '' }}>Carcasses</option>
                        </select>
                        @error('quantity_unit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Origin Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-geo-alt text-blue-600"></i> Origin Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Origin -->
                    <div>
                        <label for="origin" class="block text-sm font-medium text-gray-700 mb-2">Origin/Source</label>
                        <input type="text" name="origin" id="origin" value="{{ old('origin') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="Farm or source of animals">
                    </div>

                    <!-- Transport Mode -->
                    <div>
                        <label for="transport_mode" class="block text-sm font-medium text-gray-700 mb-2">Mode of Transport</label>
                        <select name="transport_mode" id="transport_mode" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition">
                            <option value="">Select mode</option>
                            <option value="truck" {{ old('transport_mode') == 'truck' ? 'selected' : '' }}>Truck</option>
                            <option value="van" {{ old('transport_mode') == 'van' ? 'selected' : '' }}>Van</option>
                            <option value="cart" {{ old('transport_mode') == 'cart' ? 'selected' : '' }}>Cart</option>
                            <option value="walking" {{ old('transport_mode') == 'walking' ? 'selected' : '' }}>Walking</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Inspection Results -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-search text-green-600"></i> Inspection Results
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Result -->
                    <div>
                        <label for="compliance_status" class="block text-sm font-medium text-gray-700 mb-2">Result <span class="text-red-500">*</span></label>
                        <select name="compliance_status" id="compliance_status" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('compliance_status') border-red-500 @enderror" required>
                            <option value="">Select result</option>
                            <option value="compliant" {{ old('compliance_status') == 'compliant' ? 'selected' : '' }}>Passed</option>
                            <option value="non_compliant" {{ old('compliance_status') == 'non_compliant' ? 'selected' : '' }}>Condemned</option>
                        </select>
                        @error('compliance_status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Temperature -->
                    <div>
                        <label for="temperature" class="block text-sm font-medium text-gray-700 mb-2">Temperature (°C)</label>
                        <input type="number" name="temperature" id="temperature" value="{{ old('temperature') }}" step="0.1"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="Storage temperature">
                    </div>
                </div>
            </div>

            <!-- Inspector Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-person-badge text-blue-600"></i> Inspector Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Inspector Name -->
                    <div>
                        <label for="inspector_name" class="block text-sm font-medium text-gray-700 mb-2">Inspector Name <span class="text-red-500">*</span></label>
                        <input type="text" name="inspector_name" id="inspector_name" value="{{ old('inspector_name', auth()->user()->name) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition @error('inspector_name') border-red-500 @enderror"
                            placeholder="Name of meat inspector" required>
                        @error('inspector_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- License Number -->
                    <div>
                        <label for="inspector_license" class="block text-sm font-medium text-gray-700 mb-2">License Number</label>
                        <input type="text" name="inspector_license" id="inspector_license" value="{{ old('inspector_license') }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                            placeholder="Inspector license number">
                    </div>
                </div>
            </div>

            <!-- Remarks -->
            <div class="mb-8">
                <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                <textarea name="remarks" id="remarks" rows="3"
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                    placeholder="Additional notes or observations">{{ old('remarks') }}</textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.meat-inspection-reports.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i>Issue Certificate
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function generateCertNumber() {
    const year = new Date().getFullYear();
    const random = Math.floor(Math.random() * 999999).toString().padStart(6, '0');
    document.getElementById('certificate_number').value = 'MI-' + year + '-' + random;
}
</script>
@endpush
@endsection
