<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missing Pets - Dasmariñas City Veterinary Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            DEFAULT: '#066D33',
                            light: '#077a40',
                            dark: '#055a29',
                        },
                        secondary: {
                            DEFAULT: '#07A13F',
                            light: '#08b148',
                            dark: '#068c35',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .step-card {
            transition: all 0.3s ease;
        }
        .step-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(6, 109, 51, 0.15);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Government Logo -->
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('images/dasma logo.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900">Dasmariñas City Veterinary Services</h1>
                        <p class="text-sm text-gray-500">Official Veterinary Office of Dasmariñas City</p>
                    </div>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Home</a>
                    <a href="{{ url('/about-us') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">About Us</a>
                    <a href="{{ url('/services') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Services</a>
                    <a href="{{ url('/missing-pets') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Missing Pets</a>
                </nav>
                
                <!-- Login/Register Buttons or User Dropdown -->
                @auth
                    <!-- User Profile Dropdown for Logged In Users -->
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none">
                            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span class="text-primary font-medium hidden lg:block">{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 hidden lg:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                            <a href="{{ route('owner.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                            <hr class="my-2 border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Show Login/Register for Guests -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-primary font-medium hover:text-secondary transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-amber-500 min-h-[500px] flex items-center justify-center py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side: Title and Subtitle -->
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">Report your Missing Pets</h1>
                    <p class="text-lg md:text-xl text-white/90 max-w-xl mb-8">
                        Help reunite lost pets with their owners. Report missing pets quickly and reach out to the community for assistance.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ url('/missing-pets/form') }}" class="bg-white text-amber-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-colors">
                            Report a Missing Pet
                        </a>
                        <a href="#" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/20 transition-colors">
                            View Missing Pets
                        </a>
                    </div>
                </div>
                <!-- Right Side: Placeholder Image -->
                <div class="flex justify-center">
                    <div class="w-full max-w-lg aspect-square bg-white/10 rounded-2xl flex items-center justify-center border border-white/20">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-white/50 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <p class="text-white/70 text-lg">Missing Pets</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Title -->
    <section class="py-8 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Missing Pets</h2>
                    <p class="text-sm text-gray-500 mt-1">Help reunite these pets with their owners</p>
                </div>
                <button onclick="toggleFilterPanel()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span class="font-medium">Filters</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Slide-out Filter Panel -->
    <div id="filterPanel" class="fixed inset-y-0 right-0 w-80 bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="h-full flex flex-col">
            <!-- Panel Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h2 class="text-lg font-bold text-gray-900">Filter Pets</h2>
                <button onclick="toggleFilterPanel()" class="text-gray-400 hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Panel Content -->
            <div class="flex-1 overflow-y-auto p-4">
                <div class="space-y-4">
                    <p class="text-sm text-gray-500 mb-3">Filter by:</p>
                    
                    <button onclick="filterPets('filter', 'all')" class="filter-btn w-full px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-primary text-white text-left" data-filter="all" data-filter-type="filter">
                        All Pets
                    </button>
                    
                    <!-- Species filters side by side -->
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="filterPets('species', 'Dog')" class="filter-btn px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="Dog" data-filter-type="species">
                            🐕 Dogs
                        </button>
                        <button onclick="filterPets('species', 'Cat')" class="filter-btn px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="Cat" data-filter-type="species">
                            🐱 Cats
                        </button>
                    </div>
                    
                    <!-- Gender filters side by side -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-3">Gender:</p>
                        <div class="grid grid-cols-2 gap-3">
                            <button onclick="filterPets('gender', 'Male')" class="filter-btn gender-btn px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="Male" data-filter-type="gender">
                                ♂ Male
                            </button>
                            <button onclick="filterPets('gender', 'Female')" class="filter-btn gender-btn px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="Female" data-filter-type="gender">
                                ♀ Female
                            </button>
                        </div>
                    </div>
                    
                    <!-- Breed filter -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Breed:</p>
                        <div class="relative">
                            <button onclick="toggleBreedDropdown()" type="button" class="w-full px-3 py-2 text-left text-sm bg-gray-100 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary flex items-center justify-between" id="breed-dropdown-button">
                                <span id="selected-breeds-display">Select breeds</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="breed-dropdown" class="hidden absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-48 overflow-y-auto">
                                @if(isset($availableBreeds) && count($availableBreeds) > 0)
                                    @foreach($availableBreeds as $breed)
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" value="{{ $breed }}" class="breed-checkbox rounded text-primary focus:ring-primary" onchange="updateBreedSelection()">
                                        <span class="ml-2 text-sm text-gray-700">{{ $breed }}</span>
                                    </label>
                                    @endforeach
                                @else
                                    <div class="px-3 py-2 text-sm text-gray-500">No breeds available</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Location filter -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Last Seen Location:</p>
                        <div class="relative">
                            <button onclick="toggleLocationDropdown()" type="button" class="w-full px-3 py-2 text-left text-sm bg-gray-100 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary flex items-center justify-between" id="location-dropdown-button">
                                <span id="selected-locations-display">Select location</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="location-dropdown" class="hidden absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-48 overflow-y-auto">
                                @if(isset($availableLocations) && count($availableLocations) > 0)
                                    @foreach($availableLocations as $loc)
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" value="{{ $loc }}" class="location-checkbox rounded text-primary focus:ring-primary" onchange="updateLocationSelection()">
                                        <span class="ml-2 text-sm text-gray-700">{{ $loc }}</span>
                                    </label>
                                    @endforeach
                                @else
                                    <div class="px-3 py-2 text-sm text-gray-500">No locations available</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Current Filter Display -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Current filter:</span> 
                        <span id="currentFilterDisplay" class="text-primary font-bold">All Pets</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Showing <span id="pet-count">{{ $missingPets->total() }}</span> pets
                    </p>
                </div>
            </div>
            
            <!-- Panel Footer -->
            <div class="p-4 border-t border-gray-200">
                <div class="flex gap-3">
                    <button onclick="clearFilters()" class="flex-1 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                        Clear Filter
                    </button>
                    <button onclick="applyFilters()" class="flex-1 bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="filterOverlay" onclick="toggleFilterPanel()" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity"></div>

    <!-- Pets Grid -->
    <section id="pets-section" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="pets-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @forelse($missingPets as $pet)
                <button type="button" onclick="openPetModal({{ $pet->missing_id }})" class="bg-white rounded-xl shadow-lg overflow-hidden pet-card block text-left w-full">
                    <div class="aspect-square bg-gradient-to-br from-amber-400/20 to-amber-500/30 relative">
                        @if($pet->photo_img)
                            <img src="{{ asset($pet->photo_img) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-amber-500/40 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        @endif
                        <span class="absolute top-2 right-2 text-xs px-2 py-1 rounded-full bg-amber-100 text-amber-800">{{ $pet->species }}</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">{{ $pet->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $pet->breed }}</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs">
                            <span class="@if(strtolower($pet->gender) === 'female') text-pink-500 @else text-blue-500 @endif">{{ $pet->gender === 'Female' || $pet->gender === 'female' ? '♀' : '♂' }} {{ ucfirst($pet->gender) }}</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">{{ $pet->location ?? 'Location not available' }}</span>
                        </div>
                    </div>
                </button>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <p class="text-gray-500 text-lg">No missing pets found.</p>
                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters or check back later.</p>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center gap-1" id="pagination-nav">
                    <!-- Previous Page -->
                    @if ($missingPets->onFirstPage())
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                    @else
                        <button onclick="loadPage({{ $missingPets->currentPage() - 1 }})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                    @endif

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $missingPets->lastPage(); $i++)
                        @if ($i == $missingPets->currentPage())
                            <span class="px-4 py-2 text-white bg-primary font-medium rounded-lg">{{ $i }}</span>
                        @else
                            <button onclick="loadPage({{ $i }})" class="px-4 py-2 text-gray-600 bg-white hover:bg-primary hover:text-white rounded-lg transition-colors">{{ $i }}</button>
                        @endif
                    @endfor

                    <!-- Next Page -->
                    @if ($missingPets->hasMorePages())
                        <button onclick="loadPage({{ $missingPets->currentPage() + 1 }})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @else
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </section>

    <!-- Pet Detail Modal -->
    <div id="petModal" class="fixed inset-0 z-50 hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/50" onclick="closePetModal()"></div>
        <!-- Modal Content -->
        <div class="flex items-stretch justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl relative z-10 overflow-hidden flex flex-col md:flex-row">
                <button onclick="closePetModal()" class="absolute top-4 right-4 text-white hover:text-gray-200 z-20 bg-black/30 rounded-full p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <!-- Left Side - Image -->
                <div class="w-[370px] h-full bg-gradient-to-br from-amber-400/20 to-amber-500/30 relative overflow-hidden flex-shrink-0">
                    <img id="modalPetImage" src="" alt="" class="w-full h-full object-cover hidden">
                    <div id="modalPetImagePlaceholder" class="w-full h-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-amber-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
                <!-- Right Side - Details -->
                <div class="flex-1 p-6 md:p-8 flex flex-col justify-center">
                    <div class="flex items-center justify-between mb-2">
                        <h2 id="modalPetName" class="text-2xl md:text-3xl font-bold text-gray-900"></h2>
                        <span id="modalPetSpecies" class="text-base text-gray-500"></span>
                    </div>
                    <p id="modalPetBreed" class="text-lg text-primary font-semibold mb-4"></p>
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Age</span>
                            <span id="modalPetAge" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Gender</span>
                            <span id="modalPetGender" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Weight</span>
                            <span id="modalPetWeight" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Color</span>
                            <span id="modalPetColor" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Last Seen</span>
                            <span id="modalPetLocation" class="font-medium text-gray-900"></span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Last Seen Date</span>
                            <span id="modalPetLastSeen" class="font-medium text-gray-900"></span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-900 mb-1">Description</h3>
                        <p id="modalPetDescription" class="text-gray-600 text-sm"></p>
                    </div>
                    <button class="w-full bg-amber-500 text-white text-center px-6 py-3 rounded-xl font-semibold hover:bg-amber-600 transition-colors mt-auto">
                        Contact Owner
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let missingPetsData = {!! json_encode($missingPets->map(function($pet) { return [ 'missing_id' => $pet->missing_id, 'name' => $pet->name, 'species' => $pet->species, 'breed' => $pet->breed, 'gender' => $pet->gender, 'age' => $pet->age, 'weight' => $pet->weight, 'color' => $pet->color, 'description' => $pet->description, 'location' => $pet->location, 'last_seen_at' => $pet->last_seen_at, 'photo_img' => $pet->photo_img ? asset($pet->photo_img) : null ]; })) !!};
        let currentPage = {{ $missingPets->currentPage() }};
        let lastPage = {{ $missingPets->lastPage() }};
        let currentSpecies = 'all';
        let currentGender = 'all';
        let currentBreeds = [];
        let currentLocations = [];
        let currentModalPetId = null;

        // Check for filter parameters in URL on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const speciesParam = urlParams.get('species');
            const genderParam = urlParams.get('gender');
            const breedsParam = urlParams.get('breeds');
            const locationParam = urlParams.get('location');
            
            if (speciesParam && ['Dog', 'Cat'].includes(speciesParam)) {
                currentSpecies = speciesParam;
            }
            if (genderParam && ['Male', 'Female'].includes(genderParam)) {
                currentGender = genderParam;
            }
            if (breedsParam) {
                currentBreeds = breedsParam.split(',');
                document.querySelectorAll('.breed-checkbox').forEach(checkbox => {
                    checkbox.checked = currentBreeds.includes(checkbox.value);
                });
                updateBreedSelection();
            }
            if (locationParam) {
                currentLocations = locationParam.split(',');
                document.querySelectorAll('.location-checkbox').forEach(checkbox => {
                    checkbox.checked = currentLocations.includes(checkbox.value);
                });
                updateLocationSelection();
            }
            updateFilterButtons();
        });
        
        function updateFilterButtons() {
            document.querySelectorAll('.filter-btn').forEach(btn => {
                const filterType = btn.dataset.filterType || 'filter';
                const filterValue = btn.dataset.filter;
                
                let isActive = false;
                
                if (filterType === 'filter') {
                    // "All Pets" is active only when no species filter is selected
                    isActive = filterValue === 'all' && currentSpecies === 'all';
                } else if (filterType === 'species') {
                    isActive = currentSpecies !== 'all' && currentSpecies === filterValue;
                } else if (filterType === 'gender') {
                    isActive = currentGender !== 'all' && currentGender === filterValue;
                }
                
                if (isActive) {
                    btn.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                    
                    if (filterValue === 'Male') {
                        btn.classList.add('bg-blue-300', 'text-blue-900', 'ring-2', 'ring-blue-400');
                    } else if (filterValue === 'Female') {
                        btn.classList.add('bg-pink-200', 'text-pink-900', 'ring-2', 'ring-pink-300');
                    } else {
                        btn.classList.add('bg-primary', 'text-white', 'ring-2', 'ring-green-400');
                    }
                } else {
                    btn.classList.remove('bg-primary', 'text-white', 'bg-blue-300', 'text-blue-900', 'ring-2', 'ring-blue-400', 'bg-pink-200', 'text-pink-900', 'ring-pink-300', 'ring-green-400');
                    btn.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                }
            });
            
            // Update current filter display
            const filterNames = {
                'all': 'All Pets',
                'Dog': 'Dogs',
                'Cat': 'Cats',
                'Male': 'Male',
                'Female': 'Female',
            };
            
            let activeFilters = [];
            if (currentSpecies !== 'all') activeFilters.push(filterNames[currentSpecies] || currentSpecies);
            if (currentGender !== 'all') activeFilters.push(filterNames[currentGender] || currentGender);
            if (currentBreeds.length > 0) {
                activeFilters.push(currentBreeds.length === 1 ? currentBreeds[0] : currentBreeds.length + ' breeds');
            }
            if (currentLocations.length > 0) {
                activeFilters.push(currentLocations.length === 1 ? currentLocations[0] : currentLocations.length + ' locations');
            }
            
            const displayEl = document.getElementById('currentFilterDisplay');
            if (displayEl) {
                displayEl.textContent = activeFilters.length > 0 ? activeFilters.join(', ') : 'All Pets';
            }
        }
        
        function toggleFilterPanel() {
            const panel = document.getElementById('filterPanel');
            const overlay = document.getElementById('filterOverlay');
            
            if (!panel || !overlay) return;
            
            if (panel.classList.contains('translate-x-full')) {
                panel.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                document.body.style.overflow = 'hidden';
            } else {
                panel.classList.add('translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
                document.body.style.overflow = 'auto';
            }
        }
        
        function toggleBreedDropdown() {
            const dropdown = document.getElementById('breed-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        function toggleLocationDropdown() {
            const dropdown = document.getElementById('location-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        function updateBreedSelection() {
            const checkboxes = document.querySelectorAll('.breed-checkbox:checked');
            currentBreeds = Array.from(checkboxes).map(cb => cb.value);
            const display = document.getElementById('selected-breeds-display');
            display.textContent = currentBreeds.length > 0 ? currentBreeds.join(', ') : 'Select breeds';
        }
        
        function updateLocationSelection() {
            const checkboxes = document.querySelectorAll('.location-checkbox:checked');
            currentLocations = Array.from(checkboxes).map(cb => cb.value);
            const display = document.getElementById('selected-locations-display');
            display.textContent = currentLocations.length > 0 ? currentLocations.join(', ') : 'Select location';
        }
        
        function filterPets(filterType, filterValue) {
            if (filterType === 'filter') {
                // Reset species filter when clicking "All Pets"
                if (filterValue === 'all') {
                    currentSpecies = 'all';
                }
            } else if (filterType === 'species') {
                if (currentSpecies !== 'all' && currentSpecies === filterValue) {
                    currentSpecies = 'all';
                } else {
                    currentSpecies = filterValue;
                }
            } else if (filterType === 'gender') {
                if (currentGender !== 'all' && currentGender === filterValue) {
                    currentGender = 'all';
                } else {
                    currentGender = filterValue;
                }
            }
            updateFilterButtons();
        }
        
        function clearFilters() {
            currentSpecies = 'all';
            currentGender = 'all';
            currentBreeds = [];
            currentLocations = [];
            
            document.querySelectorAll('.breed-checkbox').forEach(cb => cb.checked = false);
            document.querySelectorAll('.location-checkbox').forEach(cb => cb.checked = false);
            
            document.getElementById('selected-breeds-display').textContent = 'Select breeds';
            document.getElementById('selected-locations-display').textContent = 'Select location';
            
            updateFilterButtons();
            window.location.href = '/missing-pets?page=1';
        }
        
        function applyFilters() {
            loadPage(1);
            
            const panel = document.getElementById('filterPanel');
            const overlay = document.getElementById('filterOverlay');
            panel.classList.add('translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
            document.body.style.overflow = 'auto';
        }
        
        function loadPage(page, species = null, gender = null, breeds = null, locations = null) {
            const speciesParam = species || currentSpecies;
            const genderParam = gender || currentGender;
            const breedsParam = breeds || (currentBreeds.length > 0 ? currentBreeds.join(',') : '');
            const locationsParam = locations || (currentLocations.length > 0 ? currentLocations.join(',') : '');
            
            let url = '/missing-pets/paginate?page=' + page;
            
            if (speciesParam && speciesParam !== 'all') {
                url += '&species=' + speciesParam;
            }
            if (genderParam && genderParam !== 'all') {
                url += '&gender=' + genderParam;
            }
            if (breedsParam) {
                url += '&breeds=' + breedsParam;
            }
            if (locationsParam) {
                url += '&location=' + locationsParam;
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    missingPetsData = data.pets;
                    currentPage = data.currentPage;
                    lastPage = data.lastPage;
                    
                    document.getElementById('pet-count').textContent = data.total;
                    
                    renderPets(data.pets);
                    renderPagination();
                    
                    document.getElementById('pets-section').scrollIntoView({ behavior: 'smooth' });
                })
                .catch(error => {
                    console.error('Error loading page:', error);
                    alert('Error loading pets. Please try again.');
                });
        }
        
        function renderPets(pets) {
            const grid = document.getElementById('pets-grid');
            let html = '';
            
            if (pets.length === 0) {
                html = `
                <div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <p class="text-gray-500 text-lg">No missing pets found.</p>
                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters or check back later.</p>
                </div>`;
            } else {
                pets.forEach(pet => {
                    const genderClass = pet.gender && pet.gender.toLowerCase() === 'female' ? 'text-pink-500' : 'text-blue-500';
                    const genderSymbol = pet.gender && pet.gender.toLowerCase() === 'female' ? '♀' : '♂';
                    
                    html += `
                    <button type="button" onclick="openPetModal(${pet.missing_id})" class="bg-white rounded-xl shadow-lg overflow-hidden pet-card block text-left w-full">
                        <div class="aspect-square bg-gradient-to-br from-amber-400/20 to-amber-500/30 relative">
                            ${pet.photo_img 
                                ? `<img src="${pet.photo_img}" alt="${pet.name}" class="w-full h-full object-cover">`
                                : `<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-amber-500/40 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>`
                            }
                            <span class="absolute top-2 right-2 text-xs px-2 py-1 rounded-full bg-amber-100 text-amber-800">${pet.species}</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900">${pet.name}</h3>
                            <p class="text-sm text-gray-500">${pet.breed || 'Breed not available'}</p>
                            <div class="flex items-center space-x-3 mt-2 text-xs">
                                <span class="${genderClass}">${genderSymbol} ${pet.gender}</span>
                                <span class="text-gray-400">•</span>
                                <span class="text-gray-600">${pet.location || 'Location not available'}</span>
                            </div>
                        </div>
                    </button>`;
                });
            }
            
            grid.innerHTML = html;
        }
        
        function renderPagination() {
            const nav = document.getElementById('pagination-nav');
            let html = '';
            
            // Previous button
            if (currentPage === 1) {
                html += `<span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>`;
            } else {
                html += `<button onclick="loadPage(${currentPage - 1})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>`;
            }
            
            // Page numbers
            for (let i = 1; i <= lastPage; i++) {
                if (i === currentPage) {
                    html += `<span class="px-4 py-2 text-white bg-primary font-medium rounded-lg">${i}</span>`;
                } else {
                    html += `<button onclick="loadPage(${i})" class="px-4 py-2 text-gray-600 bg-white hover:bg-primary hover:text-white rounded-lg transition-colors">${i}</button>`;
                }
            }
            
            // Next button
            if (currentPage === lastPage) {
                html += `<span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </span>`;
            } else {
                html += `<button onclick="loadPage(${currentPage + 1})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>`;
            }
            
            nav.innerHTML = html;
        }
        
        function openPetModal(petId) {
            const pet = missingPetsData.find(p => p.missing_id === petId);
            if (!pet) return;
            
            currentModalPetId = petId;
            
            document.getElementById('modalPetName').textContent = pet.name;
            document.getElementById('modalPetSpecies').textContent = pet.species;
            document.getElementById('modalPetBreed').textContent = pet.breed || 'Breed not available';
            document.getElementById('modalPetAge').textContent = pet.age || 'Age not available';
            document.getElementById('modalPetGender').textContent = pet.gender ? pet.gender.charAt(0).toUpperCase() + pet.gender.slice(1).toLowerCase() : 'Not available';
            document.getElementById('modalPetWeight').textContent = pet.weight ? pet.weight + ' kg' : 'Weight not available';
            document.getElementById('modalPetColor').textContent = pet.color || 'Color not available';
            document.getElementById('modalPetLocation').textContent = pet.location || 'Location not available';
            document.getElementById('modalPetLastSeen').textContent = pet.last_seen_at ? new Date(pet.last_seen_at).toLocaleDateString() : 'Date not available';
            document.getElementById('modalPetDescription').textContent = pet.description || 'No description available';
            
            const img = document.getElementById('modalPetImage');
            const placeholder = document.getElementById('modalPetImagePlaceholder');
            
            if (pet.photo_img) {
                img.src = pet.photo_img;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                img.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
            
            document.getElementById('petModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closePetModal() {
            document.getElementById('petModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentModalPetId = null;
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const breedDropdown = document.getElementById('breed-dropdown');
            const breedButton = event.target.closest('#breed-dropdown-button');
            if (!breedButton && breedDropdown && !breedDropdown.contains(event.target)) {
                breedDropdown.classList.add('hidden');
            }
            
            const locationDropdown = document.getElementById('location-dropdown');
            const locationButton = event.target.closest('#location-dropdown-button');
            if (!locationButton && locationDropdown && !locationDropdown.contains(event.target)) {
                locationDropdown.classList.add('hidden');
            }
        });
    </script>

    <!-- Footer -->
    <footer class="bg-white text-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('images/dasma logo.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Dasmariñas City</h3>
                            <p class="text-sm text-gray-500">Veterinary Services</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Promoting responsible pet ownership and protecting public health since 2010.</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-600 hover:text-primary transition-colors">Home</a></li>
                        <li><a href="{{ url('/about-us') }}" class="text-gray-600 hover:text-primary transition-colors">About Us</a></li>
                        <li><a href="{{ url('/services') }}" class="text-gray-600 hover:text-primary transition-colors">Services</a></li>
                        <li><a href="{{ url('/missing-pets') }}" class="text-gray-600 hover:text-primary transition-colors">Missing Pets</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/pet-registration') }}" class="text-gray-600 hover:text-primary transition-colors">Pet Registration</a></li>
                        <li><a href="{{ url('/vaccination') }}" class="text-gray-600 hover:text-primary transition-colors">Anti-Rabies Vaccination</a></li>
                        <li><a href="{{ url('/adoption') }}" class="text-gray-600 hover:text-primary transition-colors">Adoption</a></li>
                        <li><a href="{{ url('/kapon') }}" class="text-gray-600 hover:text-primary transition-colors">Kapon Program</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Contact Us</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-600 text-sm">Brgy. Langkaan 2, Sitio Buwisan, Dasmariñas City, Cavite</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-600 text-sm">0966-881-2010</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-600 text-sm">vetdasma@yahoo.com</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-600 text-sm">Mon-Fri: 8AM - 5PM</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-500 text-sm">© 2025 Dasmariñas City Veterinary Services. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="sr-only">Facebook</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-primary transition-colors">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('userDropdown');
            const button = event.target.closest('button');
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
