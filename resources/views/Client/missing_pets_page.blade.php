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

    <!-- Announcements Section - Vertical Bookshelf Design -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-6">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Latest Announcements</h2>
            </div>

            <!-- Bookshelf Container -->
            <div class="relative">
                <!-- Shelf Board -->
                <div class="absolute bottom-0 left-0 right-0 h-3 bg-amber-800 rounded-b-lg shadow-lg"></div>
                
                <!-- Announcement Cards (Books) -->
                <div id="announcements-container" class="space-y-3 pb-6">
                    @if(isset($announcements) && $announcements->count() > 0)
                        @foreach($announcements as $index => $announcement)
                        <div class="announcement-card-mp hidden" data-index="{{ $index }}">
                            <div class="bg-white rounded-r-lg shadow-md border-l-4 @if($announcement->priority == 'Urgent') border-red-500 @elseif($announcement->priority == 'Important') border-yellow-500 @else border-green-500 @endif p-4 transform rotate-{{ $index % 2 == 0 ? '-1' : '1' }}deg hover:rotate-0 transition-transform duration-300">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium @if($announcement->priority == 'Urgent') bg-red-100 text-red-700 @elseif($announcement->priority == 'Important') bg-yellow-100 text-yellow-700 @else bg-green-100 text-green-700 @endif">
                                                {{ $announcement->priority }}
                                            </span>
                                        </div>
                                        <h3 class="text-base font-bold text-gray-800 mb-1">{{ $announcement->title }}</h3>
                                        <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($announcement->body, 100) }}</p>
                                        <a href="{{ route('announcements.show', $announcement->id) }}" class="inline-flex items-center gap-1 mt-1 text-sm text-blue-600 hover:text-blue-700 font-medium">
                                            Read More
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                    <span class="text-xs text-gray-400 flex-shrink-0">{{ $announcement->publish_date ? $announcement->publish_date->format('M d') : '' }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <!-- Placeholder Announcements -->
                        <div class="announcement-card-mp">
                            <div class="bg-white rounded-r-lg shadow-md border-l-4 border-gray-300 p-4 transform rotate-1deg">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Normal</span>
                                        </div>
                                        <h3 class="text-base font-bold text-gray-400 mb-1">Welcome to Dasmariñas City Veterinary Services</h3>
                                        <p class="text-gray-400 text-sm">Stay tuned for important announcements.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="announcement-card-mp">
                            <div class="bg-white rounded-r-lg shadow-md border-l-4 border-gray-300 p-4 transform -rotate-1deg">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Normal</span>
                                        </div>
                                        <h3 class="text-base font-bold text-gray-400 mb-1">Pet Registration Ongoing</h3>
                                        <p class="text-gray-400 text-sm">Register your pets at the City Veterinary Office.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="announcement-card-mp">
                            <div class="bg-white rounded-r-lg shadow-md border-l-4 border-gray-300 p-4 transform rotate-1deg">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Normal</span>
                                        </div>
                                        <h3 class="text-base font-bold text-gray-400 mb-1">Free Vaccination Programs</h3>
                                        <p class="text-gray-400 text-sm">Anti-rabies drives across all barangays.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- See More Button -->
                @if(isset($announcements) && $announcements->count() > 3)
                <div class="text-center mt-4">
                    <button id="see-more-btn-mp" onclick="toggleAnnouncementsMP()" 
                        class="inline-flex items-center gap-2 px-5 py-2 bg-amber-700 hover:bg-amber-800 text-white text-sm font-semibold rounded-full shadow-md hover:shadow-lg transition-all duration-300">
                        <span id="see-more-text-mp">See More</span>
                        <svg id="see-more-icon-mp" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
                @endif
            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.announcement-card-mp');
        cards.forEach(function(card, index) {
            if (index < 3) {
                card.classList.remove('hidden');
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(function() {
                    card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 80);
            }
        });
    });

    function toggleAnnouncementsMP() {
        const cards = document.querySelectorAll('.announcement-card-mp');
        const btn = document.getElementById('see-more-btn-mp');
        const btnText = document.getElementById('see-more-text-mp');
        const btnIcon = document.getElementById('see-more-icon-mp');
        
        let visibleCount = 0;
        cards.forEach(card => {
            if (!card.classList.contains('hidden')) visibleCount++;
        });
        
        if (visibleCount >= cards.length) {
            cards.forEach(function(card, index) {
                if (index >= 3) {
                    card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(-10px)';
                    setTimeout(function() {
                        card.classList.add('hidden');
                    }, 300);
                }
            });
            btnText.textContent = 'See More';
            btnIcon.style.transform = 'rotate(0deg)';
        } else {
            cards.forEach(function(card, index) {
                if (index >= visibleCount) {
                    card.classList.remove('hidden');
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(function() {
                        card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 80);
                }
            });
            btnText.textContent = (visibleCount + 3 >= cards.length) ? 'See Less' : 'See More';
            btnIcon.style.transform = 'rotate(180deg)';
        }
    }
    </script>

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
                        <a href="#" class="bg-white text-amber-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-100 transition-colors">
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

    <!-- Content with Missing Pets -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($missingPets->count() > 0)
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Missing Pets in Dasmariñas</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">These pets need your help. If you've seen any of them, please contact the owner immediately.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                    @foreach($missingPets as $pet)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-red-100 card-hover cursor-pointer" onclick="showMissingPetModal({{ $pet->animal_id }})">
                            <div class="relative h-48 bg-gray-200">
                                @if($pet->photo_url)
                                    <img src="{{ asset('storage/' . $pet->photo_url) }}" alt="{{ $pet->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                                    Missing
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-xl font-bold text-gray-800">{{ $pet->name }}</h3>
                                <p class="text-gray-500">{{ ucfirst($pet->animal_type) }} - {{ $pet->breed ?? 'Unknown Breed' }}</p>
                                <div class="mt-3 space-y-1 text-sm text-gray-600">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Missing since: {{ $pet->missing_since ? $pet->missing_since->format('M d, Y') : 'N/A' }}
                                    </p>
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $pet->last_seen_location ?? 'Location unknown' }}
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <span class="text-sm text-gray-500">Click for details</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No Missing Pets</h3>
                    <p class="text-gray-500">There are no missing pet reports at the moment.</p>
                </div>
            @endif

            <div class="text-center mt-12">
                <p class="text-gray-600 mb-4">Are you a pet owner reporting a missing pet?</p>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login to Report
                </a>
            </div>
        </div>
    </section>

    <!-- Missing Pet Modal -->
    @if($missingPets->count() > 0)
    <div id="missingPetModal" class="fixed inset-0 bg-black/50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <div class="relative">
                @php $firstPet = $missingPets->first(); @endphp
                <div class="h-64 bg-gray-200 rounded-t-2xl overflow-hidden">
                    @if($firstPet->photo_url)
                        <img id="modalPetImage" src="{{ asset('storage/' . $firstPet->photo_url) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <button onclick="closeMissingPetModal()" class="absolute top-4 right-4 bg-white rounded-full p-2 shadow-lg hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">Missing</span>
                </div>
                <h3 id="modalPetName" class="text-2xl font-bold text-gray-800 mb-1">{{ $firstPet->name }}</h3>
                <p id="modalPetBreed" class="text-gray-500 mb-4">{{ ucfirst($firstPet->animal_type) }} - {{ $firstPet->breed ?? 'Unknown Breed' }}</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Missing Since</p>
                            <p id="modalMissingSince" class="font-medium">{{ $firstPet->missing_since ? $firstPet->missing_since->format('F d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Last Seen Location</p>
                            <p id="modalLastSeen" class="font-medium">{{ $firstPet->last_seen_location ?? 'Unknown' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Contact Info</p>
                            <p id="modalContact" class="font-medium">{{ $firstPet->contact_info ?? 'Contact city vet office' }}</p>
                        </div>
                    </div>
                    @if($firstPet->color)
                    <div class="flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                        <div>
                            <p class="text-sm text-gray-500">Color/Markings</p>
                            <p class="font-medium">{{ $firstPet->color }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4">
                    <p class="text-amber-800 text-sm font-medium">If you've seen this pet, please contact the owner immediately!</p>
                </div>
                
                <button onclick="closeMissingPetModal()" class="w-full py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
    @php
        $petsData = $missingPets->map(function($pet) {
            return [
                'id' => $pet->animal_id,
                'name' => $pet->name,
                'type' => $pet->animal_type,
                'breed' => $pet->breed,
                'color' => $pet->color,
                'sex' => $pet->sex,
                'photo_url' => $pet->photo_url ? asset('storage/' . $pet->photo_url) : null,
                'missing_since' => $pet->missing_since ? $pet->missing_since->format('F d, Y') : null,
                'last_seen_location' => $pet->last_seen_location,
                'contact_info' => $pet->contact_info,
                'owner_name' => $pet->owner ? ($pet->owner->first_name . ' ' . $pet->owner->last_name) : null
            ];
        })->toArray();
    @endphp
    const missingPetsData = @json($petsData);

    function showMissingPetModal(petId) {
        const pet = missingPetsData.find(p => p.id === petId);
        if (!pet) return;
        
        document.getElementById('modalPetName').textContent = pet.name;
        document.getElementById('modalPetBreed').textContent = (pet.type ? pet.type.charAt(0).toUpperCase() + pet.type.slice(1) : 'Pet') + ' - ' + (pet.breed || 'Unknown Breed');
        document.getElementById('modalMissingSince').textContent = pet.missing_since || 'N/A';
        document.getElementById('modalLastSeen').textContent = pet.last_seen_location || 'Unknown';
        document.getElementById('modalContact').textContent = pet.contact_info || 'Contact city vet office';
        
        const imgContainer = document.querySelector('#missingPetModal .h-64');
        if (pet.photo_url) {
            imgContainer.innerHTML = '<img src="' + pet.photo_url + '" class="w-full h-full object-cover">';
        } else {
            imgContainer.innerHTML = '<div class="w-full h-full flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg></div>';
        }
        
        document.getElementById('missingPetModal').classList.remove('hidden');
    }

    function closeMissingPetModal() {
        document.getElementById('missingPetModal').classList.add('hidden');
    }

    document.getElementById('missingPetModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMissingPetModal();
        }
    });
    </script>
    @endif

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
                            <span class="text-gray-600 text-sm">City Hall Compound, Dasmariñas City, Cavite</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-600 text-sm">(046) 123-4567</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-600 text-sm">vet@dasmarinas.gov.ph</span>
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
