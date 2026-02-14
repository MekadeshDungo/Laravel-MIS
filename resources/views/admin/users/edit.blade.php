@extends('layouts.admin')

@section('title', 'Edit User')

@section('header', 'Edit User')
@section('subheader', 'Update user information')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Users</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">User Information</h3>
            <p class="text-sm text-gray-500">Update the information below</p>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-person text-blue-600"></i> Personal Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('name') border-red-500 @enderror"
                            placeholder="Enter full name" required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                            placeholder="Enter email address" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('phone') border-red-500 @enderror"
                            placeholder="Enter phone number">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date of Birth -->
                    <div>
                        <label for="dob" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob', $user->dob) }}" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('dob') border-red-500 @enderror">
                        @error('dob')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Password Update (Optional) -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-key text-blue-600"></i> Change Password (Optional)
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                        <input type="password" name="password" id="password" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                            placeholder="Leave blank to keep current password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Confirm new password">
                    </div>
                </div>
            </div>

            <!-- Role & Permissions -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-shield text-blue-600"></i> Role & Permissions
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Primary Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Primary Role <span class="text-red-500">*</span></label>
                        <select name="role" id="role" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('role') border-red-500 @enderror" required>
                            <option value="">Select role</option>
                            <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="city_vet" {{ old('role', $user->role) == 'city_vet' ? 'selected' : '' }}>City Vet</option>
                            <option value="records_staff" {{ old('role', $user->role) == 'records_staff' ? 'selected' : '' }}>Records Staff</option>
                            <option value="admin_staff" {{ old('role', $user->role) == 'admin_staff' ? 'selected' : '' }}>Admin Staff</option>
                            <option value="meat_inspector" {{ old('role', $user->role) == 'meat_inspector' ? 'selected' : '' }}>Meat Inspector</option>
                            <option value="inventory_staff" {{ old('role', $user->role) == 'inventory_staff' ? 'selected' : '' }}>Inventory Staff</option>
                            <option value="barangay_encoder" {{ old('role', $user->role) == 'barangay_encoder' ? 'selected' : '' }}>Barangay Encoder</option>
                            <option value="viewer" {{ old('role', $user->role) == 'viewer' ? 'selected' : '' }}>Viewer</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Secondary Role -->
                    <div>
                        <label for="secondary_role" class="block text-sm font-medium text-gray-700 mb-2">Secondary Role (Optional)</label>
                        <select name="secondary_role" id="secondary_role" 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            <option value="">None</option>
                            <option value="city_vet" {{ old('secondary_role', $user->secondary_role) == 'city_vet' ? 'selected' : '' }}>City Vet</option>
                            <option value="records_staff" {{ old('secondary_role', $user->secondary_role) == 'records_staff' ? 'selected' : '' }}>Records Staff</option>
                            <option value="admin_staff" {{ old('secondary_role', $user->secondary_role) == 'admin_staff' ? 'selected' : '' }}>Admin Staff</option>
                            <option value="barangay_encoder" {{ old('secondary_role', $user->secondary_role) == 'barangay_encoder' ? 'selected' : '' }}>Barangay Encoder</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Barangay Assignment -->
            @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin')
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-geo-alt text-blue-600"></i> Barangay Assignment
                </h4>
                <div>
                    <label for="barangay" class="block text-sm font-medium text-gray-700 mb-2">Assigned Barangay</label>
                    <select name="barangay" id="barangay" 
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="">None</option>
                        @foreach(\App\Models\Barangay::orderBy('barangay_name')->get() as $barangay)
                            <option value="{{ $barangay->barangay_name }}" {{ old('barangay', $user->barangay) == $barangay->barangay_name ? 'selected' : '' }}>
                                {{ $barangay->barangay_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif

            <!-- Status -->
            <div class="mb-8">
                <h4 class="text-md font-medium text-gray-700 mb-4 flex items-center gap-2">
                    <i class="bi bi-toggle-on text-blue-600"></i> Account Status
                </h4>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="active" {{ old('status', $user->status) == 'active' ? 'checked' : '' }}
                            class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="radio" name="status" value="inactive" {{ old('status', $user->status) == 'inactive' ? 'checked' : '' }}
                            class="w-4 h-4 text-red-600 border-gray-300 focus:ring-red-500">
                        <span class="text-sm text-gray-700">Inactive</span>
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                    <i class="bi bi-check-lg mr-2"></i>Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
