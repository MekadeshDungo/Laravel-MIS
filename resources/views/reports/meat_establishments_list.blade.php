@extends('layouts.admin')

@section('title', 'Meat Establishments')

@section('header', 'Meat Establishments')
@section('subheader', 'Registered meat shops and slaughterhouses in Dasma')

@php
function getEstablishmentTypeLabel($type) {
    return match($type) {
        'meat_shop' => 'Meat Shop/Retailer',
        'slaughterhouse' => 'Slaughterhouse',
        'livestock_farm' => 'Livestock Farm',
        'poultry_farm' => 'Poultry Farm',
        'meat_processing_plant' => 'Meat Processing Plant',
        default => '-',
    };
}
@endphp

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="rounded-3xl bg-gradient-to-r from-red-700 via-red-600 to-red-500 p-6 text-white shadow-lg">
        <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-red-100">Meat Establishments</p>
                <h1 class="mt-2 text-3xl font-bold">Registered Shops</h1>
                <p class="mt-2 max-w-2xl text-sm text-red-50">Manage registered meat shops and slaughterhouses in Dasma.</p>
            </div>
            <a href="{{ route('meat-inspection.establishments.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50">
                <i class="bi bi-plus-circle mr-2"></i>Register New
            </a>
        </div>
    </div>

    <div class="rounded-3xl border border-red-100 bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Name</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Type</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Owner</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Contact</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Barangay</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Permit No.</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($establishments as $establishment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <p class="font-medium text-gray-900">{{ $establishment->establishment_name }}</p>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ getEstablishmentTypeLabel($establishment->establishment_type) }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $establishment->owner_name ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                @if($establishment->contact_number || $establishment->email)
                                    <div>{{ $establishment->contact_number ?? '-' }}</div>
                                    <div class="text-xs text-gray-400">{{ $establishment->email ?? '' }}</div>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $establishment->barangay->barangay_name ?? '-' }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $establishment->permit_no ?? '-' }}
                            </td>
                            <td class="px-4 py-4">
                                <a href="{{ route('meat-inspection.establishments.show', $establishment->establishment_id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                No establishments found. <a href="{{ route('meat-inspection.establishments.create') }}" class="text-red-600 hover:text-red-800">Register the first establishment</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($establishments->hasPages())
            <div class="mt-4">
                {{ $establishments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection