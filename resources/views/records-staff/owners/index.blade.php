@extends('layouts.admin')

@section('title', 'Pet Owners')

@section('header', 'Pet Owners')

@section('content')
<div class="p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pet Owners</h1>
            <p class="text-gray-500 mt-1">Manage all registered pet owners</p>
        </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-xl shadow-sm mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin-staff.owners.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Name, email, or contact..." value="{{ $search }}">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Search</button>
                    <a href="{{ route('admin-staff.owners.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">Clear</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Owners List -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="overflow-x-auto">
            @if($owners->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Owner Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Contact</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pets</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Registered</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($owners as $owner)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $owner->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $owner->email }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $owner->contact_number ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $owner->pets_count }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm">{{ $owner->created_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin-staff.owners.show', $owner) }}" class="p-2 text-info hover:bg-info hover:bg-opacity-10 rounded-lg transition" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $owners->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="bi bi-people text-5xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 mb-4">No pet owners found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
