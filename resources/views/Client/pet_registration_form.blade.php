<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Registration Form - Dasmariñas City Veterinary Services</title>
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
                            <hr class="my-2 border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex space-x-4">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-primary font-medium hover:bg-gray-100 rounded-lg transition-colors">Log In</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-primary-light transition-colors">Register</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Page Title -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Pet Registration</h2>
            <p class="text-gray-600 mt-2">Register your pet with Dasmariñas City Veterinary Services</p>
            <p class="text-gray-500 text-sm mt-1">Fields marked with <span class="text-red-500">*</span> are required</p>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <form id="petRegistrationForm" method="POST" action="{{ url('/pet-registration/form') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Profile Picture Section -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Profile Picture</label>
                    <div class="flex items-center space-x-6">
                        <!-- Placeholder Image (Dog with Cat) -->
                        <div class="shrink-0">
                            <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-primary-light relative">
                                <img id="petImagePreview" src="{{ asset('images/pet.png') }}" alt="Pet Profile" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all flex items-center justify-center cursor-pointer" onclick="document.getElementById('petImage').click()">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white opacity-0 hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <input type="file" id="petImage" name="pet_image" accept="image/*" class="hidden" onchange="previewImage(event)">
                        <div>
                            <p class="text-sm text-gray-600">Upload a photo of your pet</p>
                            <p class="text-xs text-gray-400">Click the image to upload</p>
                        </div>
                    </div>
                </div>

                <!-- Pet Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Pet's Name <span class="text-red-500">*</span></label>
                    <input type="text" name="pet_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Enter your pet's name">
                </div>

                <!-- Pet Type -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">What kind of pet do you have? <span class="text-red-500">*</span></label>
                    <div class="flex space-x-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="pet_type" value="dog" class="form-radio h-5 w-5 text-primary" onchange="updateBreedOptions()">
                            <span class="ml-3 text-gray-700 font-medium">Dog</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="pet_type" value="cat" class="form-radio h-5 w-5 text-primary" onchange="updateBreedOptions()">
                            <span class="ml-3 text-gray-700 font-medium">Cat</span>
                        </label>
                    </div>
                </div>

                <!-- Gender -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Gender <span class="text-red-500">*</span></label>
                    <div class="flex space-x-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="gender" value="male" class="form-radio h-5 w-5 text-primary">
                            <span class="ml-3 text-gray-700 font-medium">Male</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="gender" value="female" class="form-radio h-5 w-5 text-primary">
                            <span class="ml-3 text-gray-700 font-medium">Female</span>
                        </label>
                    </div>
                </div>

                <!-- Neutered Checkbox -->
                <div class="mb-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="isNeutered" name="is_neutered" class="form-checkbox h-5 w-5 text-primary rounded">
                        <span class="ml-3 text-gray-700 font-medium">My pet is neutered</span>
                    </label>
                </div>

                <hr class="border-gray-300 mb-6">

                <!-- Crossbreed Checkbox -->
                <div class="mb-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="isCrossbreed" name="is_crossbreed" class="form-checkbox h-5 w-5 text-primary rounded" onchange="toggleCrossbreed()">
                        <span class="ml-3 text-gray-700 font-medium">My pet is a crossbreed</span>
                    </label>
                </div>

                <!-- Pet Breed -->
                <div class="mb-6" id="breedSection">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Pet Breed <span class="text-red-500">*</span>
                        <span id="breedLimitText" class="text-xs text-gray-500 font-normal ml-1">(select one)</span>
                    </label>
                    
                    <!-- Dropdown trigger and container -->
                    <div class="relative">
                        <!-- Display selected breed (click to open) -->
                        <div id="breedDisplay" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-gray-400" onclick="toggleBreedDropdown()">
                            <span id="selectedBreedText" class="text-gray-500">Select a breed</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        
                        <!-- Dropdown menu -->
                        <div id="breedDropdown" class="hidden absolute z-10 w-full mt-1 border border-gray-300 rounded-lg bg-white shadow-lg max-h-64">
                            <!-- Search inside dropdown -->
                            <div class="p-2 border-b border-gray-200">
                                <input type="text" id="breedSearch" placeholder="Search breed..." class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-primary" onkeyup="filterBreeds()" onclick="event.stopPropagation()">
                            </div>
                            
                            <!-- Options -->
                            <div id="breedOptions" class="max-h-48 overflow-y-auto py-1">
                                <!-- Single breed mode - checkboxes -->
                                <div id="singleBreedOptions">
                                    <!-- Options populated by JS -->
                                </div>
                                
                                <!-- Crossbreed mode - checkboxes -->
                                <div id="crossbreedOptions" class="hidden">
                                    <!-- Options populated by JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden input for breed -->
                    <input type="hidden" id="petBreedInput" name="pet_breed" value="">
                    
                    <!-- Display selected breed tags -->
                    <div id="selectedBreedDisplay" class="mt-3 hidden">
                        <div class="flex flex-wrap gap-2" id="selectedBreedTags"></div>
                    </div>
                </div>

                <!-- I know my pet's birthdate -->
                <div class="mb-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="knowBirthdate" name="know_birthdate" class="form-checkbox h-5 w-5 text-primary rounded" onchange="toggleBirthdate()">
                        <span class="ml-3 text-gray-700 font-medium">I know my pet's birthdate</span>
                    </label>
                </div>

                <!-- Pet's Birthdate (shown if checkbox is checked) -->
                <div id="birthdateSection" class="mb-6 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pet's Birthdate</label>
                    <input type="date" id="petBirthdate" name="pet_birthdate" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>

                <!-- Estimated Pet Age (shown if birthdate is NOT checked) -->
                <div id="ageSection" class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Pet Age <span class="text-red-500">*</span></label>
                    <select id="estimatedAge" name="estimated_age" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Select estimated age</option>
                        <option value="less_than_3_months">Less than 3 months old</option>
                        <option value="3_to_12_months">3 to 12 months old</option>
                        <option value="1_year">1 year old</option>
                        <option value="2_years">2 years old</option>
                        <option value="3_years">3 years old</option>
                        <option value="4_years">4 years old</option>
                        <option value="5_years">5 years old</option>
                        <option value="6_years">6 years old</option>
                        <option value="7_years">7 years old</option>
                        <option value="8_years">8 years old</option>
                        <option value="9_years">9 years old</option>
                        <option value="10_years">10 years old</option>
                        <option value="11_years">11 years old</option>
                        <option value="12_years">12 years old</option>
                        <option value="13_years">13 years old</option>
                        <option value="14_years">14 years old</option>
                        <option value="15_years">15 years old</option>
                        <option value="16_years">16 years old</option>
                        <option value="17_years">17 years old</option>
                        <option value="18_years">18 years old</option>
                        <option value="19_years">19 years old</option>
                        <option value="20_years">20 years old</option>
                    </select>
                </div>

                <!-- Pet Weight -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pet's Weight <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" id="petWeight" name="pet_weight" class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Enter weight" maxlength="3" oninput="updateWeightSuffix(); validateWeight(this)">
                        <span id="weightSuffix" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium pointer-events-none hidden">kg</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">If you do not know, type "N/A"</p>
                </div>

                <hr class="border-gray-300 mb-6">

                <h3 class="text-lg font-semibold text-gray-900 mb-6">Additional Information</h3>

                <!-- Unique Body Mark -->

                <!-- Unique Body Mark -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unique Body Mark</label>
                    <div class="flex items-center space-x-4">
                        <input type="file" id="bodyMarkImage" name="body_mark_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-light" onchange="previewBodyMark(event)">
                    </div>
                </div>

                <!-- Body Mark Details -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Body Mark Details</label>
                    <textarea id="bodyMarkDetails" name="body_mark_details" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Describe any unique marks, scars, or distinguishing features..."></textarea>
                </div>

                <!-- Pet Attributes based on type -->
                <div id="petAttributesSection" class="mb-6">
                    <!-- Training -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Training</label>
                        <div class="flex flex-wrap gap-2" id="trainingOptions">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Insurance -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Insurance</label>
                        <div class="flex flex-wrap gap-2" id="insuranceOptions">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Behavior -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Behavior</label>
                        <div class="flex flex-wrap gap-2" id="behaviorOptions">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Likes (max 5) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Likes <span class="text-xs text-gray-500 font-normal">(You can pick up to 5)</span>
                        </label>
                        <div class="flex flex-wrap gap-2" id="likesOptions">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Dislikes -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dislikes</label>
                        <div class="flex flex-wrap gap-2" id="dislikesOptions">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <!-- Diet (max 5) -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Diet <span class="text-xs text-gray-500 font-normal">(You can pick up to 5)</span>
                        </label>
                        <div class="flex flex-wrap gap-2" id="dietOptions">
                            <!-- Populated by JS -->
                        </div>
                        <button type="button" id="dietShowMore" class="mt-2 text-sm text-primary hover:underline hidden" onclick="showMoreDiet()">Show More</button>
                    </div>

                    <!-- Allergy -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Allergy</label>
                        <div class="flex flex-wrap gap-2" id="allergyOptions">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                </div>

                <!-- Register Button -->
                <div class="text-center space-y-4">
                    <button type="button" onclick="showConfirmModal()" class="px-12 py-4 bg-primary text-white font-semibold rounded-xl text-lg hover:bg-primary-light transition-colors shadow-md hover:shadow-lg">
                        Register
                    </button>
                    <div>
                        <a href="{{ url('/pet-registration') }}" class="inline-block text-gray-600 hover:text-primary transition-colors">
                            ← Back to Pet Registration
                        </a>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-sm">&copy; 2026 Dasmariñas City Veterinary Services. All rights reserved.</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">Contact Us</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Cat breeds list
        const catBreeds = [
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
        const dogBreeds = [
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
            "West Highland White Terrier", "Wire Fox Terrier", "Thai Ridgeback", "Tornjak", "Tosa", 
            "Treeing Tennessee Brindle", "Vizsla", "Volpino Italiano", "Portuguese Water Dog", 
            "Spanish Water Dog", "Weimaraner", "Wetterhoun", "Whippet", "Wirehaired Pointing Griffon", 
            "Wirehaired Vizsla", "Working Kelpie", "Xoloitzcuintli", "Yakutian Laika", "Yorkshire Terrier", 
            "Unknown"
        ];

        let selectedBreeds = [];
        let currentPetType = '';

        // Toggle breed dropdown
        function toggleBreedDropdown() {
            const dropdown = document.getElementById('breedDropdown');
            dropdown.classList.toggle('hidden');
            
            // Populate options if not already done
            if (!dropdown.classList.contains('hidden') && currentPetType) {
                updateBreedOptions();
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('breedDropdown');
            const display = document.getElementById('breedDisplay');
            if (!dropdown.contains(e.target) && !display.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Update breed options based on pet type
        function updateBreedOptions() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            currentPetType = petType ? petType.value : '';
            
            const isCrossbreed = document.getElementById('isCrossbreed').checked;
            const singleOptions = document.getElementById('singleBreedOptions');
            const crossOptions = document.getElementById('crossbreedOptions');
            const breedLimitText = document.getElementById('breedLimitText');

            // Clear previous selections
            selectedBreeds = [];
            updateSelectedBreedDisplay();

            if (!currentPetType) {
                singleOptions.innerHTML = '';
                crossOptions.innerHTML = '';
                return;
            }

            const breeds = currentPetType === 'cat' ? catBreeds : dogBreeds;

            if (isCrossbreed) {
                // Crossbreed mode - checkbox style, max 2
                breedLimitText.textContent = '(maximum of 2)';
                singleOptions.classList.add('hidden');
                crossOptions.classList.remove('hidden');
                
                // Populate checkboxes
                crossOptions.innerHTML = breeds.map(breed => `
                    <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                        <input type="checkbox" value="${breed}" class="pet-breed-checkbox h-4 w-4 text-primary rounded border-gray-300" onchange="handleBreedCheckbox(this)">
                        <span class="ml-3 text-sm text-gray-700">${breed}</span>
                    </label>
                `).join('');
            } else {
                // Single breed mode - radio buttons
                breedLimitText.textContent = '(select one)';
                singleOptions.classList.remove('hidden');
                crossOptions.classList.add('hidden');
                
                // Populate radio options
                singleOptions.innerHTML = breeds.map(breed => `
                    <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                        <input type="radio" name="breed_option" value="${breed}" class="pet-breed-radio h-4 w-4 text-primary border-gray-300" onchange="handleSingleBreedSelect('${breed}')">
                        <span class="ml-3 text-sm text-gray-700">${breed}</span>
                    </label>
                `).join('');
            }
        }

        // Toggle crossbreed mode
        function toggleCrossbreed() {
            const isCrossbreed = document.getElementById('isCrossbreed').checked;
            
            // Clear selections when toggling
            selectedBreeds = [];
            updateSelectedBreedDisplay();
            
            updateBreedOptions();
        }

        // Handle breed checkbox selection
        function handleBreedCheckbox(checkbox) {
            const breed = checkbox.value;
            
            if (checkbox.checked) {
                if (selectedBreeds.length >= 2) {
                    checkbox.checked = false;
                    alert('Maximum of 2 breeds allowed');
                    return;
                }
                selectedBreeds.push(breed);
            } else {
                selectedBreeds = selectedBreeds.filter(b => b !== breed);
            }
            
            updateSelectedBreedDisplay();
        }

        // Handle single breed selection
        function handleSingleBreedSelect(breed) {
            selectedBreeds = [breed];
            
            // Update hidden input
            document.getElementById('petBreedInput').value = breed;
            
            // Update display text
            document.getElementById('selectedBreedText').textContent = breed;
            document.getElementById('selectedBreedText').classList.remove('text-gray-500');
            document.getElementById('selectedBreedText').classList.add('text-gray-900');
            
            // Close dropdown
            document.getElementById('breedDropdown').classList.add('hidden');
            
            updateSelectedBreedDisplay();
        }

        // Update selected breed display
        function updateSelectedBreedDisplay() {
            const display = document.getElementById('selectedBreedDisplay');
            const tags = document.getElementById('selectedBreedTags');
            
            if (selectedBreeds.length === 0) {
                display.classList.add('hidden');
                document.getElementById('petBreedInput').value = '';
                return;
            }
            
            display.classList.remove('hidden');
            tags.innerHTML = selectedBreeds.map(breed => `
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary text-white">
                    ${breed}
                    <button type="button" onclick="removeBreed('${breed}')" class="ml-2 hover:text-red-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </span>
            `).join('');
            
            // Also update the display text
            document.getElementById('selectedBreedText').textContent = selectedBreeds.join(', ');
            document.getElementById('selectedBreedText').classList.remove('text-gray-500');
            document.getElementById('selectedBreedText').classList.add('text-gray-900');
            
            // Update hidden input
            document.getElementById('petBreedInput').value = selectedBreeds.join(', ');
        }

        // Remove breed from selection
        function removeBreed(breed) {
            const isCrossbreed = document.getElementById('isCrossbreed').checked;
            
            selectedBreeds = selectedBreeds.filter(b => b !== breed);
            
            if (isCrossbreed) {
                // Uncheck the checkbox
                const checkboxes = document.querySelectorAll('.pet-breed-checkbox');
                checkboxes.forEach(cb => {
                    if (cb.value === breed) {
                        cb.checked = false;
                    }
                });
            } else {
                // Uncheck the radio
                const radios = document.querySelectorAll('.pet-breed-radio');
                radios.forEach(r => {
                    if (r.value === breed) {
                        r.checked = false;
                    }
                });
                
                // Update display text
                if (selectedBreeds.length === 0) {
                    document.getElementById('selectedBreedText').textContent = 'Select a breed';
                    document.getElementById('selectedBreedText').classList.remove('text-gray-900');
                    document.getElementById('selectedBreedText').classList.add('text-gray-500');
                }
            }
            
            updateSelectedBreedDisplay();
        }

        // Filter breeds based on search
        function filterBreeds() {
            const search = document.getElementById('breedSearch').value.toLowerCase();
            const isCrossbreed = document.getElementById('isCrossbreed').checked;
            
            if (isCrossbreed) {
                const checkboxes = document.querySelectorAll('#crossbreedOptions label');
                checkboxes.forEach(label => {
                    const text = label.textContent.toLowerCase();
                    label.style.display = text.includes(search) ? 'flex' : 'none';
                });
            } else {
                const radios = document.querySelectorAll('#singleBreedOptions label');
                radios.forEach(label => {
                    const text = label.textContent.toLowerCase();
                    label.style.display = text.includes(search) ? 'flex' : 'none';
                });
            }
        }

        // Preview body mark image
        function previewBodyMark(event) {
            const file = event.target.files[0];
            if (file) {
                // Image preview would go here if needed
            }
        }

        // Cat attributes data
        const catTraining = ['Obedience-trained', 'Potty-trained'];
        const catInsurance = ['Insured'];
        const catBehavior = ['Independent', 'Curious', 'Territorial', 'Play-biter', 'Affectionate', 'Nocturnal', 'Skittish', 'Hunter', 'Catnip lover', 'Social', 'Shy', 'Friendly', 'Gentle', 'Perching'];
        const catLikes = ['Cuddle time', 'Playing with yarn', 'Sunbathing by the window', 'Treats', 'Puzzle toys', 'Cardboard boxes', 'Chasing mice toys', 'Feather wands', 'Catnip lover', 'Gentle Petting', 'Bunting', 'Climbing'];
        const catDislikes = ['Water/Baths', 'Car rides', 'Vacuum cleaners', 'Strong wind', 'Loud noises/Fireworks', 'Vet visits', 'Being trapped in a room', 'Wearing clothes', 'Being ignored', 'Too much handling'];
        const catDiet = ['Kibbles', 'Chicken', 'Beef', 'Turkey', 'Pork', 'Carrots', 'Sweet potatoes', 'Broccoli', 'Eggs', 'Cheese'];
        const catDietMore = ['Venison', 'Lamb', 'Bison', 'Shrimp', 'Tuna', 'Salmon', 'Catnip', 'Sardines', 'Mackerel', 'Apple', 'Banana', 'Pears', 'Blueberry', 'Strawberry', 'Raspberry', 'Cranberry', 'Watermelon', 'Pineapple', 'Pumpkin', 'Potato', 'Horseradish', 'Celery', 'Beets', 'Green beans', 'Peas', 'Spinach', 'Peanut butter', 'Nutribowl'];
        const catAllergy = ['Corn', 'Dairy', 'Pork', 'Beef', 'Chicken', 'Lamb', 'Shrimp', 'Tuna', 'Salmon', 'Tailored treats preferred'];

        // Dog attributes data
        const dogTraining = ['Obedience-trained', 'Potty-trained'];
        const dogInsurance = ['Insured'];
        const dogBehavior = ['Friendly', 'Playful', 'Shy', 'Affectionate', 'Social', 'Reactive', 'Energetic', 'Gentle', 'Loyal', 'Protective', 'Anxious', 'Territorial', 'Play-biter', 'Grumpy'];
        const dogLikes = ['Playing fetch', 'Chew toys', 'Gentle petting', 'Long walks', 'Treats', 'Cuddle', 'Belly rub', 'Cuddle time', 'Splashing in water', 'Adventures/Outings', 'Puzzle toys', 'Socializing with other dogs', 'Sunbathing'];
        const dogDislikes = ['Baths', 'Vacuum cleaners', 'Thunderstorms', 'Car rides', 'Loud noises/Fireworks', 'Vet visits', 'Wearing clothes', 'Being ignored', 'Too much handling'];
        const dogDiet = ['Kibbles', 'Chicken', 'Beef', 'Turkey', 'Pork', 'Carrots', 'Sweet potatoes', 'Broccoli', 'Eggs', 'Cheese'];
        const dogDietMore = ['Venison', 'Lamb', 'Duck', 'Tripe', 'Liver', 'Bison', 'Apple', 'Banana', 'Pears', 'Blueberry', 'Strawberry', 'Raspberry', 'Cranberry', 'Watermelon', 'Pineapple', 'Pumpkin', 'Potato', 'Horseradish', 'Celery', 'Beets', 'Green beans', 'Peas', 'Spinach', 'Peanut butter', 'Nutribowl'];
        const dogAllergy = ['Chicken', 'Beef', 'Lamb', 'Pork', 'Soy', 'Wheat', 'Eggs', 'Dairy', 'Tailored treats preferred'];

        // Selected attributes
        let selectedLikes = [];
        let selectedDiet = [];
        let dietExpanded = false;

        // Create pill button
        function createPillButton(name, value, category, maxSelect = null) {
            const id = `${category}_${value.replace(/[^a-zA-Z0-9]/g, '')}`;
            return `
                <label class="inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="${id}" name="${name}[]" value="${value}" class="pill-checkbox hidden" data-category="${category}" data-value="${value}" ${maxSelect ? `data-max="${maxSelect}"` : ''} onchange="handlePillChange(this)">
                    <span id="${id}_label" class="px-3 py-1 text-sm rounded-full border border-gray-300 text-gray-700 hover:border-primary transition-colors">${value}</span>
                </label>
            `;
        }

        // Handle pill button change
        function handlePillChange(checkbox) {
            const category = checkbox.dataset.category;
            const value = checkbox.dataset.value;
            const label = document.getElementById(`${checkbox.id}_label`);
            const maxSelect = checkbox.dataset.max ? parseInt(checkbox.dataset.max) : null;

            if (checkbox.checked) {
                // Check if max reached
                if (maxSelect) {
                    const currentSelected = document.querySelectorAll(`input[data-category="${category}"]:checked`);
                    if (currentSelected.length > maxSelect) {
                        checkbox.checked = false;
                        alert(`You can only select up to ${maxSelect} options`);
                        return;
                    }
                }
                
                // Update styling
                label.classList.remove('border-gray-300', 'text-gray-700');
                label.classList.add('bg-primary', 'text-white', 'border-primary');
                
                // Add to selected array
                if (category === 'likes') {
                    selectedLikes.push(value);
                } else if (category === 'diet') {
                    selectedDiet.push(value);
                }
            } else {
                // Remove styling
                label.classList.remove('bg-primary', 'text-white', 'border-primary');
                label.classList.add('border-gray-300', 'text-gray-700');
                
                // Remove from selected array
                if (category === 'likes') {
                    selectedLikes = selectedLikes.filter(v => v !== value);
                } else if (category === 'diet') {
                    selectedDiet = selectedDiet.filter(v => v !== value);
                }
            }
            
            // Gray out remaining options if max reached
            if (maxSelect) {
                const allCheckboxes = document.querySelectorAll(`input[data-category="${category}"]`);
                const checkedCount = document.querySelectorAll(`input[data-category="${category}"]:checked`).length;
                
                allCheckboxes.forEach(cb => {
                    const cbLabel = document.getElementById(`${cb.id}_label`);
                    if (!cb.checked && checkedCount >= maxSelect) {
                        cbLabel.classList.add('opacity-50', 'cursor-not-allowed');
                    } else if (!cb.checked) {
                        cbLabel.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                });
            }
        }

        // Populate pet attributes based on type
        function populatePetAttributes() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            const type = petType ? petType.value : '';
            
            // Reset selections
            selectedLikes = [];
            selectedDiet = [];
            dietExpanded = false;
            
            if (!type) {
                document.getElementById('trainingOptions').innerHTML = '';
                document.getElementById('insuranceOptions').innerHTML = '';
                document.getElementById('behaviorOptions').innerHTML = '';
                document.getElementById('likesOptions').innerHTML = '';
                document.getElementById('dislikesOptions').innerHTML = '';
                document.getElementById('dietOptions').innerHTML = '';
                document.getElementById('allergyOptions').innerHTML = '';
                document.getElementById('dietShowMore').classList.add('hidden');
                return;
            }
            
            const isCat = type === 'cat';
            const training = isCat ? catTraining : dogTraining;
            const insurance = isCat ? catInsurance : dogInsurance;
            const behavior = isCat ? catBehavior : dogBehavior;
            const likes = isCat ? catLikes : dogLikes;
            const dislikes = isCat ? catDislikes : dogDislikes;
            const diet = isCat ? catDiet : dogDiet;
            const dietMore = isCat ? catDietMore : dogDietMore;
            const allergy = isCat ? catAllergy : dogAllergy;
            
            // Training
            document.getElementById('trainingOptions').innerHTML = training.map(v => createPillButton('training', v, 'training')).join('');
            
            // Insurance
            document.getElementById('insuranceOptions').innerHTML = insurance.map(v => createPillButton('insurance', v, 'insurance')).join('');
            
            // Behavior
            document.getElementById('behaviorOptions').innerHTML = behavior.map(v => createPillButton('behavior', v, 'behavior')).join('');
            
            // Likes (max 5)
            document.getElementById('likesOptions').innerHTML = likes.map(v => createPillButton('likes', v, 'likes', 5)).join('');
            
            // Dislikes
            document.getElementById('dislikesOptions').innerHTML = dislikes.map(v => createPillButton('dislikes', v, 'dislikes')).join('');
            
            // Diet (max 5)
            document.getElementById('dietOptions').innerHTML = diet.map(v => createPillButton('diet', v, 'diet', 5)).join('');
            
            // Show More button for diet
            const showMoreBtn = document.getElementById('dietShowMore');
            showMoreBtn.classList.remove('hidden');
            showMoreBtn.textContent = 'Show More';
            showMoreBtn.onclick = showMoreDiet;
            
            // Allergy
            document.getElementById('allergyOptions').innerHTML = allergy.map(v => createPillButton('allergy', v, 'allergy')).join('');
        }

        // Show more diet options
        function showMoreDiet() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            const type = petType ? petType.value : '';
            const dietMore = type === 'cat' ? catDietMore : dogDietMore;
            
            const dietContainer = document.getElementById('dietOptions');
            const showMoreBtn = document.getElementById('dietShowMore');
            
            if (!dietExpanded) {
                // Add more options
                dietContainer.innerHTML += dietMore.map(v => createPillButton('diet', v, 'diet', 5)).join('');
                showMoreBtn.textContent = 'Show Less';
                dietExpanded = true;
            } else {
                // Remove extra options and keep only original
                const originalDiet = type === 'cat' ? catDiet : dogDiet;
                
                // Uncheck and remove options not in original
                document.querySelectorAll('#dietOptions .pill-checkbox').forEach(cb => {
                    if (!originalDiet.includes(cb.dataset.value)) {
                        const label = document.getElementById(`${cb.id}_label`);
                        label.classList.remove('bg-primary', 'text-white', 'border-primary', 'opacity-50', 'cursor-not-allowed');
                        label.classList.add('border-gray-300', 'text-gray-700');
                        cb.checked = false;
                        cb.parentElement.remove();
                    }
                });
                
                showMoreBtn.textContent = 'Show More';
                dietExpanded = false;
            }
        }

        // Add event listener to pet type radio buttons
        document.querySelectorAll('input[name="pet_type"]').forEach(radio => {
            radio.addEventListener('change', function() {
                updateBreedOptions();
                populatePetAttributes();
            });
        });

        // Toggle birthdate section
        function toggleBirthdate() {
            const knowBirthdate = document.getElementById('knowBirthdate').checked;
            const birthdateSection = document.getElementById('birthdateSection');
            const ageSection = document.getElementById('ageSection');
            
            if (knowBirthdate) {
                birthdateSection.classList.remove('hidden');
                ageSection.classList.add('hidden');
            } else {
                birthdateSection.classList.add('hidden');
                ageSection.classList.remove('hidden');
            }
        }
        
        // Update weight suffix based on input
        function updateWeightSuffix() {
            const input = document.getElementById('petWeight');
            const suffix = document.getElementById('weightSuffix');
            const value = input.value.trim().toUpperCase();
            
            // Show kg suffix if there's a valid number, hide if empty or N/A
            if (value === '' || value === 'N/A') {
                suffix.classList.add('hidden');
            } else {
                suffix.classList.remove('hidden');
            }
        }
        
        // Validate weight input - only numbers, max 3 digits
        function validateWeight(input) {
            input.value = input.value.replace(/[^0-9]/g, '');
            if (input.value.length > 3) {
                input.value = input.value.slice(0, 3);
            }
        }

        // Preview uploaded image
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('petImagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        // Toggle user dropdown
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const button = e.target.closest('button');
            if (!button || !button.onclick?.toString().includes('toggleDropdown')) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            }
        });
    </script>
    
    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Registration</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to register this pet? Please review all information before submitting.</p>
                <div class="flex gap-4 justify-center">
                    <button onclick="closeConfirmModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button onclick="submitPetForm()" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                        Confirm & Register
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function showConfirmModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
        }
        
        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }
        
        function submitPetForm() {
            document.getElementById('petRegistrationForm').submit();
        }
    </script>
</body>
</html>
