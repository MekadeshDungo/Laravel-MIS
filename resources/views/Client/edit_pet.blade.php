<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet - Dasmariñas City Veterinary Services</title>
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
                
                <!-- User Profile Dropdown -->
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
                        <a href="{{ route('owner.pets') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            My Pets
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const button = e.target.closest('button');
            if (!button && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Edit Pet</h2>
                <p class="text-gray-600 mt-2">Update your pet's information</p>
                <p class="text-gray-500 text-sm mt-1">Fields marked with <span class="text-red-500">*</span> are required</p>
            </div>

            <form id="petEditForm" method="POST" action="{{ route('pet.update', $pet->pet_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Profile Picture Section -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Profile Picture</label>
                    <div class="flex items-center space-x-6">
                        <div class="shrink-0">
                            <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-primary-light relative">
                                @if($pet->pet_image)
                                    <img id="petImagePreview" src="{{ asset('storage/' . $pet->pet_image) }}" alt="Pet Profile" class="w-full h-full object-cover">
                                @else
                                    <img id="petImagePreview" src="{{ asset('images/pet.png') }}" alt="Pet Profile" class="w-full h-full object-cover">
                                @endif
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
                            <p class="text-sm text-gray-600">Click the image to change photo</p>
                            <p class="text-xs text-gray-400">Leave empty to keep current photo</p>
                        </div>
                    </div>
                </div>

                <!-- Pet Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Pet's Name <span class="text-red-500">*</span></label>
                    <input type="text" name="pet_name" value="{{ $pet->pet_name }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Enter your pet's name">
                </div>

                <!-- Pet Type -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">What kind of pet do you have? <span class="text-red-500">*</span></label>
                    <div class="flex space-x-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="pet_type" value="dog" class="form-radio h-5 w-5 text-primary" onchange="updateBreedOptions()" {{ $pet->species == 'dog' ? 'checked' : '' }}>
                            <span class="ml-3 text-gray-700 font-medium">Dog</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="pet_type" value="cat" class="form-radio h-5 w-5 text-primary" onchange="updateBreedOptions()" {{ $pet->species == 'cat' ? 'checked' : '' }}>
                            <span class="ml-3 text-gray-700 font-medium">Cat</span>
                        </label>
                    </div>
                </div>

                <!-- Gender -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Gender <span class="text-red-500">*</span></label>
                    <div class="flex space-x-6">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="gender" value="male" class="form-radio h-5 w-5 text-primary" {{ $pet->sex == 'male' ? 'checked' : '' }}>
                            <span class="ml-3 text-gray-700 font-medium">Male</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="gender" value="female" class="form-radio h-5 w-5 text-primary" {{ $pet->sex == 'female' ? 'checked' : '' }}>
                            <span class="ml-3 text-gray-700 font-medium">Female</span>
                        </label>
                    </div>
                </div>

                <!-- Neutered Checkbox -->
                <div class="mb-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="isNeutered" name="is_neutered" class="form-checkbox h-5 w-5 text-primary rounded" {{ $pet->is_neutered == 'yes' ? 'checked' : '' }}>
                        <span class="ml-3 text-gray-700 font-medium">My pet is neutered</span>
                    </label>
                </div>

                <hr class="border-gray-300 mb-6">

                <!-- Crossbreed Checkbox -->
                <div class="mb-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="isCrossbreed" name="is_crossbreed" class="form-checkbox h-5 w-5 text-primary rounded" onchange="toggleCrossbreed()" {{ $pet->is_crossbreed == 'yes' ? 'checked' : '' }}>
                        <span class="ml-3 text-gray-700 font-medium">My pet is a crossbreed</span>
                    </label>
                </div>

                <!-- Pet Breed -->
                <div class="mb-6" id="breedSection">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Pet Breed <span class="text-red-500">*</span>
                        <span id="breedLimitText" class="text-xs text-gray-500 font-normal ml-1">(select one)</span>
                    </label>
                    
                    <div class="relative">
                        <div id="breedDisplay" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white cursor-pointer hover:border-gray-400" onclick="toggleBreedDropdown()">
                            <span id="selectedBreedText" class="text-gray-900">{{ $pet->breed }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 absolute right-3 top-1/2 transform -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                        
                        <div id="breedDropdown" class="hidden absolute z-10 w-full mt-1 border border-gray-300 rounded-lg bg-white shadow-lg max-h-64">
                            <div class="p-2 border-b border-gray-200">
                                <input type="text" id="breedSearch" placeholder="Search breed..." class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:border-primary" onkeyup="filterBreeds()" onclick="event.stopPropagation()">
                            </div>
                            
                            <div id="breedOptions" class="max-h-48 overflow-y-auto py-1">
                                <div id="singleBreedOptions"></div>
                                <div id="crossbreedOptions" class="hidden"></div>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" id="petBreedInput" name="pet_breed" value="{{ $pet->breed }}">
                    
                    <div id="selectedBreedDisplay" class="mt-3 hidden">
                        <div class="flex flex-wrap gap-2" id="selectedBreedTags"></div>
                    </div>
                </div>

                <!-- I know my pet's birthdate -->
                <div class="mb-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="knowBirthdate" name="know_birthdate" class="form-checkbox h-5 w-5 text-primary rounded" onchange="toggleBirthdate()" {{ $pet->birthdate ? 'checked' : '' }}>
                        <span class="ml-3 text-gray-700 font-medium">I know my pet's birthdate</span>
                    </label>
                </div>

                <!-- Pet's Birthdate -->
                <div id="birthdateSection" class="mb-6 {{ $pet->birthdate ? '' : 'hidden' }}">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pet's Birthdate</label>
                    <input type="date" id="petBirthdate" name="pet_birthdate" value="{{ $pet->birthdate ? $pet->birthdate->format('Y-m-d') : '' }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                </div>

                <!-- Estimated Pet Age -->
                <div id="ageSection" class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Estimated Pet Age <span class="text-red-500">*</span></label>
                    <select id="estimatedAge" name="estimated_age" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="">Select estimated age</option>
                        <option value="less_than_3_months" {{ $pet->estimated_age == 'less_than_3_months' ? 'selected' : '' }}>Less than 3 months old</option>
                        <option value="3_to_12_months" {{ $pet->estimated_age == '3_to_12_months' ? 'selected' : '' }}>3 to 12 months old</option>
                        @for($i = 1; $i <= 20; $i++)
                        <option value="{{ $i }}_years" {{ $pet->estimated_age == $i . '_years' ? 'selected' : '' }}>{{ $i }} year{{ $i > 1 ? 's' : '' }} old</option>
                        @endfor
                    </select>
                </div>

                <!-- Pet Weight -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pet's Weight <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" id="petWeight" name="pet_weight" value="{{ $pet->pet_weight }}" class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Enter weight" oninput="updateWeightSuffix()">
                        <span id="weightSuffix" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium pointer-events-none"></span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">If you do not know, type "N/A"</p>
                </div>

                <hr class="border-gray-300 mb-6">

                <h3 class="text-lg font-semibold text-gray-900 mb-6">Additional Information</h3>

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
                    <textarea id="bodyMarkDetails" name="body_mark_details" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary" placeholder="Describe any unique marks, scars, or distinguishing features...">{{ $pet->body_mark_details }}</textarea>
                </div>

                <!-- Pet Attributes based on type (Training, Behavior, Likes, Dislikes, Diet, Allergy) -->
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

                <!-- Update Button -->
                <div class="text-center space-y-4">
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('owner.pets') }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="button" onclick="showConfirmModal()" class="px-8 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-primary-light transition-colors shadow-md hover:shadow-lg">
                            Update Pet
                        </button>
                    </div>
                    <div>
                        <a href="{{ route('owner.pets') }}" class="inline-block text-gray-600 hover:text-primary transition-colors">
                            ← Back to My Pets
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Confirm Update</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to update this pet's information?</p>
                <div class="flex gap-4 justify-center">
                    <button onclick="closeConfirmModal()" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                    <button onclick="submitPetForm()" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                        Confirm Update
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
            document.getElementById('petEditForm').submit();
        }

        // Toggle birthdate/age fields
        function toggleBirthdate() {
            const knowBirthdate = document.getElementById('knowBirthdate').checked;
            document.getElementById('birthdateSection').classList.toggle('hidden', !knowBirthdate);
            document.getElementById('ageSection').classList.toggle('hidden', knowBirthdate);
        }

        // Preview image
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('petImagePreview').src = e.target.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

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
            "Teddy Roosevelt Terrier", "Tibetan Terrier", "Toy Fox Terrier", "Welsh Terrier"
        ];

        let selectedBreeds = ['{{ $pet->breed }}'];
        let currentPetType = '{{ $pet->species }}';

        function toggleBreedDropdown() {
            const dropdown = document.getElementById('breedDropdown');
            dropdown.classList.toggle('hidden');
            if (!dropdown.classList.contains('hidden') && currentPetType) {
                updateBreedOptions();
            }
        }

        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('breedDropdown');
            const display = document.getElementById('breedDisplay');
            if (!dropdown.contains(e.target) && !display.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        function updateBreedOptions() {
            const petType = document.querySelector('input[name="pet_type"]:checked');
            currentPetType = petType ? petType.value : '';

            const isCrossbreed = document.getElementById('isCrossbreed').checked;
            const singleOptions = document.getElementById('singleBreedOptions');
            const crossOptions = document.getElementById('crossbreedOptions');
            const breedLimitText = document.getElementById('breedLimitText');

            const breeds = currentPetType === 'cat' ? catBreeds : dogBreeds;

            if (isCrossbreed) {
                breedLimitText.textContent = '(maximum of 2)';
                singleOptions.classList.add('hidden');
                crossOptions.classList.remove('hidden');
                crossOptions.innerHTML = breeds.map(breed => `
                    <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                        <input type="checkbox" value="${breed}" class="pet-breed-checkbox h-4 w-4 text-primary rounded border-gray-300" onchange="handleBreedCheckbox(this)" ${selectedBreeds.includes(breed) ? 'checked' : ''}>
                        <span class="ml-3 text-sm text-gray-700">${breed}</span>
                    </label>
                `).join('');
            } else {
                breedLimitText.textContent = '(select one)';
                crossOptions.classList.add('hidden');
                singleOptions.classList.remove('hidden');
                singleOptions.innerHTML = breeds.map(breed => `
                    <label class="flex items-center px-3 py-2 cursor-pointer hover:bg-gray-100">
                        <input type="radio" name="breed_option" value="${breed}" class="pet-breed-radio h-4 w-4 text-primary border-gray-300" onchange="handleSingleBreedSelect('${breed}')" ${selectedBreeds[0] === breed ? 'checked' : ''}>
                        <span class="ml-3 text-sm text-gray-700">${breed}</span>
                    </label>
                `).join('');
            }
        }

        function toggleCrossbreed() {
            const isCrossbreed = document.getElementById('isCrossbreed').checked;
            selectedBreeds = selectedBreeds.slice(0, 1);
            updateBreedOptions();
        }
        
        // Update weight suffix based on input
        function updateWeightSuffix() {
            const input = document.getElementById('petWeight');
            const suffix = document.getElementById('weightSuffix');
            if (!input || !suffix) return;
            
            const value = input.value.trim().toUpperCase();
            
            // Show kg suffix if there's a valid number, hide if empty or N/A
            if (value === '' || value === 'N/A') {
                suffix.classList.add('hidden');
                suffix.textContent = '';
            } else {
                suffix.classList.remove('hidden');
                suffix.textContent = 'kg';
            }
        }
        
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
            document.getElementById('petBreedInput').value = selectedBreeds.join(', ');
        }

        function handleSingleBreedSelect(breed) {
            selectedBreeds = [breed];
            document.getElementById('petBreedInput').value = breed;
            document.getElementById('selectedBreedText').textContent = breed;
            document.getElementById('selectedBreedText').classList.remove('text-gray-500');
            document.getElementById('selectedBreedText').classList.add('text-gray-900');
            document.getElementById('breedDropdown').classList.add('hidden');
        }

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

        // Cat attributes data
        var catTraining = ['Obedience-trained', 'Potty-trained'];
        var catInsurance = ['Insured'];
        var catBehavior = ['Independent', 'Curious', 'Territorial', 'Play-biter', 'Affectionate', 'Nocturnal', 'Skittish', 'Hunter', 'Catnip lover', 'Social', 'Shy', 'Friendly', 'Gentle', 'Perching'];
        var catLikes = ['Cuddle time', 'Playing with yarn', 'Sunbathing by the window', 'Treats', 'Puzzle toys', 'Cardboard boxes', 'Chasing mice toys', 'Feather wands', 'Catnip lover', 'Gentle Petting', 'Bunting', 'Climbing'];
        var catDislikes = ['Water/Baths', 'Car rides', 'Vacuum cleaners', 'Strong wind', 'Loud noises/Fireworks', 'Vet visits', 'Being trapped in a room', 'Wearing clothes', 'Being ignored', 'Too much handling'];
        var catDiet = ['Kibbles', 'Chicken', 'Beef', 'Turkey', 'Pork', 'Carrots', 'Sweet potatoes', 'Broccoli', 'Eggs', 'Cheese'];
        var catDietMore = ['Venison', 'Lamb', 'Bison', 'Shrimp', 'Tuna', 'Salmon', 'Catnip', 'Sardines', 'Mackerel', 'Apple', 'Banana', 'Pears', 'Blueberry', 'Strawberry', 'Raspberry', 'Cranberry', 'Watermelon', 'Pineapple', 'Pumpkin', 'Potato', 'Horseradish', 'Celery', 'Beets', 'Green beans', 'Peas', 'Spinach', 'Peanut butter', 'Nutribowl'];
        var catAllergy = ['Corn', 'Dairy', 'Pork', 'Beef', 'Chicken', 'Lamb', 'Shrimp', 'Tuna', 'Salmon', 'Tailored treats preferred'];

        // Dog attributes data
        var dogTraining = ['Obedience-trained', 'Potty-trained'];
        var dogInsurance = ['Insured'];
        var dogBehavior = ['Friendly', 'Playful', 'Shy', 'Affectionate', 'Social', 'Reactive', 'Energetic', 'Gentle', 'Loyal', 'Protective', 'Anxious', 'Territorial', 'Play-biter', 'Grumpy'];
        var dogLikes = ['Playing fetch', 'Chew toys', 'Gentle petting', 'Long walks', 'Treats', 'Cuddle', 'Belly rub', 'Cuddle time', 'Splashing in water', 'Adventures/Outings', 'Puzzle toys', 'Socializing with other dogs', 'Sunbathing'];
        var dogDislikes = ['Baths', 'Vacuum cleaners', 'Thunderstorms', 'Car rides', 'Loud noises/Fireworks', 'Vet visits', 'Wearing clothes', 'Being ignored', 'Too much handling'];
        var dogDiet = ['Kibbles', 'Chicken', 'Beef', 'Turkey', 'Pork', 'Carrots', 'Sweet potatoes', 'Broccoli', 'Eggs', 'Cheese'];
        var dogDietMore = ['Venison', 'Lamb', 'Duck', 'Tripe', 'Liver', 'Bison', 'Apple', 'Banana', 'Pears', 'Blueberry', 'Strawberry', 'Raspberry', 'Cranberry', 'Watermelon', 'Pineapple', 'Pumpkin', 'Potato', 'Horseradish', 'Celery', 'Beets', 'Green beans', 'Peas', 'Spinach', 'Peanut butter', 'Nutribowl'];
        var dogAllergy = ['Chicken', 'Beef', 'Lamb', 'Pork', 'Soy', 'Wheat', 'Eggs', 'Dairy', 'Tailored treats preferred'];

        // Selected attributes
        var selectedLikes = [];
        var selectedDiet = [];
        var dietExpanded = false;

        // Handle pill button change
        // Handle pill button change
        function handlePillChange(checkbox) {
            var category = checkbox.dataset.category;
            var value = checkbox.dataset.value;
            var label = document.getElementById(checkbox.id + '_label');
            var maxSelect = checkbox.dataset.max ? parseInt(checkbox.dataset.max) : null;

            if (checkbox.checked) {
                // Update styling
                label.classList.remove('border-gray-300', 'text-gray-700');
                label.classList.add('bg-primary', 'text-white', 'border-primary');
            } else {
                // Remove styling
                label.classList.remove('bg-primary', 'text-white', 'border-primary');
                label.classList.add('border-gray-300', 'text-gray-700');
            }
            
            // Gray out remaining options if max reached
            if (maxSelect) {
                var allCheckboxes = document.querySelectorAll('input[data-category="' + category + '"]');
                var checkedCount = document.querySelectorAll('input[data-category="' + category + '"]:checked').length;
                
                allCheckboxes.forEach(function(cb) {
                    var cbLabel = document.getElementById(cb.id + '_label');
                    if (!cb.checked && checkedCount >= maxSelect) {
                        cbLabel.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        cbLabel.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                });
            }
        }

        // Show more diet options
        function showMoreDiet() {
            var petType = document.querySelector('input[name="pet_type"]:checked');
            var type = petType ? petType.value : '';
            var dietMore = type === 'cat' ? catDietMore : dogDietMore;
            
            var dietContainer = document.getElementById('dietOptions');
            var showMoreBtn = document.getElementById('dietShowMore');
            
            if (!dietExpanded) {
                // Add more options
                var existingDiet = type === 'cat' ? catDiet : dogDiet;
                dietContainer.innerHTML += dietMore.map(function(v) {
                    var id = 'diet_' + v.replace(/[^a-zA-Z0-9]/g, '');
                    return '<label class="inline-flex items-center cursor-pointer">' +
                        '<input type="checkbox" id="' + id + '" name="diet[]" value="' + v + '" class="pill-checkbox hidden" data-category="diet" data-value="' + v + '" data-max="5" onchange="handlePillChange(this)">' +
                        '<span id="' + id + '_label" class="px-3 py-1 text-sm rounded-full border border-gray-300 text-gray-700 hover:border-primary transition-colors">' + v + '</span>' +
                        '</label>';
                }).join('');
                showMoreBtn.textContent = 'Show Less';
                dietExpanded = true;
            } else {
                // Remove extra options
                var originalDiet = type === 'cat' ? catDiet : dogDiet;
                
                document.querySelectorAll('#dietOptions .pill-checkbox').forEach(function(cb) {
                    if (originalDiet.indexOf(cb.dataset.value) === -1) {
                        var label = document.getElementById(cb.id + '_label');
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

        // Populate pet attributes based on type
        function populatePetAttributes(petTypeOverride) {
            // Get existing values from the pet
            var existingTraining = {!! json_encode($pet->training ?? []) !!};
            var existingInsurance = {!! json_encode($pet->insurance ?? []) !!};
            var existingBehavior = {!! json_encode($pet->behavior ?? []) !!};
            var existingLikes = {!! json_encode($pet->likes ?? []) !!};
            var existingDislikes = {!! json_encode($pet->dislikes ?? []) !!};
            var existingDiet = {!! json_encode($pet->diet ?? []) !!};
            var existingAllergy = {!! json_encode($pet->allergy ?? []) !!};
            
            // Reset selections
            selectedLikes = [];
            selectedDiet = [];
            dietExpanded = false;
            
            // Determine pet type - use override or check radio button
            var type = petTypeOverride;
            if (!type) {
                var petType = document.querySelector('input[name="pet_type"]:checked');
                type = petType ? petType.value : '';
            }
            
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
            
            var isCat = type === 'cat';
            var training = isCat ? catTraining : dogTraining;
            var insurance = isCat ? catInsurance : dogInsurance;
            var behavior = isCat ? catBehavior : dogBehavior;
            var likes = isCat ? catLikes : dogLikes;
            var dislikes = isCat ? catDislikes : dogDislikes;
            var diet = isCat ? catDiet : dogDiet;
            var dietMore = isCat ? catDietMore : dogDietMore;
            var allergy = isCat ? catAllergy : dogAllergy;
            
            // Training
            document.getElementById('trainingOptions').innerHTML = training.map(function(v) {
                var id = 'training_' + v.replace(/[^a-zA-Z0-9]/g, '');
                var isChecked = existingTraining.indexOf(v) !== -1 ? 'checked' : '';
                var checkedClass = existingTraining.indexOf(v) !== -1 ? 'bg-primary text-white border-primary' : 'border-gray-300 text-gray-700';
                return '<label class="inline-flex items-center cursor-pointer">' +
                    '<input type="checkbox" id="' + id + '" name="training[]" value="' + v + '" class="pill-checkbox hidden" data-category="training" data-value="' + v + '" ' + isChecked + ' onchange="handlePillChange(this)">' +
                    '<span id="' + id + '_label" class="px-3 py-1 text-sm rounded-full border ' + checkedClass + ' hover:border-primary transition-colors">' + v + '</span>' +
                    '</label>';
            }).join('');
            
            // Insurance
            document.getElementById('insuranceOptions').innerHTML = insurance.map(function(v) {
                var id = 'insurance_' + v.replace(/[^a-zA-Z0-9]/g, '');
                var isChecked = existingInsurance.indexOf(v) !== -1 ? 'checked' : '';
                var checkedClass = existingInsurance.indexOf(v) !== -1 ? 'bg-primary text-white border-primary' : 'border-gray-300 text-gray-700';
                return '<label class="inline-flex items-center cursor-pointer">' +
                    '<input type="checkbox" id="' + id + '" name="insurance[]" value="' + v + '" class="pill-checkbox hidden" data-category="insurance" data-value="' + v + '" ' + isChecked + ' onchange="handlePillChange(this)">' +
                    '<span id="' + id + '_label" class="px-3 py-1 text-sm rounded-full border ' + checkedClass + ' hover:border-primary transition-colors">' + v + '</span>' +
                    '</label>';
            }).join('');
            
            // Behavior
            document.getElementById('behaviorOptions').innerHTML = behavior.map(function(v) {
                var id = 'behavior_' + v.replace(/[^a-zA-Z0-9]/g, '');
                var isChecked = existingBehavior.indexOf(v) !== -1 ? 'checked' : '';
                var checkedClass = existingBehavior.indexOf(v) !== -1 ? 'bg-primary text-white border-primary' : 'border-gray-300 text-gray-700';
                return '<label class="inline-flex items-center cursor-pointer">' +
                    '<input type="checkbox" id="' + id + '" name="behavior[]" value="' + v + '" class="pill-checkbox hidden" data-category="behavior" data-value="' + v + '" ' + isChecked + ' onchange="handlePillChange(this)">' +
                    '<span id="' + id + '_label" class="px-3 py-1 text-sm rounded-full border ' + checkedClass + ' hover:border-primary transition-colors">' + v + '</span>' +
                    '</label>';
            }).join('');
            
            // Likes (max 5)
            document.getElementById('likesOptions').innerHTML = likes.map(function(v) {
                var id = 'likes_' + v.replace(/[^a-zA-Z0-9]/g, '');
                var isChecked = existingLikes.indexOf(v) !== -1 ? 'checked' : '';
                var checkedClass = existingLikes.indexOf(v) !== -1 ? 'bg-primary text-white border-primary' : 'border-gray-300 text-gray-700';
                return '<label class="inline-flex items-center cursor-pointer">' +
                    '<input type="checkbox" id="' + id + '" name="likes[]" value="' + v + '" class="pill-checkbox hidden" data-category="likes" data-value="' + v + '" data-max="5" ' + isChecked + ' onchange="handlePillChange(this)">' +
                    '<span id="' + id + '_label" class="px-3 py-1 text-sm rounded-full border ' + checkedClass + ' hover:border-primary transition-colors">' + v + '</span>' +
                    '</label>';
            }).join('');
            
            // Dislikes
            document.getElementById('dislikesOptions').innerHTML = dislikes.map(function(v) {
                var id = 'dislikes_' + v.replace(/[^a-zA-Z0-9]/g, '');
                var isChecked = existingDislikes.indexOf(v) !== -1 ? 'checked' : '';
                var checkedClass = existingDislikes.indexOf(v) !== -1 ? 'bg-primary text-white border-primary' : 'border-gray-300 text-gray-700';
                return '<label class="inline-flex items-center cursor-pointer">' +
                    '<input type="checkbox" id="' + id + '" name="dislikes[]" value="' + v + '" class="pill-checkbox hidden" data-category="dislikes" data-value="' + v + '" ' + isChecked + ' onchange="handlePillChange(this)">' +
                    '<span id="' + id + '_label" class="px-3 py-1 text-sm rounded-full border ' + checkedClass + ' hover:border-primary transition-colors">' + v + '</span>' +
                    '</label>';
            }).join('');
            
            // Diet (max 5) - load all options including "More" list
            var allDiet = diet.concat(dietMore);
            document.getElementById('dietOptions').innerHTML = allDiet.map(function(v) {
                var id = 'diet_' + v.replace(/[^a-zA-Z0-9]/g, '');
                var isChecked = existingDiet.indexOf(v) !== -1 ? 'checked' : '';
                var checkedClass = existingDiet.indexOf(v) !== -1 ? 'bg-primary text-white border-primary' : 'border-gray-300 text-gray-700';
                return '<label class="inline-flex items-center cursor-pointer">' +
                    '<input type="checkbox" id="' + id + '" name="diet[]" value="' + v + '" class="pill-checkbox hidden" data-category="diet" data-value="' + v + '" data-max="5" ' + isChecked + ' onchange="handlePillChange(this)">' +
                    '<span id="' + id + '_label" class="px-3 py-1 text-sm rounded-full border ' + checkedClass + ' hover:border-primary transition-colors">' + v + '</span>' +
                    '</label>';
            }).join('');
            
            // Hide Show More button since we're showing all options
            document.getElementById('dietShowMore').classList.add('hidden');
            
            // Allergy
            document.getElementById('allergyOptions').innerHTML = allergy.map(function(v) {
                var id = 'allergy_' + v.replace(/[^a-zA-Z0-9]/g, '');
                var isChecked = existingAllergy.indexOf(v) !== -1 ? 'checked' : '';
                var checkedClass = existingAllergy.indexOf(v) !== -1 ? 'bg-primary text-white border-primary' : 'border-gray-300 text-gray-700';
                return '<label class="inline-flex items-center cursor-pointer">' +
                    '<input type="checkbox" id="' + id + '" name="allergy[]" value="' + v + '" class="pill-checkbox hidden" data-category="allergy" data-value="' + v + '" ' + isChecked + ' onchange="handlePillChange(this)">' +
                    '<span id="' + id + '_label" class="px-3 py-1 text-sm rounded-full border ' + checkedClass + ' hover:border-primary transition-colors">' + v + '</span>' +
                    '</label>';
            }).join('');
            
            // Initialize selected arrays from existing data
            selectedLikes = existingLikes.slice();
            selectedDiet = existingDiet.slice();
            
            // Gray out remaining options if max reached (for Likes) - check actual checked boxes
            var likesCheckedCount = document.querySelectorAll('input[data-category="likes"]:checked').length;
            var likesCheckboxes = document.querySelectorAll('input[data-category="likes"]');
            likesCheckboxes.forEach(function(cb) {
                var cbLabel = document.getElementById(cb.id + '_label');
                if (!cb.checked && likesCheckedCount >= 5) {
                    cbLabel.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    cbLabel.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
            
            // Gray out remaining options if max reached (for Diet) - check actual checked boxes
            var dietCheckedCount = document.querySelectorAll('input[data-category="diet"]:checked').length;
            var dietCheckboxes = document.querySelectorAll('input[data-category="diet"]');
            dietCheckboxes.forEach(function(cb) {
                var cbLabel = document.getElementById(cb.id + '_label');
                if (!cb.checked && dietCheckedCount >= 5) {
                    cbLabel.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    cbLabel.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing pet attributes...');
            updateBreedOptions();
            updateWeightSuffix();
            
            // Get current pet type from the existing pet data
            var currentPetType = '{{ $pet->species }}';
            console.log('Pet species from database:', currentPetType);
            
            // If no species from database, check the radio button
            if (!currentPetType) {
                var checkedRadio = document.querySelector('input[name="pet_type"]:checked');
                currentPetType = checkedRadio ? checkedRadio.value : '';
                console.log('Pet species from radio:', currentPetType);
            } else {
                // Set the radio button to match current pet type
                var radioButton = document.querySelector('input[name="pet_type"][value="' + currentPetType + '"]');
                if (radioButton) {
                    radioButton.checked = true;
                }
            }
            
            // Populate the attributes
            console.log('Calling populatePetAttributes with type:', currentPetType);
            if (currentPetType) {
                populatePetAttributes(currentPetType);
            } else {
                // If still no type, try to get from radio
                populatePetAttributes();
            }
            console.log('Done initializing');
        });

        // Add event listener to pet type radio buttons
        document.querySelectorAll('input[name="pet_type"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                updateBreedOptions();
                var currentPetType = '{{ $pet->species }}';
                var newType = this.value;
                // Update the hidden type
                document.querySelector('input[name="pet_type"][value="' + newType + '"]').checked = true;
                populatePetAttributes(newType);
            });
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
</body>
</html>
