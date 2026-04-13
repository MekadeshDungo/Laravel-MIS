<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kapon Application - Dasmariñas City Veterinary Services</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .dropdown-option {
            transition: all 0.2s ease;
        }
        .dropdown-option:hover {
            background-color: #f3f4f6;
        }
        .dropdown-option.selected {
            background-color: #e8f5e9;
        }
        .pet-breed-checkbox:checked + .pet-breed-label {
            background-color: #066D33;
            color: white;
        }
    </style>

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
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="font-sans bg-gray-50 min-h-screen">

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
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-primary font-medium hover:text-secondary transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">Register</a>
                </div>
            @endauth
        </div>
    </div>
</header>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
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

<!-- Main -->
<main class="py-10">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Title -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">SPAY/NEUTER (KAPON)</h2>
            <p class="mt-2 text-gray-600 text-sm text-center">
                Fields marked with <span class="text-red-500">*</span> are required
            </p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('status') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                <strong>Please fix the following errors:</strong>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card with Progress Steps -->
        <div class="bg-white border border-gray-200 rounded-lg p-8">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700" id="stepLabel">Step 1 of 4</span>
                    <span class="text-sm font-medium text-primary" id="stepTitle">Part 1: Owner's Information</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progressBar" class="bg-primary h-2.5 rounded-full transition-all duration-300" style="width: 25%"></div>
                </div>
                <div class="flex justify-between mt-2">
                    <div class="text-xs text-center flex-1">
                        <div id="step1Indicator" class="font-semibold text-primary">1</div>
                        <div class="text-gray-500">Owner</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step2Indicator" class="font-semibold text-gray-400">2</div>
                        <div class="text-gray-400">Pet</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step3Indicator" class="font-semibold text-gray-400">3</div>
                        <div class="text-gray-400">Agreement</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step4Indicator" class="font-semibold text-gray-400">4</div>
                        <div class="text-gray-400">General</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf

                <!-- PART 1: OWNER'S INFO -->
                <div id="part1" class="form-part">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 1: Owner's Information</h3>

                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium mb-1.5">
                                    Pet Owner's Name <span class="text-red-500">*</span>
                                    <span class="text-gray-500 text-xs ml-2">(First name and Last name)</span>
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" name="first_name" placeholder="First Name" value="{{ old('first_name', $petOwner->first_name ?? '') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                    <input type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name', $petOwner->last_name ?? '') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" placeholder="Enter Email" value="{{ old('email', $user->email ?? '') }}"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>

                            <!-- Mobile Number -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Mobile Number <span class="text-red-500">*</span>
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-4 py-2.5 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
                                        +63
                                    </span>
                                    <input type="tel" name="mobile_number" placeholder="943 210 2012" maxlength="12" value="{{ old('mobile_number', $petOwner->phone_number ?? '') }}"
                                           class="flex-1 px-4 py-2.5 rounded-r-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                            </div>

                            <!-- Alternate Mobile Number -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Alternate Mobile Number
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-4 py-2.5 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
                                        +63
                                    </span>
                                    <input type="tel" name="alt_mobile_number" placeholder="943 210 2012" maxlength="12"
                                           class="flex-1 px-4 py-2.5 rounded-r-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                            </div>

                            <!-- House No. / Unit No. -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    House No. / Unit No. <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="house_no" placeholder="House No. / Unit No." value="{{ old('house_no', $petOwner->house_no ?? '') }}"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>

                            <!-- Street -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Street <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="street" placeholder="Street" value="{{ old('street', $petOwner->street ?? '') }}"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>

                            <!-- Barangay -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Barangay <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="barangay" placeholder="Barangay" value="{{ old('barangay', $petOwner->barangay ?? '') }}"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation Buttons for Part 1 -->
                    <div class="flex justify-between items-center mt-8">
                        <a href="{{ url('/kapon') }}" class="text-gray-600 hover:text-primary transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back to Kapon Page
                        </a>
                        <button type="button" onclick="goToStep(2)" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Next: Pet's Information
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PART 2: PET'S INFO -->
                <div id="part2" class="form-part hidden">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 2: Pet's Information</h3>

                    <!-- Important Notes -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                        <p class="font-semibold text-yellow-700 mb-2">IMPORTANT NOTES:</p>
                        <ul class="list-disc list-inside text-sm text-yellow-700 space-y-1">
                            <li><strong>Post-Cesarean/Major Surgery Cases:</strong> If your pet has undergone cesarean or major surgery related to reproductive organs, please book at another veterinary clinic.</li>
                            <li><strong>Vaccinations and Kapon Surgery:</strong> If your pet has been recently vaccinated or is scheduled for vaccination, we recommend scheduling 2 weeks before or after.</li>
                        </ul>
                    </div>

                    <!-- Selected Pets Display Area -->
                    <div id="selectedPetsContainer" class="mb-6">
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-medium">
                                Selected Pets <span class="text-red-500">*</span>
                            </label>
                            <button type="button" onclick="openPetModal()" 
                                    class="bg-primary text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Select Pet
                            </button>
                        </div>
                        
                        <!-- Display selected pet cards here -->
                        <div id="selectedPetsList" class="grid md:grid-cols-2 gap-4">
                            <!-- Empty state -->
                            <div id="noPetsSelected" class="col-span-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg p-8 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-gray-500">No pets selected yet. Click "Select Pet" to choose from your registered pets.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Desired Date of Kapon -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-1.5">
                            Desired Date of Kapon (Spay/Neuter) <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="appointment_date" id="appointment_date"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                    </div>

                    <!-- Photo Uploads for Each Selected Pet -->
                    <div id="petPhotosContainer" class="mb-6">
                        <label class="block text-sm font-medium mb-3">
                            Upload Photos <span class="text-red-500">*</span>
                        </label>
                        <div id="petPhotoFields" class="space-y-4">
                            <!-- Photo upload fields will be dynamically added here -->
                            <div id="noPhotosMessage" class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-6 text-center">
                                <p class="text-gray-500 text-sm">Select a pet first to upload photos</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 italic mt-2">Required views: Head, Face, Body – top and side view (while standing on all four legs) and Genitals. Max. file size: 8MB per pet</p>
                    </div>
                    
                    <!-- Navigation Buttons for Part 2 -->
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="goToStep(1)" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </button>
                        <button type="button" onclick="goToStep(3)" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Next: Agreement
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Pet Selection Modal -->
                <div id="petModal" class="fixed inset-0 z-50 hidden">
                    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closePetModal()"></div>
                    <div class="fixed inset-0 flex items-center justify-center p-4">
                        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] overflow-hidden">
                            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Select Your Pet(s)</h3>
                                <button type="button" onclick="closePetModal()" class="text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="px-6 py-4 overflow-y-auto max-h-[60vh]">
                                @if(count($petsArray) === 0)
                                    <div class="text-center py-8">
                                        <p class="text-gray-500 mb-4">You haven't registered any pets yet.</p>
                                        <a href="{{ url('/pet-registration/form') }}" class="text-primary hover:text-primary-light font-medium">
                                            Register a Pet
                                        </a>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-600 mb-4">Select one or more pets for Kapon (Spay/Neuter) surgery:</p>
                                    <div class="space-y-3" id="petSelectionList">
                                        @foreach($petsArray as $pet)
                                            @php
                                                $speciesDisplay = isset($pet['species']) ? ucfirst($pet['species']) : 'Unknown';
                                            @endphp
                                            <label class="flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 hover:border-primary transition-colors pet-selection-card" data-pet-id="{{ $pet['id'] }}">
                                                <input type="checkbox" name="selected_pets[]" value="{{ $pet['id'] }}" 
                                                       class="mt-1 w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary pet-checkbox"
                                                       onchange="togglePetSelection(this)">
                                                <div class="ml-3 flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <span class="font-semibold text-gray-900 pet-name">{{ $pet['name'] }}</span>
                                                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded">{{ $speciesDisplay }}</span>
                                                    </div>
                                                    <div class="mt-1 text-xs text-gray-500">
                                                        <div>Breed: {{ $pet['breed'] ?? 'Unknown' }}</div>
                                                        <div class="text-gray-600">Age: {{ isset($pet['age']) ? str_replace('_', ' ', $pet['age']) : 'Unknown' }}</div>
                                                        <div class="text-gray-600">Weight: {{ isset($pet['weight']) ? (str_contains(strtolower($pet['weight']), 'kg') || strtolower($pet['weight']) == 'n/a' ? $pet['weight'] : $pet['weight'] . ' kg') : 'Unknown' }}</div>
                                                    </div>
                                                </div>
                                                @if(!empty($pet['image']))
                                                <div class="ml-2 flex-shrink-0">
                                                    <img src="{{ asset('storage/' . $pet['image']) }}" alt="{{ $pet['name'] }}" class="w-12 h-12 rounded-full object-cover">
                                                </div>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Selected: <span id="selectedCount">0</span> pet(s)</span>
                                    <button type="button" onclick="confirmPetSelection()" 
                                            class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                                        Confirm Selection
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Pet data from server
                    const petsData = @json($petsArray);
                    
                    // Format age - remove underscores and format naturally
                    function formatAge(age) {
                        if (!age) return 'Unknown';
                        return age.replace(/_/g, ' ').replace(/\b(\d)\b/g, '$1 ').trim();
                    }
                    
                    // Format weight - append kg if not included
                    function formatWeight(weight) {
                        if (!weight) return 'Unknown';
                        const weightStr = String(weight).toLowerCase();
                        if (weightStr.includes('kg') || weightStr === 'n/a' || weightStr === 'na') {
                            return weight;
                        }
                        return weight + ' kg';
                    }
                    
                    let selectedPets = [];

                    function openPetModal() {
                        // Check if user has no pets registered
                        if (petsData.length === 0) {
                            document.getElementById('petModal').classList.remove('hidden');
                            document.getElementById('petSelectionList').innerHTML = `
                                <div class="text-center py-8 px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-600 mb-4">It looks like you haven't registered your pets yet.</p>
                                    <a href="{{ url('/pet-registration/form') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-light transition-colors">
                                        Register Your Pet
                                    </a>
                                </div>
                            `;
                            // Hide the footer with confirm button when no pets
                            document.querySelector('#petModal .bg-gray-50').classList.add('hidden');
                            document.body.style.overflow = 'hidden';
                            return;
                        }
                        
                        // Show normal modal with pets
                        document.getElementById('petModal').classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }

                    function closePetModal() {
                        document.getElementById('petModal').classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }

                    function togglePetSelection(checkbox) {
                        const petId = String(checkbox.value);
                        if (checkbox.checked) {
                            // Check if max limit reached
                            if (selectedPets.length >= 3) {
                                checkbox.checked = false;
                                showPetLimitModal();
                                return;
                            }
                            if (!selectedPets.includes(petId)) {
                                selectedPets.push(petId);
                            }
                        } else {
                            selectedPets = selectedPets.filter(id => String(id) !== petId);
                        }
                        updateSelectedCount();
                    }

                    function showPetLimitModal() {
                        const modalHtml = `
                            <div id="petLimitModal" class="fixed inset-0 z-50">
                                <div class="fixed inset-0 bg-black bg-opacity-50"></div>
                                <div class="fixed inset-0 flex items-center justify-center p-4">
                                    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
                                        <div class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-yellow-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Pet Limit Reached</h3>
                                            <p class="text-gray-600 mb-6">To ensure fair slot distribution and smooth form submission, a maximum of 3 pets is allowed per transaction. Please complete this form first and submit a new application for additional pets.</p>
                                            <button type="button" onclick="closePetLimitModal()" class="bg-primary text-white px-6 py-2 rounded-lg font-medium hover:bg-primary-light transition-colors">
                                                I understand
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.insertAdjacentHTML('beforeend', modalHtml);
                        document.body.style.overflow = 'hidden';
                    }

                    function closePetLimitModal() {
                        const modal = document.getElementById('petLimitModal');
                        if (modal) {
                            modal.remove();
                        }
                        document.body.style.overflow = 'auto';
                    }

                    function updateSelectedCount() {
                        document.getElementById('selectedCount').textContent = selectedPets.length;
                    }

                    function confirmPetSelection() {
                        const container = document.getElementById('selectedPetsList');
                        const noPetsMessage = document.getElementById('noPetsSelected');
                        const photoContainer = document.getElementById('petPhotoFields');
                        const modalFooter = document.querySelector('#petModal .bg-gray-50');

                        // Restore footer if it was hidden
                        if (modalFooter) {
                            modalFooter.classList.remove('hidden');
                        }

                        if (selectedPets.length > 0) {
                            if (noPetsMessage) {
                                noPetsMessage.remove();
                            }
                        }

                        // Clear current selections and rebuild
                        container.innerHTML = '';
                        photoContainer.innerHTML = '';

                        if (selectedPets.length === 0) {
                            container.innerHTML = `
                                <div id="noPetsSelected" class="col-span-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-500">No pets selected yet. Click "Select Pet" to choose from your registered pets.</p>
                                </div>
                            `;
                            photoContainer.innerHTML = `
                                <div id="noPhotosMessage" class="bg-gray-50 border border-dashed border-gray-300 rounded-lg p-6 text-center">
                                    <p class="text-gray-500 text-sm">Select a pet first to upload photos</p>
                                </div>
                            `;
                            closePetModal();
                            return;
                        }

                        selectedPets.forEach(petId => {
                            const pet = petsData.find(p => String(p.id) === String(petId));
                            if (pet) {
                                // Determine image source
                                let imageHtml = '';
                                if (pet.image) {
                                    imageHtml = `<img src="{{ asset('storage/') }}/${pet.image}" alt="${pet.name}" class="w-12 h-12 rounded-full object-cover">`;
                                } else {
                                    imageHtml = `<div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>`;
                                }
                                
                                // Add pet card
                                const petCard = document.createElement('div');
                                petCard.className = 'bg-white border border-gray-200 rounded-lg p-4 flex items-center justify-between';
                                const speciesDisplay = pet.species ? pet.species.charAt(0).toUpperCase() + pet.species.slice(1) : 'Unknown';
                                petCard.innerHTML = `
                                    <div class="flex items-center">
                                        ${imageHtml}
                                        <div class="ml-3">
                                            <p class="font-semibold text-gray-900">${pet.name || 'Unknown'}</p>
                                            <p class="text-xs text-gray-500">${speciesDisplay} • ${pet.breed || 'Unknown'}</p>
                                            <p class="text-xs text-gray-600 mt-1">Age: ${formatAge(pet.age)} • Weight: ${formatWeight(pet.weight)}</p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="removePet(${pet.id})" class="text-red-500 hover:text-red-700 p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                `;
                                container.appendChild(petCard);

                                // Add photo upload field for this pet
                                const photoField = document.createElement('div');
                                photoField.className = 'bg-gray-50 border border-gray-200 rounded-lg p-4';
                                photoField.innerHTML = `
                                    <div class="flex items-center mb-2">
                                        <span class="font-medium text-sm text-gray-700">${pet.name}</span>
                                    </div>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                                        <input type="file" name="pet_photos[${pet.id}][]" id="pet_photos_${pet.id}" multiple accept="image/*" class="hidden">
                                        <label for="pet_photos_${pet.id}" class="cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-gray-600 text-sm">Click to upload photos for ${pet.name}</p>
                                        </label>
                                    </div>
                                `;
                                photoContainer.appendChild(photoField);
                            }
                        });

                        closePetModal();
                    }

                    function removePet(petId) {
                        // Remove from selectedPets array (convert to string for comparison)
                        selectedPets = selectedPets.filter(id => String(id) !== String(petId));
                        
                        // Uncheck the checkbox in modal
                        const checkbox = document.querySelector(`#petSelectionList input[value="${petId}"]`);
                        if (checkbox) {
                            checkbox.checked = false;
                        }
                        
                        // Rebuild the display
                        confirmPetSelection();
                        updateSelectedCount();
                    }

                    // Close modal on escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closePetModal();
                        }
                    });
                </script>

                <!-- PART 3: PER-PET AGREEMENT -->
                <div id="part3" class="form-part hidden">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 3: Agreement</h3>
                    </div>

                    <!-- Dynamic Per-Pet Agreement Cards -->
                    <div id="petAgreementsContainer" class="space-y-6">
                        <!-- Pet agreement cards will be dynamically generated here -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                            <p class="text-sm text-yellow-700">Please select pets in Part 2 first to see the agreement forms.</p>
                        </div>
                    </div>

                    <!-- Navigation Buttons for Part 3 -->
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="goToStep(2)" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </button>
                        <button type="button" onclick="goToStep(4)" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Next: General Agreement
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PART 4: GENERAL AGREEMENT -->
                <div id="part4" class="form-part hidden">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 4: General Agreement</h3>
                    </div>

                    <div class="space-y-6">
                        <!-- Secure cage/leash -->
                        <div>
                            <label class="inline-flex items-start">
                                <input type="checkbox" name="general_agreement[secure_cage]" value="yes" class="mt-1 text-primary">
                                <span class="ml-2 text-sm text-gray-700">I understand that I must place my pet/s inside a secure cage or leash. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Keep indoors -->
                        <div>
                            <label class="inline-flex items-start">
                                <input type="checkbox" name="general_agreement[keep_indoors]" value="yes" class="mt-1 text-primary">
                                <span class="ml-2 text-sm text-gray-700">I will keep my pet/s indoors until they are fully healed. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Keep incision dry -->
                        <div>
                            <label class="inline-flex items-start">
                                <input type="checkbox" name="general_agreement[keep_dry]" value="yes" class="mt-1 text-primary">
                                <span class="ml-2 text-sm text-gray-700">I will keep their incision dry and refrain from bathing this animal for the next 2 weeks. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Full authority -->
                        <div>
                            <label class="inline-flex items-start">
                                <input type="checkbox" name="general_agreement[full_authority]" value="yes" class="mt-1 text-primary">
                                <span class="ml-2 text-sm text-gray-700">I hereby give the Dasmariñas City Veterinary Office (CVO) and its attending veterinarians and staff full authority to perform the procedure. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Valid ID -->
                        <div>
                            <label class="inline-flex items-start">
                                <input type="checkbox" name="general_agreement[valid_id]" value="yes" class="mt-1 text-primary">
                                <span class="ml-2 text-sm text-gray-700">I will bring and present a valid primary ID before entering the premises of the CVO for security purposes. <span class="text-red-500">*</span></span>
                            </label>
                        </div>

                        <!-- Confirmation of Location -->
                        <div>
                            <label class="inline-flex items-start">
                                <input type="checkbox" name="general_agreement[location]" value="yes" class="mt-1 text-primary">
                                <span class="ml-2 text-sm text-gray-700">Confirmation of location: I am aware that the spay/neuter surgery will be performed at the veterinary office located in Dasmariñas City. <span class="text-red-500">*</span></span>
                            </label>
                        </div>
                    </div>

                    <!-- Disclaimer -->
                    <div class="mt-6 bg-red-50 border-l-4 border-red-500 p-4">
                        <p class="text-sm text-red-700">*** Dasmariñas City Veterinary Office (CVO) and its licensed veterinarians will not be held liable in the event of complications, including injury or death, during surgery. These may result due to undiagnosed illnesses that may be detected and treated if a blood test is performed.</p>
                        <p class="text-sm text-red-700 mt-2">*** Pure and half-breed pets or brachycephalic (short-nosed) breeds are required to submit the results of blood tests prior to surgery. It is highly recommended that aspins and puspins with preexisting conditions be tested as well.</p>
                    </div>

                    <!-- Submit Button with Navigation -->
                    <div class="mt-12 pt-8 border-t">
                        <!-- Row 1: Previous and Submit buttons -->
                        <div class="flex justify-between items-center mb-6">
                            <button type="button" onclick="goToStep(3)" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors flex items-center w-40 justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous
                            </button>
                            
                            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors w-40">
                                Submit
                            </button>
                        </div>
                        
                        <!-- Row 2: Back to Kapon link (centered) -->
                        <div class="text-center">
                            <a href="{{ url('/kapon') }}" class="inline-block text-gray-600 hover:text-primary transition-colors">
                                ← Back to Kapon Page
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-white border-t border-gray-200 mt-12">
    <div class="max-w-6xl mx-auto px-6 py-6 text-center text-gray-600 text-sm">
        <p>© 2025 Dasmariñas City Veterinary Services. All rights reserved.</p>
    </div>
