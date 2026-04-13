@php
    $animalOptions = ['cow', 'pig', 'chicken', 'goat', 'duck', 'carabao', 'horse', 'sheep'];
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label for="owner_name" class="mb-2 block text-sm font-semibold text-slate-700">Owner Name</label>
        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $livestock->owner_name ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
        @error('owner_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="farm_name" class="mb-2 block text-sm font-semibold text-slate-700">Farm Name</label>
        <input type="text" name="farm_name" id="farm_name" value="{{ old('farm_name', $livestock->farm_name ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        @error('farm_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="animal_type" class="mb-2 block text-sm font-semibold text-slate-700">Animal Type</label>
        <select name="animal_type" id="animal_type" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
            <option value="">Select animal type</option>
            @foreach($animalOptions as $option)
                <option value="{{ $option }}" @selected(old('animal_type', $livestock->animal_type ?? '') === $option)>{{ ucfirst($option) }}</option>
            @endforeach
        </select>
        @error('animal_type')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="quantity" class="mb-2 block text-sm font-semibold text-slate-700">Quantity</label>
        <input type="number" min="1" step="1" name="quantity" id="quantity" value="{{ old('quantity', $livestock->quantity ?? 1) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
        @error('quantity')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="barangay_id" class="mb-2 block text-sm font-semibold text-slate-700">Barangay</label>
        <select name="barangay_id" id="barangay_id" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
            <option value="">Select barangay</option>
            @foreach($barangays as $barangay)
                <option value="{{ $barangay->barangay_id }}" @selected((string) old('barangay_id', $livestock->barangay_id ?? '') === (string) $barangay->barangay_id)>{{ $barangay->barangay_name }}</option>
            @endforeach
        </select>
        @error('barangay_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-8 flex items-center justify-end gap-3">
    <a href="{{ route('livestock.index') }}" class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Cancel</a>
    <button type="submit" class="rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">{{ $submitLabel }}</button>
</div>
