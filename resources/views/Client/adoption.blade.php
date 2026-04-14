<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt a Pet - Dasmariñas City Veterinary Services</title>
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
        .pet-card {
            transition: all 0.3s ease;
        }
        .pet-card:hover {
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
    <section class="bg-[#066D33] min-h-[600px] flex items-center justify-center py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side: Title, Subtitle, and Instructions -->
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">Adopt a Companion Animal</h1>
                    <p class="text-lg md:text-xl text-gray-200 max-w-xl mb-8">
                        You can help Dasmariñas City Veterinary Services by giving a permanent loving home to one of our shelter animals. Adopt, don't shop!
                    </p>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 border border-white/20">
                        <h2 class="text-xl font-semibold text-white mb-4">How to Adopt</h2>
                        <div class="space-y-3">
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">1</span>
                                <p class="text-white">Browse through our list of animals currently available for adoption</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">2</span>
                                <p class="text-white">Read the requirements for adoption below</p>
                            </div>
                            <div class="flex items-start space-x-3">
                                <span class="bg-white text-[#066D33] rounded-full w-7 h-7 flex items-center justify-center text-sm font-bold flex-shrink-0">3</span>
                                <p class="text-white">If you are qualified and interested, you may set an appointment with us to meet the animal</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="{{ url('/adoption/form') }}" class="bg-white text-[#066D33] px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-colors">
                            Apply Now
                        </a>
                        <a href="#" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-white/20 transition-colors">
                            Adoption FAQ
                        </a>
                    </div>
                </div>
                <!-- Right Side: Placeholder Image -->
                <div class="flex justify-center">
                    <div class="w-full max-w-lg aspect-square bg-white/10 rounded-2xl flex items-center justify-center border border-white/20">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-white/50 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <p class="text-white/70 text-lg">Pet Image Placeholder</p>
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
                    <h2 class="text-2xl font-bold text-gray-900">Available Pets</h2>
                    <p class="text-sm text-gray-500 mt-1">Find your perfect companion</p>
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
                    
                    <!-- Age filters -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-3">Age:</p>
                        <div class="space-y-2">
                            <div class="grid grid-cols-2 gap-2">
                                <button onclick="filterPets('age', '0-6')" class="filter-btn age-btn px-3 py-2 rounded-lg text-xs font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="0-6" data-filter-type="age">
                                    🐾 0–6 months
                                </button>
                                <button onclick="filterPets('age', '6-12')" class="filter-btn age-btn px-3 py-2 rounded-lg text-xs font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="6-12" data-filter-type="age">
                                    🐾 6–12 months
                                </button>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <button onclick="filterPets('age', '1-3')" class="filter-btn age-btn px-3 py-2 rounded-lg text-xs font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="1-3" data-filter-type="age">
                                    🐾 1–3 years
                                </button>
                                <button onclick="filterPets('age', '3+')" class="filter-btn age-btn px-3 py-2 rounded-lg text-xs font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="3+" data-filter-type="age">
                                    🐾 3+ years
                                </button>
                            </div>
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
                    
                    <!-- Traits filter -->
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Traits:</p>
                        <div class="relative">
                            <button onclick="toggleTraitsDropdown()" type="button" class="w-full px-3 py-2 text-left text-sm bg-gray-100 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary flex items-center justify-between" id="traits-dropdown-button">
                                <span id="selected-traits-display">Select traits</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="traits-dropdown" class="hidden absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-48 overflow-y-auto">
                                @if(isset($availableTraits) && count($availableTraits) > 0)
                                    @foreach($availableTraits as $trait)
                                    <label class="flex items-center px-3 py-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" value="{{ $trait }}" class="trait-checkbox rounded text-primary focus:ring-primary" onchange="updateTraitsSelection()">
                                        <span class="ml-2 text-sm text-gray-700">{{ $trait }}</span>
                                    </label>
                                    @endforeach
                                @else
                                    <div class="px-3 py-2 text-sm text-gray-500">No traits available</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @auth
                        @if($hasPets ?? false)
                    <button onclick="filterPets('filter', 'recommended')" class="filter-btn w-full px-4 py-3 rounded-lg text-sm font-medium transition-colors bg-gray-100 text-gray-600 hover:bg-gray-200 text-left" data-filter="recommended" data-filter-type="filter">
                        ⭐ Recommended for You
                    </button>
                        @endif
                    @endauth
                </div>
                
                <!-- Current Filter Display -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Current filter:</span> 
                        <span id="currentFilterDisplay" class="text-primary font-bold">All Pets</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Showing <span id="pet-count">{{ $adoptionPets->total() }}</span> pets
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
                @forelse($adoptionPets as $pet)
                <button type="button" onclick="openPetModal({{ $pet->adoption_id }})" class="bg-white rounded-xl shadow-lg overflow-hidden pet-card block text-left w-full">
                    <div class="aspect-square bg-gradient-to-br from-pink-400/20 to-pink-500/30 relative">
                        @if($pet->image)
                            <img src="{{ asset($pet->image) }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-pink-500/40 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        @endif
                        <span class="absolute top-2 right-2 text-xs px-2 py-1 rounded-full bg-[#E6F4EA] text-gray-800">{{ $pet->species }}</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">{{ $pet->pet_name }}</h3>
                        <p class="text-sm text-gray-500">{{ $pet->breed }}</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs">
                            <span class="@if($pet->gender === 'Female') text-pink-500 @else text-blue-500 @endif">{{ $pet->gender === 'Female' ? '♀' : '♂' }} {{ $pet->gender }}</span>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">{{ $pet->age ?? 'Age not available' }}</span>
                        </div>
                    </div>
                </button>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <p class="text-gray-500 text-lg">No pets found.</p>
                    <p class="text-gray-400 text-sm mt-1">Try adjusting your filters or check back later.</p>
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                <nav class="flex items-center gap-1" id="pagination-nav">
                    <!-- Previous Page -->
                    @if ($adoptionPets->onFirstPage())
                        <span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                    @else
                        <button onclick="loadPage({{ $adoptionPets->currentPage() - 1 }})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                    @endif

                    <!-- Page Numbers -->
                    @for ($i = 1; $i <= $adoptionPets->lastPage(); $i++)
                        @if ($i == $adoptionPets->currentPage())
                            <span class="px-4 py-2 text-white bg-primary font-medium rounded-lg">{{ $i }}</span>
                        @else
                            <button onclick="loadPage({{ $i }})" class="px-4 py-2 text-gray-600 bg-white hover:bg-primary hover:text-white rounded-lg transition-colors">{{ $i }}</button>
                        @endif
                    @endfor

                    <!-- Next Page -->
                    @if ($adoptionPets->hasMorePages())
                        <button onclick="loadPage({{ $adoptionPets->currentPage() + 1 }})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
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
                <div class="w-[370px] h-full bg-gradient-to-br from-pink-400/20 to-pink-500/30 relative overflow-hidden flex-shrink-0">
                    <img id="modalPetImage" src="" alt="" class="w-full h-full object-cover hidden">
                    <div id="modalPetImagePlaceholder" class="w-full h-full flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-pink-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
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
                    </div>
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-900 mb-1">Description</h3>
                        <p id="modalPetDescription" class="text-gray-600 text-sm"></p>
                    </div>
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-900 mb-2">Traits</h3>
                        <span id="modalPetTraits" class="bg-primary/10 text-primary px-3 py-1 rounded-full text-sm font-medium"></span>
                    </div>
                    <button id="modalPetAdoptBtn" onclick="proceedToAdoption()" class="w-full bg-primary text-white text-center px-6 py-3 rounded-xl font-semibold hover:bg-primary-light transition-colors mt-auto">
                        Adopt
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let adoptionPets = {!! json_encode($adoptionPets->map(function($pet) { return [ 'adoption_id' => $pet->adoption_id, 'pet_name' => $pet->pet_name, 'species' => $pet->species, 'breed' => $pet->breed, 'gender' => $pet->gender, 'age' => $pet->age, 'date_of_birth' => $pet->date_of_birth, 'is_age_estimated' => $pet->is_age_estimated, 'weight' => $pet->weight, 'description' => $pet->description, 'traits' => $pet->traits->pluck('name')->toArray(), 'image' => $pet->image ]; })) !!};
        let currentPage = {{ $adoptionPets->currentPage() }};
        let lastPage = {{ $adoptionPets->lastPage() }};
        let currentFilter = 'all';
        let currentSpecies = 'all';
        let currentGender = 'all';
        let currentAge = 'all';
        let currentBreeds = [];
        let currentTraits = [];
        let currentModalPetId = null;

        function proceedToAdoption() {
            const petId = currentModalPetId;
            window.location.href = '/adoption/form?pet_id=' + petId;
        }

        // Check for filter parameters in URL on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const filterParam = urlParams.get('filter');
            const speciesParam = urlParams.get('species');
            const genderParam = urlParams.get('gender');
            const ageParam = urlParams.get('age');
            const breedsParam = urlParams.get('breeds');
            const traitsParam = urlParams.get('traits');
            
            if (filterParam && ['all', 'Dog', 'Cat', 'recommended'].includes(filterParam)) {
                currentFilter = filterParam;
            }
            if (speciesParam && ['Dog', 'Cat'].includes(speciesParam)) {
                currentSpecies = speciesParam;
            }
            if (genderParam && ['Male', 'Female'].includes(genderParam)) {
                currentGender = genderParam;
            }
            if (ageParam && ['0-6', '6-12', '1-3', '3+'].includes(ageParam)) {
                currentAge = ageParam;
            }
            if (breedsParam) {
                currentBreeds = breedsParam.split(',');
                // Check the checkboxes
                document.querySelectorAll('.breed-checkbox').forEach(checkbox => {
                    checkbox.checked = currentBreeds.includes(checkbox.value);
                });
                updateBreedSelection();
            }
            if (traitsParam) {
                currentTraits = traitsParam.split(',');
                // Check the checkboxes
                document.querySelectorAll('.trait-checkbox').forEach(checkbox => {
                    checkbox.checked = currentTraits.includes(checkbox.value);
                });
                updateTraitsSelection();
            }
            updateFilterButtons();
        });
        
        function updateFilterButtons() {
            // Update special filters (All Pets, Recommended)
            document.querySelectorAll('.filter-btn').forEach(btn => {
                const filterType = btn.dataset.filterType || 'filter';
                const filterValue = btn.dataset.filter;
                
                let isActive = false;
                
                if (filterType === 'filter') {
                    // For "All Pets" - highlight when no species filter is selected
                    if (filterValue === 'all') {
                        isActive = currentSpecies === 'all';
                    } else {
                        // Other filters like "recommended" - highlight when explicitly selected
                        isActive = currentFilter === filterValue;
                    }
                } else if (filterType === 'species') {
                    isActive = currentSpecies !== 'all' && currentSpecies === filterValue;
                } else if (filterType === 'gender') {
                    isActive = currentGender !== 'all' && currentGender === filterValue;
                } else if (filterType === 'age') {
                    isActive = currentAge !== 'all' && currentAge === filterValue;
                }
                
                if (isActive) {
                    btn.classList.remove('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                    
                    // Gender-specific colors
                    if (filterValue === 'Male') {
                        btn.classList.add('bg-blue-300', 'text-blue-900', 'ring-2', 'ring-blue-400');
                    } else if (filterValue === 'Female') {
                        btn.classList.add('bg-pink-200', 'text-pink-900', 'ring-2', 'ring-pink-300');
                    } else {
                        btn.classList.add('bg-primary', 'text-white', 'ring-2', 'ring-green-400');
                    }
                } else {
                    // Remove all highlight classes
                    btn.classList.remove('bg-primary', 'text-white', 'bg-blue-300', 'text-blue-900', 'ring-2', 'ring-blue-400', 'bg-pink-200', 'text-pink-900', 'ring-pink-300', 'ring-green-400');
                    btn.classList.add('bg-gray-100', 'text-gray-600', 'hover:bg-gray-200');
                }
            });
            
            // Update current filter display in panel
            const filterNames = {
                'all': 'All Pets',
                'Dog': 'Dogs',
                'Cat': 'Cats',
                'recommended': 'Recommended for You',
                'Male': 'Male',
                'Female': 'Female',
                '0-6': '0–6 months',
                '6-12': '6–12 months',
                '1-3': '1–3 years',
                '3+': '3+ years'
            };
            
            let activeFilters = [];
            if (currentFilter !== 'all') activeFilters.push(filterNames[currentFilter] || currentFilter);
            if (currentSpecies !== 'all') activeFilters.push(filterNames[currentSpecies] || currentSpecies);
            if (currentGender !== 'all') activeFilters.push(filterNames[currentGender] || currentGender);
            if (currentAge !== 'all') activeFilters.push(filterNames[currentAge] || currentAge);
            if (currentBreeds.length > 0) {
                if (currentBreeds.length === 1) {
                    activeFilters.push(currentBreeds[0]);
                } else {
                    activeFilters.push(currentBreeds.length + ' breeds');
                }
            }
            if (currentTraits.length > 0) {
                if (currentTraits.length === 1) {
                    activeFilters.push(currentTraits[0]);
                } else {
                    activeFilters.push(currentTraits.length + ' traits');
                }
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
                // Open panel
                panel.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.remove('opacity-0'), 10);
                document.body.style.overflow = 'hidden';
            } else {
                // Close panel
                panel.classList.add('translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(() => overlay.classList.add('hidden'), 300);
                document.body.style.overflow = 'auto';
            }
        }
        
        function filterPets(filterType, filterValue) {
            // Check if we're clicking on an already active filter - if so, deselect it
            let shouldDeselect = false;
            
            if (filterType === 'filter') {
                if (currentFilter !== 'all' && currentFilter === filterValue) {
                    currentFilter = 'all';
                    shouldDeselect = true;
                } else {
                    currentFilter = filterValue;
                }
            } else if (filterType === 'species') {
                if (currentSpecies !== 'all' && currentSpecies === filterValue) {
                    currentSpecies = 'all';
                    shouldDeselect = true;
                } else {
                    currentSpecies = filterValue;
                }
            } else if (filterType === 'gender') {
                if (currentGender !== 'all' && currentGender === filterValue) {
                    currentGender = 'all';
                    shouldDeselect = true;
                } else {
                    currentGender = filterValue;
                }
            } else if (filterType === 'age') {
                if (currentAge !== 'all' && currentAge === filterValue) {
                    currentAge = 'all';
                    shouldDeselect = true;
                } else {
                    currentAge = filterValue;
                }
            }
            
            // Update button highlights - don't auto-apply
            updateFilterButtons();
        }
        
        function clearFilters() {
            // Reset all filter variables
            currentFilter = 'all';
            currentSpecies = 'all';
            currentGender = 'all';
            currentAge = 'all';
            currentBreeds = [];
            currentTraits = [];
            
            // Uncheck all filter checkboxes
            document.querySelectorAll('.species-checkbox').forEach(cb => cb.checked = false);
            document.querySelectorAll('.gender-checkbox').forEach(cb => cb.checked = false);
            document.querySelectorAll('.age-checkbox').forEach(cb => cb.checked = false);
            document.querySelectorAll('.breed-checkbox').forEach(cb => cb.checked = false);
            document.querySelectorAll('.trait-checkbox').forEach(cb => cb.checked = false);
            
            // Reset all dropdown displays
            const speciesDisplay = document.getElementById('selected-species-display');
            if (speciesDisplay) speciesDisplay.textContent = 'Select species';
            
            const genderDisplay = document.getElementById('selected-gender-display');
            if (genderDisplay) genderDisplay.textContent = 'Select gender';
            
            const ageDisplay = document.getElementById('selected-age-display');
            if (ageDisplay) ageDisplay.textContent = 'Select age';
            
            const breedsDisplay = document.getElementById('selected-breeds-display');
            if (breedsDisplay) breedsDisplay.textContent = 'Select breeds';
            
            const traitsDisplay = document.getElementById('selected-traits-display');
            if (traitsDisplay) traitsDisplay.textContent = 'Select traits';
            
            // Update filter buttons
            updateFilterButtons();
            
            // Load page 1 with no filters
            window.location.href = '/adoption?page=1';
        }
        
        function applyFilters() {
            // Apply all current filters and close panel
            loadPage(1);
            
            const panel = document.getElementById('filterPanel');
            const overlay = document.getElementById('filterOverlay');
            panel.classList.add('translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
            document.body.style.overflow = 'auto';
        }
        
        function loadPage(page, filter = null, species = null, gender = null, age = null, breeds = null, traits = null) {
            const filterParam = filter || currentFilter;
            const speciesParam = species || currentSpecies;
            const genderParam = gender || currentGender;
            const ageParam = age || currentAge;
            const breedsParam = breeds || (currentBreeds.length > 0 ? currentBreeds.join(',') : '');
            const traitsParam = traits || (currentTraits.length > 0 ? currentTraits.join(',') : '');
            
            let url = '/adoption/paginate?page=' + page;
            
            if (filterParam && filterParam !== 'all') {
                url += '&filter=' + filterParam;
            }
            if (speciesParam && speciesParam !== 'all') {
                url += '&species=' + speciesParam;
            }
            if (genderParam && genderParam !== 'all') {
                url += '&gender=' + genderParam;
            }
            if (ageParam && ageParam !== 'all') {
                url += '&age=' + ageParam;
            }
            if (breedsParam) {
                url += '&breeds=' + breedsParam;
            }
            if (traitsParam) {
                url += '&traits=' + traitsParam;
            }
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Update pets data
                    adoptionPets = data.pets;
                    currentPage = data.currentPage;
                    lastPage = data.lastPage;
                    
                    // Update pet count
                    document.getElementById('pet-count').textContent = data.total;
                    
                    // Render new pets
                    renderPets(data.pets);
                    
                    // Render pagination
                    renderPagination();
                    
                    // Scroll to pets section
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
                // Generate dynamic message based on active filters
                const filterNames = {
                    'all': 'All Pets',
                    'Dog': 'Dogs',
                    'Cat': 'Cats',
                    'recommended': 'recommended',
                    'Male': 'male',
                    'Female': 'female',
                    '0-6': '0–6 months',
                    '6-12': '6–12 months',
                    '1-3': '1–3 years',
                    '3+': '3+ years'
                };
                
                let activeFilters = [];
                let filterMessage = '';
                
                // Check which filters are active
                if (currentFilter !== 'all' && currentFilter !== 'Dog' && currentFilter !== 'Cat') {
                    // Special filters like 'recommended'
                    if (currentFilter === 'recommended') {
                        activeFilters.push('recommended');
                    }
                }
                if (currentSpecies !== 'all') {
                    activeFilters.push('species: ' + filterNames[currentSpecies] || currentSpecies);
                }
                if (currentGender !== 'all') {
                    activeFilters.push('gender: ' + filterNames[currentGender] || currentGender);
                }
                if (currentAge !== 'all') {
                    activeFilters.push('age: ' + (filterNames[currentAge] || currentAge));
                }
                if (currentBreeds.length > 0) {
                    if (currentBreeds.length === 1) {
                        activeFilters.push('breed: ' + currentBreeds[0]);
                    } else {
                        activeFilters.push('breed: ' + currentBreeds.join(', '));
                    }
                }
                if (currentTraits.length > 0) {
                    if (currentTraits.length === 1) {
                        activeFilters.push('trait: ' + currentTraits[0]);
                    } else {
                        activeFilters.push('traits: ' + currentTraits.join(', '));
                    }
                }
                
                // Generate appropriate message
                if (activeFilters.length === 0) {
                    filterMessage = 'No pets found.';
                } else if (activeFilters.length === 1) {
                    // Single filter - use singular message
                    const filter = activeFilters[0];
                    if (filter.startsWith('species: ')) {
                        const species = filter.replace('species: ', '');
                        filterMessage = 'No ' + species + 's available for adoption.';
                    } else if (filter.startsWith('gender: ')) {
                        const gender = filter.replace('gender: ', '');
                        filterMessage = 'No ' + gender + ' pets available.';
                    } else if (filter.startsWith('age: ')) {
                        filterMessage = 'No pets found in this age range.';
                    } else if (filter.startsWith('breed: ')) {
                        filterMessage = 'No pets found with this breed.';
                    } else if (filter.startsWith('trait: ')) {
                        filterMessage = 'No pets have this trait.';
                    } else if (filter === 'recommended') {
                        filterMessage = 'No recommended pets found for you at this time.';
                    } else {
                        filterMessage = 'No pets found with this filter.';
                    }
                } else {
                    // Multiple filters - use plural message
                    filterMessage = 'No pets found with these filters.';
                }
                
                html = `<div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <p class="text-gray-500 text-lg">${filterMessage}</p>
                    <p class="text-gray-400 text-sm mt-1">Try selecting different filters or clear the filter.</p>
                </div>`;
            } else {
                pets.forEach(pet => {
                    const genderIcon = pet.gender === 'Female' ? '♀' : '♂';
                    const genderClass = pet.gender === 'Female' ? 'text-pink-500' : 'text-blue-500';
                    const imageHtml = pet.image 
                        ? `<img src="${pet.image}" alt="${pet.pet_name}" class="w-full h-full object-cover">`
                        : `<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-pink-500/40 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                           </svg>`;
                    
                    html += `<button type="button" onclick="openPetModal(${pet.adoption_id})" class="bg-white rounded-xl shadow-lg overflow-hidden pet-card block text-left w-full">
                        <div class="aspect-square bg-gradient-to-br from-pink-400/20 to-pink-500/30 relative">
                            ${imageHtml}
                            <span class="absolute top-2 right-2 text-xs px-2 py-1 rounded-full bg-[#E6F4EA] text-gray-800">${pet.species}</span>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900">${pet.pet_name}</h3>
                            <p class="text-sm text-gray-500">${pet.breed}</p>
                            <div class="flex items-center space-x-3 mt-2 text-xs">
                                <span class="${genderClass}">${genderIcon} ${pet.gender}</span>
                                <span class="text-gray-400">•</span>
                                <span class="text-gray-600">${pet.age || 'Age not available'}</span>
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
            if (currentPage < lastPage) {
                html += `<button onclick="loadPage(${currentPage + 1})" class="px-4 py-2 text-white bg-primary hover:bg-primary-light rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>`;
            } else {
                html += `<span class="px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </span>`;
            }
            
            nav.innerHTML = html;
        }
        
        function openPetModal(petId) {
            const pet = adoptionPets.find(p => p.adoption_id === petId);
            if (!pet) return;
            
            document.getElementById('modalPetName').textContent = pet.pet_name;
            currentModalPetId = petId;
            document.getElementById('modalPetSpecies').textContent = pet.species;
            document.getElementById('modalPetBreed').textContent = pet.breed;
            
            // Calculate age from date_of_birth
            let ageText = '';
            if (pet.date_of_birth) {
                const birthDate = new Date(pet.date_of_birth);
                const today = new Date();
                const years = Math.floor((today - birthDate) / (365.25 * 24 * 60 * 60 * 1000));
                const months = Math.floor(((today - birthDate) % (365.25 * 24 * 60 * 60 * 1000)) / (30.44 * 24 * 60 * 60 * 1000));
                
                if (years < 1) {
                    ageText = months + ' month' + (months !== 1 ? 's' : '') + ' old';
                } else {
                    ageText = years + ' year' + (years !== 1 ? 's' : '') + ' old';
                }
                
                if (pet.is_age_estimated) {
                    ageText += ' (estimated)';
                }
                
                // Add birth date display
                const birthDateStr = new Date(pet.date_of_birth).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                document.getElementById('modalPetAge').textContent = ageText + ' | Born: ' + birthDateStr;
            } else {
                document.getElementById('modalPetAge').textContent = 'Age not available';
            }
            
            document.getElementById('modalPetGender').textContent = pet.gender;
            document.getElementById('modalPetWeight').textContent = pet.weight || '';
            document.getElementById('modalPetDescription').textContent = pet.description || 'No description available';
            document.getElementById('modalPetTraits').textContent = Array.isArray(pet.traits) ? pet.traits.join(', ') : (pet.traits || 'No traits listed');
            document.getElementById('modalPetAdoptBtn').textContent = 'Adopt ' + pet.pet_name;
            
            if (pet.image) {
                document.getElementById('modalPetImage').src = pet.image;
                document.getElementById('modalPetImage').classList.remove('hidden');
                document.getElementById('modalPetImagePlaceholder').classList.add('hidden');
            } else {
                document.getElementById('modalPetImage').classList.add('hidden');
                document.getElementById('modalPetImagePlaceholder').classList.remove('hidden');
            }
            
            document.getElementById('petModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closePetModal() {
            document.getElementById('petModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Breed dropdown functions
        function toggleBreedDropdown() {
            const dropdown = document.getElementById('breed-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        function updateBreedSelection() {
            const checkboxes = document.querySelectorAll('.breed-checkbox:checked');
            const selectedBreeds = Array.from(checkboxes).map(cb => cb.value);
            currentBreeds = selectedBreeds;
            
            const display = document.getElementById('selected-breeds-display');
            if (selectedBreeds.length === 0) {
                display.textContent = 'Select breeds';
            } else if (selectedBreeds.length === 1) {
                display.textContent = selectedBreeds[0];
            } else {
                display.textContent = selectedBreeds.length + ' breeds selected';
            }
        }
        
        function toggleTraitsDropdown() {
            const dropdown = document.getElementById('traits-dropdown');
            dropdown.classList.toggle('hidden');
        }
        
        function updateTraitsSelection() {
            const checkboxes = document.querySelectorAll('.trait-checkbox:checked');
            const selectedTraits = Array.from(checkboxes).map(cb => cb.value);
            currentTraits = selectedTraits;
            
            const display = document.getElementById('selected-traits-display');
            if (selectedTraits.length === 0) {
                display.textContent = 'Select traits';
            } else if (selectedTraits.length === 1) {
                display.textContent = selectedTraits[0];
            } else {
                display.textContent = selectedTraits.length + ' traits selected';
            }
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('breed-dropdown');
            const button = document.getElementById('breed-dropdown-button');
            if (!dropdown.contains(e.target) && !button.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
            const traitsDropdown = document.getElementById('traits-dropdown');
            const traitsButton = document.getElementById('traits-dropdown-button');
            if (!traitsDropdown.contains(e.target) && !traitsButton.contains(e.target)) {
                traitsDropdown.classList.add('hidden');
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closePetModal();
        });
    </script>

    <!-- Adoption Info -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Health Checked</h3>
                    <p class="text-gray-600 text-sm">All pets are vaccinated, dewormed, and medically cleared before adoption.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Adoption Guidance</h3>
                    <p class="text-gray-600 text-sm">We provide post-adoption support and guidance for new pet parents.</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Behavior Assessed</h3>
                    <p class="text-gray-600 text-sm">Each pet is observed for temperament to help match them with the right family.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Adoption FAQ -->
    <section class="py-16 bg-white" id="faq">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Pet Adoption FAQ</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Common questions about adopting a pet</p>
            </div>
            
            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">How can I adopt from PAWS?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>Applicants go through a screening process to ensure that our rescued animals go to loving homes. The process includes an online interview via Zoom and at least two (2) separate shelter visits to meet and get to know your chosen pet. Apply here.</p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Can you adopt my pet?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>PAWS does NOT adopt owned pets. We already have 300+ shelter animals rescued from cruelty and neglect that are waiting to be adopted. If you need to give up your pet for some reason, please consider other options or apply for rehoming assistance.</p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Why is there an adoption fee?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>The adoption fee is a token of your commitment and a demonstration of your financial capacity to care for a pet. P500 for cats / P1000 for dogs is a small price which already covers your pet's spay/neuter surgery, vaccinations and tick+flea treatment.</p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Can my adoption application get denied?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>Yes. Some reasons for denied applications include: Not being able to keep their pet indoors, incompatibility with the household, plus other circumstances that may be damaging to the health, safety, and happiness of our shelter animals.</p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">I live in the province/abroad. Can I still adopt?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>Yes, but special arrangements need to be made for the meet-and-greet, depending on your location. Please contact us to discuss your options. You may also opt to adopt from your local pound instead.</p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Do you have purebred cats or dogs?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>It is very rare that purebred cats or dogs are admitted to the shelter. Sadly, they are valued more than aspins and puspins who are equally deserving of a home. Please consider adopting a local breed instead.</p>
                    </div>
                </div>

                <!-- FAQ 7 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Do you have puppies or kittens for adoption?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>Puppies and kittens are only available for fostering for up to 6 months, or until they are vaccinated and neutered. Fostered puppies and kittens may be permanently adopted after this period if the fosterer passes the adoption application.</p>
                    </div>
                </div>

                <!-- FAQ 8 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Can I adopt more than one pet?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>Some applicants may be approved to adopt more than one pet on a case to case basis, but especially if the animal you wish to adopt belongs to a bonded pair.</p>
                    </div>
                </div>

                <!-- FAQ 9 -->
                <div class="bg-gray-50 rounded-xl overflow-hidden">
                    <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                        <span class="font-semibold text-gray-900">Can I return my adopted pet if I change my mind?</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="hidden px-6 pb-4 text-gray-600">
                        <p>A pet is a lifetime commitment. However, if you truly can't keep your adopted pet, please don't abandon them on the streets or with strangers. Please return them to us so we can find another home for them.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                        <li><a href="{{ url('/services') }}" class="text-gray-600 hover:text-primary transition-colors">Services</a></li>
                        <li><a href="{{ url('/adoption') }}" class="text-gray-600 hover:text-primary transition-colors">Adoption</a></li>
                        <li><a href="{{ url('/about-us') }}" class="text-gray-600 hover:text-primary transition-colors">About Us</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Pet Registration</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Kapon Program</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Anti-Rabies Vaccination</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Adoption</a></li>
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
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-12 pt-8 text-center text-gray-500 text-sm">
                © 2025 Dasmariñas City Veterinary Services. All rights reserved.
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
            if (!dropdown) return;
            
            const button = event.target.closest('button');
            if (!button && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // FAQ Toggle Function
        function toggleFaq(button) {
            const answer = button.nextElementSibling;
            const icon = button.querySelector('svg');
            
            answer.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>
</body>
</html>
