@extends('layouts.admin')

@section('title', 'Meat Shop Inspections')

@section('header', 'Meat Shop Inspections')
@section('subheader', 'View all meat shop compliance inspection records')

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
                <p class="text-sm uppercase tracking-[0.3em] text-red-100">Meat Shop Inspections</p>
                <h1 class="mt-2 text-3xl font-bold">Compliance Records</h1>
                <p class="mt-2 max-w-2xl text-sm text-red-50">View and manage meat shop compliance inspection records in Dasma.</p>
            </div>
            <a href="{{ route('meat-inspection.meat-shop.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-red-700 shadow-sm transition hover:bg-red-50">
                <i class="bi bi-plus-circle mr-2"></i>New Inspection
            </a>
        </div>
    </div>

    <div class="rounded-3xl border border-red-100 bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Meat Shop</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Date</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Ticket #</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Inspector</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($inspections as $inspection)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4">
                                <p class="font-medium text-gray-900">{{ $inspection->meatShop->establishment_name ?? 'N/A' }}</p>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $inspection->inspection_date->format('M d, Y') }}
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $inspection->ticket_number ?? '-' }}
                            </td>
                            <td class="px-4 py-4">
                                @php
                                    $statusColors = [
                                        'none' => 'bg-gray-100 text-gray-700',
                                        '1st_warning' => 'bg-yellow-100 text-yellow-700',
                                        '2nd_warning' => 'bg-orange-100 text-orange-700',
                                        '3rd_warning' => 'bg-red-100 text-red-700',
                                    ];
                                    $statusLabels = [
                                        'none' => 'None',
                                        '1st_warning' => '1st Warning',
                                        '2nd_warning' => '2nd Warning',
                                        '3rd_warning' => '3rd Warning',
                                    ];
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $statusColors[$inspection->apprehension_status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $statusLabels[$inspection->apprehension_status] ?? 'None' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">
                                {{ $inspection->inspector->name ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-4">
                                <a href="{{ route('meat-inspection.meat-shop.show', $inspection->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                No inspections found. <a href="{{ route('meat-inspection.meat-shop.create') }}" class="text-red-600 hover:text-red-800">Create the first inspection</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inspections->hasPages())
            <div class="mt-4">
                {{ $inspections->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
