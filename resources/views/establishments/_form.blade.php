@php
    $types = [
        'clinic' => 'Clinic',
        'pet_shop' => 'Pet Shop',
        'grooming' => 'Grooming',
    ];
@endphp

<div class="grid gap-6 md:grid-cols-2">
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Business Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $establishment->name ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
        @error('name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="type" class="mb-2 block text-sm font-semibold text-slate-700">Business Type</label>
        <select name="type" id="type" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
            <option value="">Select business type</option>
            @foreach($types as $value => $label)
                <option value="{{ $value }}" @selected(old('type', $establishment->type ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('type')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="owner_name" class="mb-2 block text-sm font-semibold text-slate-700">Owner Name</label>
        <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name', $establishment->owner_name ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
        @error('owner_name')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="contact_number" class="mb-2 block text-sm font-semibold text-slate-700">Contact Number</label>
        <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $establishment->contact_number ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
        @error('contact_number')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">Address</label>
        <input type="text" name="address" id="address" value="{{ old('address', $establishment->address ?? '') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
        @error('address')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="barangay_id" class="mb-2 block text-sm font-semibold text-slate-700">Barangay</label>
        <select name="barangay_id" id="barangay_id" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
            <option value="">Select barangay</option>
            @foreach($barangays as $barangay)
                <option value="{{ $barangay->barangay_id }}" @selected((string) old('barangay_id', $establishment->barangay_id ?? '') === (string) $barangay->barangay_id)>{{ $barangay->barangay_name }}</option>
            @endforeach
        </select>
        @error('barangay_id')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="status" class="mb-2 block text-sm font-semibold text-slate-700">Status</label>
        <select name="status" id="status" class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200" required>
            <option value="active" @selected(old('status', $establishment->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $establishment->status ?? '') === 'inactive')>Inactive</option>
        </select>
        @error('status')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-8 flex items-center justify-end gap-3">
    <a href="{{ route('establishments.index') }}" class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Cancel</a>
    <button type="submit" class="rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">{{ $submitLabel }}</button>
</div>
