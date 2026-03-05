<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anti-Rabies Vaccination Form - Dasmariñas City Veterinary Services</title>
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
                    <a href="{{ url('/adoption') }}" class="text-gray-600 hover:text-primary font-medium transition-colors">Adoption</a>
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
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Anti-Rabies Vaccination</h2>
                <p class="text-gray-500 text-sm mt-1">Fields marked with <span class="text-red-500">*</span> are required</p>
                <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <span class="font-semibold">Vaccine services are offered Monday to Friday.</span> 
                        Our staff will contact you to finalize your appointment schedule.
                    </p>
                </div>
            </div>

            <form id="vaccinationForm" method="POST" action="{{ url('/vaccination/form') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Appointment Date -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Appointment Date</label>
                    <input type="date" name="appointment_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>

                <hr class="border-gray-300 mb-6">

                <!-- A. Owner's Info -->
                <h3 class="text-lg font-semibold text-gray-900 mb-6">A. Owner's Info</h3>
                
                <!-- Pet Owner's Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pet Owner's Name <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">First Name</label>
                            <input type="text" name="owner_first_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="First Name">
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">Last Name</label>
                            <input type="text" name="owner_last_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Last Name">
                        </div>
                    </div>
                </div>

                <!-- Email and Contact Number -->
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="owner_email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="email@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contact Number <span class="text-red-500">*</span></label>
                            <input type="text" name="owner_contact" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Contact Number">
                        </div>
                    </div>
                </div>

                <!-- Complete Home Address -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Complete Home Address <span class="text-red-500">*</span></label>
                    <textarea name="owner_address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Complete Home Address"></textarea>
                </div>

                <hr class="border-gray-300 mb-6">

                <!-- B. Pet's Info -->
                <h3 class="text-lg font-semibold text-gray-900 mb-6">B. Pet's Info</h3>

                <!-- Pet's Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pet's Name <span class="text-red-500">*</span></label>
                    <input type="text" name="pet_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Enter your pet's name">
                </div>

                <!-- Species and Gender -->
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Species <span class="text-red-500">*</span></label>
                            <select name="pet_species" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" onchange="updateBreedOptions()">
                                <option value="">Select species</option>
                                <option value="dog">Dog</option>
                                <option value="cat">Cat</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gender <span class="text-red-500">*</span></label>
                            <select name="pet_gender" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="">Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Breed -->
                <div class="mb-6" id="breedSection">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Breed <span class="text-red-500">*</span>
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
                                <!-- Options populated by JS -->
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden input to store selected breed -->
                    <input type="hidden" id="selectedBreed" name="pet_breed" value="">
                </div>

                <!-- Age -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Age <span class="text-red-500">*</span></label>
                    <select name="pet_age" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
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

                <hr class="border-gray-300 mb-6">

                <!-- C. Vet Records -->
                <h3 class="text-lg font-semibold text-gray-900 mb-6">C. Vet Records</h3>

                <!-- Date of Last Anti-Rabies -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Last Anti-Rabies</label>
                    <input type="date" name="last_anti_rabies_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>

                <hr class="border-gray-300 mb-6">

                <!-- D. Other Health Information -->
                <h3 class="text-lg font-semibold text-gray-900 mb-6">D. Other Health Information</h3>

                <!-- Surgery Question -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Did your pet undergo any surgery in the last two (2) weeks? <span class="text-red-500">*</span></label>
                    <div class="flex space-x-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="recent_surgery" value="yes" class="form-radio h-5 w-5 text-primary">
                            <span class="ml-3 text-gray-700 font-medium">Yes</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="recent_surgery" value="no" class="form-radio h-5 w-5 text-primary">
                            <span class="ml-3 text-gray-700 font-medium">No</span>
                        </label>
                    </div>
                </div>

                <!-- Confirmation Checkbox -->
                <div class="mb-8">
                    <label class="inline-flex items-start cursor-pointer">
                        <input type="checkbox" name="confirmation" class="form-checkbox h-5 w-5 text-primary rounded mt-1">
                        <span class="ml-3 text-gray-700 text-sm">
                            By confirming, you acknowledge that the provided information is accurate and that your pet will be available for vaccination on the selected date. <span class="text-red-500">*</span>
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary-light transition-colors shadow-md hover:shadow-lg">
                        Submit
                    </button>
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

        // Dog breeds list
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

        let selectedBreed = '';

        // Toggle breed dropdown
        function toggleBreedDropdown() {
            const dropdown = document.getElementById('breedDropdown');
            dropdown.classList.toggle('hidden');
            
            // Populate options if not already done
            if (!dropdown.classList.contains('hidden')) {
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

        // Update breed options based on species
        function updateBreedOptions() {
            const speciesSelect = document.querySelector('select[name="pet_species"]');
            const currentSpecies = speciesSelect ? speciesSelect.value : '';
            const breedOptions = document.getElementById('breedOptions');
            
            let breeds = [];
            if (currentSpecies === 'cat') {
                breeds = catBreeds;
            } else if (currentSpecies === 'dog') {
                breeds = dogBreeds;
            } else {
                breeds = [...dogBreeds, ...catBreeds];
            }
            
            // Sort breeds alphabetically
            breeds.sort();
            
            // Generate HTML for breed options
            breedOptions.innerHTML = breeds.map(breed => 
                `<div class="dropdown-option px-4 py-2 cursor-pointer hover:bg-gray-100 ${selectedBreed === breed ? 'selected bg-green-50' : ''}" 
                     onclick="selectBreed('${breed.replace(/'/g, "\\'")}')">
                    ${breed}
                </div>`
            ).join('');
        }

        // Select a breed
        function selectBreed(breed) {
            selectedBreed = breed;
            document.getElementById('selectedBreedText').textContent = breed;
            document.getElementById('selectedBreed').value = breed;
            document.getElementById('breedDropdown').classList.add('hidden');
            updateBreedOptions(); // Update visual selection
        }

        // Filter breeds based on search
        function filterBreeds() {
            const searchInput = document.getElementById('breedSearch');
            const filter = searchInput.value.toLowerCase();
            const breedOptions = document.getElementById('breedOptions');
            const options = breedOptions.getElementsByClassName('dropdown-option');
            
            for (let i = 0; i < options.length; i++) {
                const text = options[i].textContent || options[i].innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    options[i].style.display = "";
                } else {
                    options[i].style.display = "none";
                }
            }
        }

        // Dropdown toggle for user menu
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const button = document.querySelector('button[onclick="toggleDropdown()"]');
            if (dropdown && button && !dropdown.contains(e.target) && !button.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
