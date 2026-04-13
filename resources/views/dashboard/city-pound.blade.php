@extends('layouts.admin')

@section('title', 'City Pound Dashboard')

@section('header', 'City Pound')
@section('subheader', 'Animal impoundment and adoption')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-orange-600 to-red-700 rounded-xl p-6 mb-8 text-white">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-2">City Pound Portal</h2>
            <p class="text-orange-100">Managing animal impoundment and adoption.</p>
        </div>
        <div class="hidden md:block">
            <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                <i class="bi bi-box-seam text-4xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Impounds</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\ImpoundRecord::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-box-seam text-orange-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Adoptions</p>
                <p class="text-2xl font-bold text-green-600">{{ \App\Models\AdoptionRequest::where('status', 'approved')->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-heart text-green-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Strays</p>
                <p class="text-2xl font-bold text-gray-800">{{ \App\Models\StrayReport::count() }}</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-currency-dollar text-yellow-600"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500">Released</p>
                <p class="text-2xl font-bold text-blue-600">{{ \App\Models\ImpoundRecord::where('status', 'released')->count() }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-box-arrow-right text-blue-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="#" class="flex flex-col items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-orange-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-plus-circle text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">New Impound</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-heart text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Adoptions</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-yellow-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-currency-dollar text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Stray Reports</span>
        </a>

        <a href="#" class="flex flex-col items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition group">
            <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-2 group-hover:scale-110 transition">
                <i class="bi bi-file-earmark-bar-graph text-white text-xl"></i>
            </div>
            <span class="text-sm font-medium text-gray-700">Reports</span>
        </a>
    </div>
</div>

<!-- Impound Status Summary -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Impound Status</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-orange-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-box-seam text-orange-600"></i>
                    <span class="text-sm text-gray-700">Impounded</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\ImpoundRecord::where('status', 'impounded')->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-heart text-green-600"></i>
                    <span class="text-sm text-gray-700">Adopted</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\ImpoundRecord::where('status', 'adopted')->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-box-arrow-right text-blue-600"></i>
                    <span class="text-sm text-gray-700">Released</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\ImpoundRecord::where('status', 'released')->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-x-circle text-red-600"></i>
                    <span class="text-sm text-gray-700">Disposed</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\ImpoundRecord::where('status', 'disposed')->count() }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Adoption Requests</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-clock text-yellow-600"></i>
                    <span class="text-sm text-gray-700">Pending</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\AdoptionRequest::where('status', 'pending')->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-arrow-repeat text-blue-600"></i>
                    <span class="text-sm text-gray-700">Processing</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\AdoptionRequest::where('status', 'processing')->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle text-green-600"></i>
                    <span class="text-sm text-gray-700">Approved</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\AdoptionRequest::where('status', 'approved')->count() }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div class="flex items-center gap-3">
                    <i class="bi bi-x-circle text-red-600"></i>
                    <span class="text-sm text-gray-700">Rejected</span>
                </div>
                <span class="font-semibold text-gray-800">{{ \App\Models\AdoptionRequest::where('status', 'rejected')->count() }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
