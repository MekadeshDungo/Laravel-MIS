@extends('layouts.admin')

@section('title', 'Animal Bite Incident Report Details')

@section('header', 'Animal Bite Incident Report Details')
@section('subheader', 'View full details of the incident report')

@php
$rolePrefix = str_replace('_', '-', auth()->user()->role ?? 'assistant-vet');

// Get available route for rabies-bite-reports
$rabiesReportsIndexRoute = 'city-vet.rabies-bite-reports.index';
$rabiesReportsShowRoute = 'city-vet.rabies-bite-reports.show';
} elseif ($rolePrefix === 'city-vet') {
    if (Route::has('city-vet.rabies-bite-reports.index')) {
        $rabiesReportsIndexRoute = 'city-vet.rabies-bite-reports.index';
        $rabiesReportsShowRoute = 'city-vet.rabies-bite-reports.show';
        $rabiesReportsAcceptRoute = 'city-vet.rabies-bite-reports.accept';
        $rabiesReportsResolveRoute = 'city-vet.rabies-bite-reports.resolve';
        $rabiesReportsDeclineRoute = 'city-vet.rabies-bite-reports.decline';
    }
}
@endphp

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header with Breadcrumb -->
    <div class="mb-6">
        <nav class="text-sm text-gray-500 mb-2">
            <ol class="list-none p-0 flex items-center space-x-2">
                <li><a href="{{ route($rolePrefix . '.dashboard') }}" class="hover:text-green-600 transition">Dashboard</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li><a href="{{ route($rabiesReportsIndexRoute) }}" class="hover:text-green-600 transition">Rabies Bite Reports</a></li>
                <li><i class="bi bi-chevron-right text-xs"></i></li>
                <li class="text-gray-800">Details</li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Rabies Bite Incident Report Details</h1>
                <p class="text-gray-500 mt-1">View complete information about the incident</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route($rabiesReportsIndexRoute) }}" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition">
                    <i class="bi bi-arrow-left mr-1"></i>Back to List
                </a>
                <button onclick="window.print()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    <i class="bi bi-printer mr-1"></i>Print
                </button>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <i class="bi bi-check-circle mr-2"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Status Badge -->
    <div class="mb-6 flex items-center gap-4 flex-wrap">
        <span class="text-lg font-semibold text-gray-700">Status:</span>
        @php
            $statusConfig = [
                'Pending Review' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'bi-clock'],
                'Under Review' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'bi-search'],
                'Resolved' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'bi-check-circle'],
                'Closed' => ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'bi-x-circle'],
            ];
            $status = $statusConfig[$rabiesReport->status] ?? ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'bi-circle'];
        @endphp
        <span class="px-4 py-2 text-sm font-semibold rounded-full {{ $status['class'] }}">
            <i class="{{ $status['icon'] }} mr-1"></i>{{ $rabiesReport->status }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">

            <!-- SECTION I: Source of Report -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-green-600 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-building text-white"></i>
                    <h3 class="text-lg font-semibold text-white">SECTION I: Source of Report</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Reporting Facility</label>
                            <p class="text-gray-900 font-medium">{{ $rabiesReport->reporting_facility }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date Reported</label>
                            <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($rabiesReport->date_reported)->format('F d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION II: Patient Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-blue-600 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-person text-white"></i>
                    <h3 class="text-lg font-semibold text-white">SECTION II: Patient (Human) Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Patient Name</label>
                            <p class="text-gray-900 font-medium">{{ $rabiesReport->patient_name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Age</label>
                            <p class="text-gray-900 font-medium">{{ $rabiesReport->age }} years old</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                            <p class="text-gray-900 font-medium">{{ $rabiesReport->gender }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Address (Barangay)</label>
                            <p class="text-gray-900 font-medium">{{ $rabiesReport->barangay->barangay_name ?? ($rabiesReport->patient_barangay ?? 'N/A') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Contact Number</label>
                            <p class="text-gray-900 font-medium">{{ $rabiesReport->patient_contact ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION III: Incident Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-red-600 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-exclamation-triangle text-white"></i>
                    <h3 class="text-lg font-semibold text-white">SECTION III: Incident Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date of Incident</label>
                            <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($rabiesReport->incident_date)->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nature of Incident</label>
                            <p class="text-gray-900 font-medium">{{ ucfirst($rabiesReport->exposure_type) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Bite Site (Body Part)</label>
                            <p class="text-gray-900 font-medium">{{ $rabiesReport->bite_site ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Exposure Category</label>
                            <p class="text-gray-900 font-medium">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @switch($rabiesReport->category)
                                        @case('I') bg-gray-200 text-gray-800
                                        @case('II') bg-yellow-200 text-yellow-800
                                        @case('III') bg-red-200 text-red-800
                                    @endswitch">
                                    Category {{ $rabiesReport->category }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION IV: Animal Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-purple-600 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-paw text-white"></i>
                    <h3 class="text-lg font-semibold text-white">SECTION IV: Animal Information</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Animal Species</label>
                            <p class="text-gray-900 font-medium">{{ ucfirst($rabiesReport->animal_type) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Animal Status</label>
                            <p class="text-gray-900 font-medium">{{ ucfirst($rabiesReport->animal_status) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Vaccination Status</label>
                            <p class="text-gray-900 font-medium">{{ ucfirst($rabiesReport->vaccination_status) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION V: Clinical Action -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-teal-600 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-clipboard-pulse text-white"></i>
                    <h3 class="text-lg font-semibold text-white">SECTION V: Clinical Action</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Wound Management</label>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $woundManagement = is_array($rabiesReport->wound_management) ? $rabiesReport->wound_management : json_decode($rabiesReport->wound_management, true) ?? [];
                                @endphp
                                @forelse($woundManagement as $wm)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-800">{{ $wm }}</span>
                                @empty
                                    <span class="text-gray-500">None</span>
                                @endforelse
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Post-Exposure Prophylaxis (PEP)</label>
                            <p class="text-gray-900 font-medium">{{ $rabiesReport->post_exposure_prophylaxis }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if($rabiesReport->notes)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-600 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-chat-left-text text-white"></i>
                    <h3 class="text-lg font-semibold text-white">Notes</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-900 whitespace-pre-line">{{ $rabiesReport->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar - Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
                <div class="bg-gray-800 px-6 py-3 flex items-center gap-2">
                    <i class="bi bi-gear text-white"></i>
                    <h3 class="text-lg font-semibold text-white">Actions</h3>
                </div>
                <div class="p-6 space-y-4">

                    <!-- Case Info -->
                    <div class="border-b border-gray-200 pb-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Report Information</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Case ID:</span>
                                <span class="text-gray-900 font-medium">{{ $rabiesReport->report_number }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Submitted:</span>
                                <span class="text-gray-900">{{ \Carbon\Carbon::parse($rabiesReport->created_at)->format('M d, Y h:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons - Only for assistant_vet (not city_vet) -->
                    @if(auth()->user()->role !== 'city_vet')
                        @if(!$rabiesReport->rabiesCase && in_array($rabiesReport->status, ['Pending Review', 'Under Review']))
                            <a href="{{ route($rolePrefix . '.rabies-bite-reports.create-case', $rabiesReport->id) }}"
                               class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">
                                <i class="bi bi-plus-circle"></i> Create Rabies Case
                            </a>
                        @endif

                        @if($rabiesReport->rabiesCase)
                            <a href="{{ route($rolePrefix . '.rabies-cases.show', $rabiesReport->rabiesCase->id) }}"
                               class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition">
                                <i class="bi bi-eye"></i> View Linked Case
                            </a>
                        @endif

                        @if($rabiesReport->status === 'Pending Review')
                            <form action="{{ route($rabiesReportsAcceptRoute, $rabiesReport->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                    <i class="bi bi-check-circle"></i> Accept & Start Review
                                </button>
                            </form>
                        @endif

                        @if($rabiesReport->status === 'Under Review')
                            <form action="{{ route($rabiesReportsResolveRoute, $rabiesReport->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                                    <i class="bi bi-check-all"></i> Mark as Resolved
                                </button>
                            </form>
                        @endif

                        @if(in_array($rabiesReport->status, ['Pending Review', 'Under Review']))
                            <button type="button" onclick="document.getElementById('declineModal').classList.remove('hidden')"
                                    class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
                                <i class="bi bi-x-circle"></i> Decline Report
                            </button>
                        @endif
                    @else
                        <!-- City Vet View Only - Show info message -->
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg text-center">
                            <i class="bi bi-info-circle text-blue-600 text-2xl mb-2 block"></i>
                            <p class="text-sm text-blue-700 font-medium">View Only</p>
                            <p class="text-xs text-blue-600 mt-1">You can view this report but cannot perform actions.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Decline Modal -->
    <div id="declineModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl p-6 max-w-md w-full shadow-xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="bi bi-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Decline Rabies Bite Report</h3>
                    <p class="text-sm text-gray-500">This action cannot be undone</p>
                </div>
            </div>
            <form action="{{ route($rabiesReportsDeclineRoute, $rabiesReport->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="decline_reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for declining</label>
                    <textarea id="decline_reason" name="decline_reason" rows="4" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
                              placeholder="Provide a reason for declining this report..."></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('declineModal').classList.add('hidden')"
                            class="px-6 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition">
                        Decline Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
