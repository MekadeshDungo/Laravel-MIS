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
                    <a href="#" class="text-gray-600 hover:text-primary font-medium transition-colors">About Us</a>
                    <a href="{{ url('/services') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Services</a>
                    <a href="{{ url('/adoption') }}" class="text-primary font-medium transition-colors">Adoption</a>
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
                            <a href="#" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
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

    <!-- Pets Grid -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Row 1 -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
                <!-- Pet 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden pet-card">
                    <div class="aspect-square bg-gradient-to-br from-primary/20 to-primary/30 relative flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-primary/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Buddy</h3>
                        <p class="text-sm text-gray-500">Golden Retriever</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs text-gray-600">
                            <span>♂ Male</span>
                            <span>•</span>
                            <span>2 years</span>
                        </div>
                    </div>
                </div>

                <!-- Pet 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden pet-card">
                    <div class="aspect-square bg-gradient-to-br from-secondary/20 to-secondary/30 relative flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-secondary/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Luna</h3>
                        <p class="text-sm text-gray-500">Labrador Mix</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs text-gray-600">
                            <span>♀ Female</span>
                            <span>•</span>
                            <span>1 year</span>
                        </div>
                    </div>
                </div>

                <!-- Pet 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden pet-card">
                    <div class="aspect-square bg-gradient-to-br from-purple-400/20 to-purple-500/30 relative flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-purple-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Max</h3>
                        <p class="text-sm text-gray-500">German Shepherd</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs text-gray-600">
                            <span>♂ Male</span>
                            <span>•</span>
                            <span>3 years</span>
                        </div>
                    </div>
                </div>

                <!-- Pet 4 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden pet-card">
                    <div class="aspect-square bg-gradient-to-br from-red-400/20 to-red-500/30 relative flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-red-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Bella</h3>
                        <p class="text-sm text-gray-500">Beagle</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs text-gray-600">
                            <span>♀ Female</span>
                            <span>•</span>
                            <span>6 months</span>
                        </div>
                    </div>
                </div>

                <!-- Pet 5 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden pet-card">
                    <div class="aspect-square bg-gradient-to-br from-yellow-400/20 to-yellow-500/30 relative flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-yellow-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Charlie</h3>
                        <p class="text-sm text-gray-500">Poodle Mix</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs text-gray-600">
                            <span>♂ Male</span>
                            <span>•</span>
                            <span>4 years</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                <!-- Pet 6 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden pet-card">
                    <div class="aspect-square bg-gradient-to-br from-pink-400/20 to-pink-500/30 relative flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-pink-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Daisy</h3>
                        <p class="text-sm text-gray-500">Shih Tzu</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs text-gray-600">
                            <span>♀ Female</span>
                            <span>•</span>
                            <span>2 years</span>
                        </div>
                    </div>
                </div>

                <!-- Pet 7 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden pet-card">
                    <div class="aspect-square bg-gradient-to-br from-indigo-400/20 to-indigo-500/30 relative flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-indigo-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Rocky</h3>
                        <p class="text-sm text-gray-500">Bulldog</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs text-gray-600">
                            <span>♂ Male</span>
                            <span>•</span>
                            <span>3 years</span>
                        </div>
                    </div>
                </div>

                <!-- Pet 8 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden pet-card">
                    <div class="aspect-square bg-gradient-to-br from-teal-400/20 to-teal-500/30 relative flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-teal-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Molly</h3>
                        <p class="text-sm text-gray-500">Terrier Mix</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs text-gray-600">
                            <span>♀ Female</span>
                            <span>•</span>
                            <span>1 year</span>
                        </div>
                    </div>
                </div>

                <!-- Pet 9 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden pet-card">
                    <div class="aspect-square bg-gradient-to-br from-orange-400/20 to-orange-500/30 relative flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-orange-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Cooper</h3>
                        <p class="text-sm text-gray-500">Boxer Mix</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs text-gray-600">
                            <span>♂ Male</span>
                            <span>•</span>
                            <span>2 years</span>
                        </div>
                    </div>
                </div>

                <!-- Pet 10 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden pet-card">
                    <div class="aspect-square bg-gradient-to-br from-cyan-400/20 to-cyan-500/30 relative flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-cyan-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Available</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900">Lucy</h3>
                        <p class="text-sm text-gray-500">Husky Mix</p>
                        <div class="flex items-center space-x-3 mt-2 text-xs text-gray-600">
                            <span>♀ Female</span>
                            <span>•</span>
                            <span>18 months</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">About Us</a></li>
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