</footer>

<script>
    // Multi-step form navigation
    function goToStep(step) {
        // Hide all parts
        document.querySelectorAll('.form-part').forEach(part => {
            part.classList.add('hidden');
        });
        
        // Show the selected part
        document.getElementById('part' + step).classList.remove('hidden');
        
        // Update progress bar
        const progressBar = document.getElementById('progressBar');
        const stepLabel = document.getElementById('stepLabel');
        const stepTitle = document.getElementById('stepTitle');
        const step1Indicator = document.getElementById('step1Indicator');
        const step2Indicator = document.getElementById('step2Indicator');
        const step3Indicator = document.getElementById('step3Indicator');
        const step4Indicator = document.getElementById('step4Indicator');
        
        // Update progress percentage
        progressBar.style.width = (step * 25) + '%';
        stepLabel.textContent = 'Step ' + step + ' of 4';
        
        // Update step titles
        if (step === 1) {
            stepTitle.textContent = 'Part 1: Owner\'s Information';
            step1Indicator.className = 'font-semibold text-primary';
            step2Indicator.className = 'font-semibold text-gray-400';
            step3Indicator.className = 'font-semibold text-gray-400';
            step4Indicator.className = 'font-semibold text-gray-400';
        } else if (step === 2) {
            stepTitle.textContent = 'Part 2: Pet\'s Information';
            step1Indicator.className = 'font-semibold text-green-600';
            step2Indicator.className = 'font-semibold text-primary';
            step3Indicator.className = 'font-semibold text-gray-400';
            step4Indicator.className = 'font-semibold text-gray-400';
        } else if (step === 3) {
            stepTitle.textContent = 'Part 3: Agreement';
            step1Indicator.className = 'font-semibold text-green-600';
            step2Indicator.className = 'font-semibold text-green-600';
            step3Indicator.className = 'font-semibold text-primary';
            step4Indicator.className = 'font-semibold text-gray-400';
            // Generate pet agreement cards when entering Part 3
            generatePetAgreementCards();
        } else if (step === 4) {
            stepTitle.textContent = 'Part 4: General Agreement';
            step1Indicator.className = 'font-semibold text-green-600';
            step2Indicator.className = 'font-semibold text-green-600';
            step3Indicator.className = 'font-semibold text-green-600';
            step4Indicator.className = 'font-semibold text-primary';
        }
        
        // Scroll to top of form
        document.getElementById('part' + step).scrollIntoView({ behavior: 'smooth' });
    }

    // Generate per-pet agreement cards for Part 3
    function generatePetAgreementCards() {
        const container = document.getElementById('petAgreementsContainer');
        
        if (selectedPets.length === 0) {
            container.innerHTML = `
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                    <p class="text-sm text-yellow-700">Please select pets in Part 2 first to see the agreement forms.</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = '';
        
        selectedPets.forEach(petId => {
            const pet = petsData.find(p => String(p.id) === String(petId));
            if (pet) {
                // Determine if pet is over 4 years old
                let isOver4Years = false;
                const ageStr = String(pet.age).toLowerCase();
                
                const yearMatch = ageStr.match(/(\d+)\s*year/);
                if (yearMatch) {
                    const years = parseInt(yearMatch[1]);
                    isOver4Years = years > 4;
                } else if (ageStr.includes('over')) {
                    isOver4Years = true;
                }
                
                // Determine pet type for blood test logic
                const species = String(pet.species || '').toLowerCase();
                const breed = String(pet.breed || '').toLowerCase();
                
                // Check if it's a cat
                const isCat = species === 'cat';
                
                // Check if it's an Aspin (local dog)
                const isAspin = species === 'dog' && (breed.includes('aspin') || breed === 'mixed breed (aspin)');
                
                // Check if it's a purebred or mixed dog (not Aspin)
                const isOtherDog = species === 'dog' && !isAspin;
                
                const petCard = document.createElement('div');
                petCard.className = 'bg-white border border-gray-200 rounded-lg p-6 mb-6';
                petCard.id = 'pet-agreement-' + petId;
                
                let bloodTestSection = '';
                
                if (isOver4Years) {
                    // Over 4 years old - single checkbox option
                    bloodTestSection = `
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="font-medium text-gray-700 mb-2">Blood Test Agreement <span class="text-red-500">*</span></p>
                            <p class="text-sm text-gray-600 mb-3">For those with mixed or purebred dogs and/or over 4 years old:</p>
                            <p class="text-sm text-gray-600 mb-3">For the safety of your pet, the Dasmariñas City Veterinary Office (CVO) highly recommends a blood test (CBC, SGPT, and CREA) prior to surgery. Since the CVO is a public service facility with limited laboratory resources, please have these tests performed at a private veterinary clinic of your choice. You must upload the results here at least 48 hours before your appointment.</p>
                            
                            <div class="space-y-3">
                                <label class="inline-flex items-start">
                                    <input type="checkbox" name="pet_agreement[${pet.id}][blood_test]" value="submit_results" class="mt-1 text-primary" required>
                                    <span class="ml-2 text-sm text-gray-700">Yes, I will upload the blood test results. I will provide a clear photo or PDF of the results (CBC, SGPT, & CREA) via this portal at least 48 hours before my schedule.</span>
                                </label>
                            </div>
                        </div>
                    `;
                } else if (isCat || isAspin) {
                    // Under 4 years old, Cat or Aspin - two radio button options
                    bloodTestSection = `
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="font-medium text-gray-700 mb-2">Blood Test Agreement <span class="text-red-500">*</span></p>
                            <p class="text-sm text-gray-600 mb-3">For the safety of your pet, the Dasmariñas City Veterinary Office (CVO) highly recommends a blood test (CBC, SGPT, and CREA) prior to surgery. Since the CVO is a public service facility with limited laboratory resources, please have these tests performed at a private veterinary clinic of your choice.</p>
                            
                            <div class="space-y-3">
                                <label class="inline-flex items-start">
                                    <input type="radio" name="pet_agreement[${pet.id}][blood_test]" value="submit_results" class="mt-1 text-primary" required>
                                    <span class="ml-2 text-sm text-gray-700">Yes, I will upload the blood test results. I will provide a clear photo or PDF of the results (CBC, SGPT, & CREA) via this portal at least 48 hours before my schedule.</span>
                                </label>
                                <label class="inline-flex items-start">
                                    <input type="radio" name="pet_agreement[${pet.id}][blood_test]" value="waive" class="mt-1 text-primary">
                                    <span class="ml-2 text-sm text-gray-700">I understand the risk of not getting the blood test for my pet so I am waiving the option as I am sure that my pet is/are healthy ASPIN or CAT under 4 years old. <strong class="text-red-600 font-medium">The Dasmariñas City Veterinary Office (CVO) will not be held liable in the event of complications, injury, or death that may result from the surgery due to undiagnosed illnesses that could have been treated if a blood test was performed.</strong></span>
                                </label>
                            </div>
                        </div>
                    `;
                } else if (isOtherDog) {
                    // Under 4 years old, Purebred or Mixed Dog (not Aspin) - single checkbox option
                    bloodTestSection = `
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="font-medium text-gray-700 mb-2">Blood Test Agreement <span class="text-red-500">*</span></p>
                            <p class="text-sm text-gray-600 mb-3">For the safety of your pet, the Dasmariñas City Veterinary Office (CVO) highly recommends a blood test (CBC, SGPT, and CREA) prior to surgery. Since the CVO is a public service facility with limited laboratory resources, please have these tests performed at a private veterinary clinic of your choice. You must upload the results here at least 48 hours before your appointment.</p>
                            
                            <div class="space-y-3">
                                <label class="inline-flex items-start">
                                    <input type="checkbox" name="pet_agreement[${pet.id}][blood_test]" value="submit_results" class="mt-1 text-primary" required>
                                    <span class="ml-2 text-sm text-gray-700">Yes, I will upload the blood test results. I will provide a clear photo or PDF of the results (CBC, SGPT, & CREA) via this portal at least 48 hours before my schedule.</span>
                                </label>
                            </div>
                        </div>
                    `;
                } else {
                    // Fallback - default to requiring blood test
                    bloodTestSection = `
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <p class="font-medium text-gray-700 mb-2">Blood Test Agreement <span class="text-red-500">*</span></p>
                            <p class="text-sm text-gray-600 mb-3">For the safety of your pet, the Dasmariñas City Veterinary Office (CVO) highly recommends a blood test (CBC, SGPT, and CREA) prior to surgery. Since the CVO is a public service facility with limited laboratory resources, please have these tests performed at a private veterinary clinic of your choice. You must upload the results here at least 48 hours before your appointment.</p>
                            
                            <div class="space-y-3">
                                <label class="inline-flex items-start">
                                    <input type="checkbox" name="pet_agreement[${pet.id}][blood_test]" value="submit_results" class="mt-1 text-primary" required>
                                    <span class="ml-2 text-sm text-gray-700">Yes, I will upload the blood test results. I will provide a clear photo or PDF of the results (CBC, SGPT, & CREA) via this portal at least 48 hours before my schedule.</span>
                                </label>
                            </div>
                        </div>
                    `;
                }
                
                petCard.innerHTML = `
                    <div class="flex items-center mb-4 pb-3 border-b">
                        ${pet.image ? `<img src="{{ asset('storage/') }}/${pet.image}" alt="${pet.name}" class="w-10 h-10 rounded-full object-cover">` : `
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>`}
                        <div class="ml-3">
                            <h4 class="font-semibold text-gray-900">${pet.name}</h4>
                            <p class="text-xs text-gray-500">${pet.species || 'Unknown'} • ${pet.breed || 'Unknown'} • Age: ${formatAge(pet.age)}</p>
                        </div>
                        ${isOver4Years ? '<span class="ml-auto text-xs px-2 py-1 bg-orange-100 text-orange-700 rounded">Over 4 years - Blood test required</span>' : ''}
                    </div>
                    
                    ${bloodTestSection}
                    
                    <!-- Previous Surgery -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            My pet had undergone previous surgery <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][previous_surgery]" value="yes" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][previous_surgery]" value="no" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">No</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Health Condition -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            Health Condition (Has the pet been healthy for the past 3 weeks or longer?) <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][health_condition]" value="yes" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][health_condition]" value="no" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">No</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Other health information -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1.5">
                            Other health information about your pet
                        </label>
                        <p class="text-xs text-gray-500 italic mb-2">If your pet has any existing or previously treated health condition that was not disclosed to us prior to the procedure, CVO cannot be held liable for any health issues that may arise afterward.</p>
                        <textarea name="pet_agreement[${pet.id}][health_info]" rows="3"
                                  class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                  placeholder="Please share any relevant medical information..."></textarea>
                    </div>
                    
                    <!-- Physical Assessment -->
                    <div class="mb-4">
                        <label class="inline-flex items-start">
                            <input type="checkbox" name="pet_agreement[${pet.id}][physical_assessment]" value="yes" class="mt-1 text-primary">
                            <span class="ml-2 text-sm text-gray-600"><strong>Physical Assessment: <span class="text-red-500">*</span> </strong> Your pet's safety is our priority. Please understand that as an LGU with limited facilities and no confinement area; we may not be equipped to handle certain medical conditions. By checking the box, you acknowledged that a veterinary assessment is required before surgery, and that the procedure may be declined based on the results of the evaluation.</span>
                        </label>
                    </div>
                    
                    <!-- Pyometra -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            My pet has pyometra <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][pyometra]" value="yes" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][pyometra]" value="no" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">No</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- In Heat -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            My pet is/are in heat <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][in_heat]" value="yes" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][in_heat]" value="no" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">No</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Food Restriction -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">
                            Food Restriction (Has the pet not eaten any food or liquids for the past 12 hours prior to surgery?) <span class="text-red-500">*</span>
                        </label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][food_restriction]" value="yes" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">Yes</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="pet_agreement[${pet.id}][food_restriction]" value="no" class="text-primary">
                                <span class="ml-2 text-gray-900 font-medium">No</span>
                            </label>
                        </div>
                    </div>
                `;
                
                container.appendChild(petCard);
            }
        });
    }

    // Cat breeds list
    const catBreedsList = [
        "Mixed Breed (Puspin)", "Abyssinian", "Aegean", "American Bobtail", "American Curl", 
        "American Shorthair", "American Wirehair", "Arabian Mau", "Australian Mist", "Balinese", 
        "Bambino", "Bengal", "Birman", "Bombay", "British Longhair", "British Shorthair", 
        "Burmese", "Burmilla", "California Spangled", "Chantilly-Tiffany", "Chartreux", 
        "Chausie", "Cheetoh", "Colorpoint Shorthair", "Cornish Rex", "Cymric", "Devon Rex", 
        "Donskoy", "Egyptian Mau", "Exotic Shorthair", "Havana Brown", "Highlander", 
        "Himalayan", "Japanese Bobtail", "Javanese", "Khao Manee", "Korat", "Kurilian Bobtail", 
        "LaPerm", "Lykoi", "Maine Coon", "Manx", "Mexican Hairless", "Minskin", "Minuet", 
        "Munchkin", "Nebelung", "Norwegian Forest Cat", "Ocicat", "Ojos Azules", 
        "Oriental Shorthair", "Persian", "Peterbald", "Pixiebob", "Ragamuffin", "Ragdoll", 
        "Russian Blue", "Savannah", "Scottish Fold", "Scottish Straight", "Selkirk Rex", 
        "Serengeti", "Siamese", "Siberian", "Singapura", "Snowshoe", "Somali", "Sphynx", 
        "Thai", "Tonkinese", "Toybob", "Toyger", "Turkish Angora", "Turkish Van", 
        "York Chocolate", "Unknown"
    ];

    // Dog breeds list (full list)
    const dogBreedsList = [
        "Mixed Breed (Aspin)", "Akita", "Alaskan Klee Kai", "Alaskan Malamute", "American Eskimo", 
        "Appenzeller Sennenhund", "Australian Stumpy Tail Cattle Dog", "Azawakh", "Barbado da Terciera", "Barbet", "Basenji",
        "Basset Fauve de Bretagne", "Basset Hound", "Beagle", "Belgian Laekenois", "Belgian Tervuren", 
        "Berger Picard", "Bichon Frise", "Bloodhound", "Boerboel", "Bolognese", "Borzoi", "Boxer", 
        "Bracco Italiano", "Braque Francais Pyrenean", "Braques du Bourbonnais", "Broholmer", 
        "Brussels Griffon", "Bull Terrier", "Boston Bull Terrier", "Staffordshire Bull Terrier", 
        "Miniature Bull Terrier", "Bulldog", "French Bulldog", "Olde English Bulldogge", 
        "American Bulldog", "Continental Bulldog", "Ca de Bou", "Serrano Bulldog", "Campeiro Bulldog", 
        "Alano Español", "Canaan Dog", "Canadian Eskimo Dog", "Cane Corso", "Carolina Dog", 
        "Catahoula Leopard", "Cesky Fousek", "Chihuahua", "Chinese Crested", "Chinese Shar-Pei", 
        "Chinook", "Chow Chow", "Cirneco dell'Etna", "American English Coonhound", 
        "Black and Tan Coonhound", "Bluetick Coonhound", "Redbone Coonhound", "Treeing Walker Coonhound", 
        "Plott Hound", "Cardigan Welsh Corgi", "Pembroke Welsh Corgi", "Coton de Tulear", 
        "Czechoslovakian Vlcak", "Dachshund", "Dalmatian", "Danish-Swedish Farmdog", 
        "Deutscher Watchtelhund", "Dogo Argentino", "Dogue de Bordeaux", "Drever", "Dutch Partridge", 
        "Dutch Smoushond", "East Siberian Laika", "Eurasier", "Finnish Spitz", "American Foxhound", 
        "English Foxhound", "German Spitz", "Grand Basset Griffon Vendeen", "Grand Bleu de Gascogne", 
        "Great Dane", "Great Pyrenees", "Greenland Dog", "Hanoverian Scenthound", "Harrier", 
        "Havanese", "Hokkaido", "Afghan Hound", "American Leopard Hound", 
        "Bavarian Mountain Scent Hound", "Caravan (Mudhol) Hound", "Finnish Hound", 
        "French White & Black Hound", "German Hound", "Hamilton Hound", "Ibizan Hound", 
        "Pharaoh Hound", "Transylvanian Hound", "Hovawart", "Irish Wolfhound", "Italian Greyhound", 
        "Japanese Akitainu", "Japanese Chin", "Japanese Spitz", "Jindo", "Kai Ken", 
        "Karelian Bear Dog", "Keeshond", "Kishu Ken", "Komondor", "Kromfohrlander", "Kuvasz", 
        "Lagotto Romagnolo", "Lancashire Heeler", "Lapponian Herder", "Leonberger", "Lhasa Apso", 
        "Lowchen", "Maltese", "Standard Manchester Terrier", "Toy Manchester Terrier", "Mastiff", 
        "Bullmastiff", "Brazilian Mastiff", "Neapolitan Mastiff", "Pyrenean Mastiff", 
        "Spanish Mastiff", "Tibetan Mastiff", "Moscow Watchdog", "Mountain Cur", "Bernese Mountain Dog", 
        "Entlebucher Mountain Dog", "Estrela Mountain Dog", "Greater Swiss Mountain Dog", "Mudi", 
        "Newfoundland", "Norrbottenspets", "Norwegian Buhund", "Norwegian Elkhound", 
        "Norwegian Lundehund", "Otterhound", "Pekingese", "Perro de Presa Canario", "Peruvian Inca Orchid", 
        "Petit Basset Griffon Vendeen", "Affenpinscher Pinscher", "Doberman Pinscher", 
        "German Pinscher", "Miniature Pinscher", "German Longhaired Pointer", "German Shorthaired Pointer", 
        "German Wirehaired Pointer", "Portuguese Pointer", "Slovakian Wirehaired Pointer", 
        "Chart Polski Polish Greyhound", "Pomeranian", "Miniature Poodle", "Standard Poodle", 
        "Toy Poodle", "Porcelaine", "Portuguese Podengo", "Portuguese Podengo Pequeno", 
        "Pudelpointer", "Pug", "Puli", "Pumi", "Rafeiro do Alentejo", "Chesapeake Bay Retriever", 
        "Curly-coated Retriever", "Flat-Coated Retriever", "Golden Retriever", "Labrador Retriever", 
        "Nova Scotia Duck Tolling Retriever", "Rhodesian Ridgeback", "Rottweiler", "Russian Toy", 
        "Russian Tsvetnaya Bolonka", "Saint Bernard", "Saluki", "Samoyed", "Schapendoes", 
        "Schipperke", "Giant Schnauzer", "Miniature Schnauzer", "Standard Schnauzer", 
        "Scottish Deerhound", "Sealyham Terrier", "Segugio Italiano", "English Setter", 
        "Gordon Setter", "Irish Red and White Setter", "Irish Setter", "Anatolian Shepherd", 
        "Australian Cattle Dog", "American Miniature Shepherd", "Australian Kelpie Shepherd", 
        "Australian Shepherd", "Bearded Collie", "Beauceron", "Belgian Malinois", 
        "Belgian Sheepdog (Groenendael)", "Briard", "Border Collie", "Bouvier des Flandres", 
        "Collie", "Finnish Lapphund", "Miniature American Shepherd", "Bergamasco Shepherd", 
        "Bohemian Shepherd", "Catalan Shepherd", "Caucasian Shepherd", "Central Asian Shepherd", 
        "Croatian Shepherd", "Dutch Shepherd", "English Shepherd", "German Shepherd", 
        "Icelandic Shepherd", "Karst Shepherd", "Old English Shepherd", "Polish Lowland Shepherd", 
        "Portuguese Shepherd", "Pyrenean Shepherd", "Romanian Carpathian Shepherd Dog", 
        "Romanian Mioritic Shepherd Dog", "Shetland Sheepdog", "Shiba Inu", "Shih Tzu", "Shikoku", 
        "Siberian Husky", "Sloughi", "Slovensky Cubac", "Slovensky Kopov", "Small Munsterlander", 
        "American Water Spaniel", "Boykin Spaniel", "Brittany", "Cavalier King Charles Spaniel", 
        "Clumber Spaniel", "Cocker Spaniel", "English Cocker Spaniel", "English Springer Spaniel", 
        "English Toy Spaniel", "Field Spaniel", "French Spaniel", "Irish Water Spaniel", 
        "Nederlandse Kooikerhondje", "Papillon Spaniel", "Sussex Spaniel", "Tibetan Spaniel", 
        "Welsh Springer Spaniel", "Spinone Italiano", "Stabyhoun", "Swedish Vallhund", "Taiwan Dog", 
        "Airedale Terrier", "American Hairless Terrier", "American Staffordshire Terrier", 
        "Australian Terrier", "Bedlington Terrier", "Border Terrier", "Biewer Terrier", 
        "Black Russian Terrier", "Cairn Terrier", "Cesky Terrier", "Dandie Dinmont Terrier", 
        "Glen of Imaal Terrier", "Irish Terrier", "Jagdterrier", "Japanese Terrier", 
        "Kerry Blue Terrier", "Lakeland Terrier", "Norfolk Terrier", "Norwich Terrier", 
        "Parson Russell Terrier", "Rat Terrier", "Jack Russell Terrier", "Scottish Terrier", 
        "Silky Terrier", "Skye Terrier", "Smooth Fox Terrier", "Soft Coated Wheaten Terrier", 
        "Teddy Roosevelt Terrier", "Tibetan Terrier", "Toy Fox Terrier", "Welsh Terrier", 
        "West Highland White Terrier", "Wire Fox Terrier", "Thai Ridgeback", "Tornjak", "Tosa"
    ];

    let currentBreeds = [];
    let selectedBreed = '';

    // Initialize breed options on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateBreedOptions();
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('breedDropdown');
            const display = document.getElementById('breedDisplay');
            if (!dropdown.contains(event.target) && !display.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });

    // Update breed options based on patient type
    function updateBreedOptions() {
        const patientType = document.getElementById('patient_type').value;
        const breedLabel = document.getElementById('breed_label');
        const singleBreedOptions = document.getElementById('singleBreedOptions');
        
        if (patientType === 'male_cat' || patientType === 'female_cat') {
            currentBreeds = catBreedsList;
            breedLabel.innerHTML = 'Breed <span class="text-red-500">*</span>';
        } else if (patientType === 'male_dog' || patientType === 'female_dog') {
            currentBreeds = dogBreedsList;
            breedLabel.innerHTML = 'Breed <span class="text-red-500">*</span>';
        } else {
            currentBreeds = [];
            breedLabel.innerHTML = 'Breed <span class="text-red-500">*</span>';
        }
        
        renderBreedOptions();
    }

    // Render breed options
    function renderBreedOptions(filter = '') {
        const singleBreedOptions = document.getElementById('singleBreedOptions');
        singleBreedOptions.innerHTML = '';
        
        const filteredBreeds = currentBreeds.filter(breed => 
            breed.toLowerCase().includes(filter.toLowerCase())
        );
        
        filteredBreeds.forEach(breed => {
            const label = document.createElement('label');
            label.className = 'dropdown-option flex items-center px-4 py-2 cursor-pointer hover:bg-gray-100';
            
            const checkbox = document.createElement('input');
            checkbox.type = 'radio';
            checkbox.name = 'breed_option';
            checkbox.value = breed;
            checkbox.className = 'mr-3 h-4 w-4 text-primary';
            checkbox.onclick = function() {
                selectBreed(breed);
            };
            
            if (selectedBreed === breed) {
                checkbox.checked = true;
                label.classList.add('selected', 'bg-green-50');
            }
            
            label.appendChild(checkbox);
            label.appendChild(document.createTextNode(breed));
            singleBreedOptions.appendChild(label);
        });
    }

    // Toggle breed dropdown
    function toggleBreedDropdown() {
        const dropdown = document.getElementById('breedDropdown');
        dropdown.classList.toggle('hidden');
        
        if (!dropdown.classList.contains('hidden')) {
            document.getElementById('breedSearch').focus();
        }
    }

    // Filter breeds based on search
    function filterBreeds() {
        const searchValue = document.getElementById('breedSearch').value;
        renderBreedOptions(searchValue);
    }

    // Select a breed
    function selectBreed(breed) {
        selectedBreed = breed;
        
        // Update display
        const displayText = document.getElementById('selectedBreedText');
        displayText.textContent = breed;
        displayText.classList.remove('text-gray-500');
        displayText.classList.add('text-gray-900');
        
        // Update hidden input
        document.getElementById('breedInput').value = breed;
        
        // Close dropdown
        document.getElementById('breedDropdown').classList.add('hidden');
        
        // Re-render to show selected state
        renderBreedOptions();
    }

    // Dynamic patient type handling
    document.getElementById('patient_type').addEventListener('change', function() {
        // Reset breed selection when patient type changes
        selectedBreed = '';
        document.getElementById('selectedBreedText').textContent = 'Select a breed';
        document.getElementById('selectedBreedText').classList.add('text-gray-500');
        document.getElementById('selectedBreedText').classList.remove('text-gray-900');
        document.getElementById('breedInput').value = '';
        document.getElementById('breedSearch').value = '';
        
        updateBreedOptions();
        
        const patientType = this.value;
        const petCountLabel = document.getElementById('pet_count_label');
        
        if (patientType === 'male_cat' || patientType === 'female_cat') {
            if (patientType === 'male_cat') {
                petCountLabel.innerHTML = 'How many male cats? <span class="text-red-500">*</span>';
            } else {
                petCountLabel.innerHTML = 'How many female cats? <span class="text-red-500">*</span>';
            }
        } else if (patientType === 'male_dog' || patientType === 'female_dog') {
            if (patientType === 'male_dog') {
                petCountLabel.innerHTML = 'How many male dogs? <span class="text-red-500">*</span>';
            } else {
                petCountLabel.innerHTML = 'How many female dogs? <span class="text-red-500">*</span>';
            }
        }
    });
</script>

</body>
</html>
