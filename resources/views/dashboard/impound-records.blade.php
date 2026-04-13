@extends('layouts.admin')

@section('title', 'Impound Records')
@section('header', 'Impound Records Management')
@section('subheader', 'View and manage impounded animal records')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-amber-600 to-orange-800 rounded-xl shadow-lg p-6 mb-8 text-white">
    <h2 class="text-2xl font-bold mb-2">Impound Records</h2>
    <p class="text-amber-100">Manage all impounded animal records from stray reports.</p>
</div>

<!-- Impound Records Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">All Impound Records</h3>
            <a href="#" class="px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                <i class="bi bi-plus-circle mr-2"></i>New Impound Record
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Animal Tag</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intake Condition</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intake Location</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intake Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Disposition</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($impounds as $impound)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        #{{ $impound->impound_id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $impound->animal_tag_code ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $impound->intake_condition ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $impound->intake_location ?? 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $impound->intake_date ? $impound->intake_date->format('M d, Y') : 'N/A' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @switch($impound->current_disposition)
                                @case('impounded') bg-yellow-100 text-yellow-800 @break
                                @case('claimed') bg-green-100 text-green-800 @break
                                @case('adopted') bg-blue-100 text-blue-800 @break
                                @case('transferred') bg-gray-100 text-gray-800 @break
                                @default bg-gray-100 text-gray-800
                            @endswitch
                        ">
                            {{ ucfirst($impound->current_disposition ?? 'unknown') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.impounds.show', $impound->impound_id) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.impounds.edit', $impound->impound_id) }}" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 bg-green-50 rounded-full flex items-center justify-center mb-6">
                                <i class="bi bi-paw text-green-400 text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-3">No Impound Records Found</h3>
                            <p class="text-gray-500 mb-8 max-w-md mx-auto">There are currently no recorded impound records. Start by creating a new impound record to begin tracking.</p>
                            <a href="#" class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                <i class="bi bi-plus-lg"></i>
                                Create Impound Record
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($impounds->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $impounds->links() }}
    </div>
    @endif
</div>
@endsection
