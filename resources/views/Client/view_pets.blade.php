<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Pets - Dasmariñas City Veterinary Services</title>
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
        .pet-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(6, 109, 51, 0.15);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen flex flex-col">
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
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Pet Owner</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 hidden md:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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

    <!-- Page Header -->
    <section class="hero-bg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">My Pets</h1>
                    <p class="mt-1">View and manage your registered pets</p>
                </div>
                <a href="{{ url('/pet-registration/form') }}" class="bg-white text-primary px-6 py-3 rounded-lg font-medium hover:bg-gray-100 transition-colors shadow-lg">
                    + Add New Pet
                </a>
            </div>
        </div>
    </section>

    <!-- Pets Grid -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $pets = \App\Models\Pet::where('owner_id', auth()->user()->petOwner->owner_id ?? 0)->get();
            @endphp
            
            @if($pets->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($pets as $pet)
                        <div class="pet-card bg-white rounded-xl shadow-lg overflow-hidden cursor-pointer transition-all duration-300 relative">
                            <!-- Large Pet Image -->
                            <div class="h-64 w-full bg-gray-200 relative">
                                @if($pet->pet_image)
                                    <img src="{{ asset('storage/' . $pet->pet_image) }}" alt="{{ $pet->pet_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                                        <span class="text-white text-6xl font-bold">{{ substr($pet->pet_name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <!-- Pet Type Badge -->
                                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium text-primary">
                                    {{ ucfirst($pet->species) }}
                                </div>
                                <!-- Triple Dot Dropdown -->
                                <div class="absolute top-3 left-3">
                                    <button onclick="togglePetDropdown(event, 'petDropdown{{ $pet->pet_id }}')" class="bg-white/90 backdrop-blur-sm p-2 rounded-full hover:bg-white transition-colors shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                    <!-- Dropdown Menu -->
                                    <div id="petDropdown{{ $pet->pet_id }}" class="hidden absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-20">
                                        <button onclick="markAsMissing({{ $pet->pet_id }})" class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            Mark as missing
                                        </button>
                                        <form method="POST" action="{{ route('pet.destroy', $pet->pet_id) }}" onsubmit="return confirm('Are you sure you want to delete this pet?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center w-full px-4 py-2 text-red-600 hover:bg-red-50">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Pet Info -->
                            <div onclick="showPetDetails({{ $pet->pet_id }})" class="p-4">
                                <h3 class="text-xl font-bold text-gray-900">{{ $pet->pet_name }}</h3>
                                <p class="text-gray-500 text-sm mt-1">{{ $pet->breed }}</p>
                                <p class="text-gray-400 text-xs mt-2">Click to view details</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <p class="text-gray-600 text-lg mb-4">You haven't registered any pets yet</p>
                    <a href="{{ url('/pet-registration/form') }}" class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        Register Your First Pet
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Pet Details Modal -->
    <div id="petDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header with Large Image -->
            <div class="relative h-64 bg-gray-200 rounded-t-2xl">
                <img id="modalPetImage" src="" alt="" class="w-full h-full object-cover rounded-t-2xl">
                <button onclick="closePetDetails()" class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm p-2 rounded-full hover:bg-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-lg">
                    <h2 id="modalPetName" class="text-2xl font-bold text-gray-900"></h2>
                    <p id="modalPetBreed" class="text-gray-600"></p>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Species -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Species</p>
                        <p id="modalPetSpecies" class="text-lg font-semibold text-gray-900 capitalize"></p>
                    </div>
                    
                    <!-- Gender -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Gender</p>
                        <p id="modalPetGender" class="text-lg font-semibold text-gray-900 capitalize"></p>
                    </div>
                    
                    <!-- Age -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Age</p>
                        <p id="modalPetAge" class="text-lg font-semibold text-gray-900"></p>
                    </div>
                    
                    <!-- Weight -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Weight</p>
                        <p id="modalPetWeight" class="text-lg font-semibold text-gray-900"></p>
                    </div>
                    
                    <!-- Neutered -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Neutered</p>
                        <p id="modalPetNeutered" class="text-lg font-semibold text-gray-900"></p>
                    </div>
                    
                    <!-- Crossbreed -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Crossbreed</p>
                        <p id="modalPetCrossbreed" class="text-lg font-semibold text-gray-900"></p>
                    </div>
                </div>
                
                <!-- Body Mark Details -->
                <div id="bodyMarkSection" class="mt-4 hidden">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500 mb-2">Body Mark Details</p>
                        <p id="modalPetBodyMark" class="text-gray-900"></p>
                    </div>
                </div>
                
                <!-- Additional Information Section -->
                <div id="additionalInfoSection" class="mt-4">
                    <h4 class="font-semibold text-gray-900 mb-3">Additional Information</h4>
                    
                    <!-- Training -->
                    <div id="trainingSection" class="bg-gray-50 rounded-lg p-4 mb-3 hidden">
                        <p class="text-sm text-gray-500 mb-2">Training</p>
                        <div id="modalPetTraining" class="flex flex-wrap gap-2"></div>
                    </div>
                    
                    <!-- Insurance -->
                    <div id="insuranceSection" class="bg-gray-50 rounded-lg p-4 mb-3 hidden">
                        <p class="text-sm text-gray-500 mb-2">Insurance</p>
                        <div id="modalPetInsurance" class="flex flex-wrap gap-2"></div>
                    </div>
                    
                    <!-- Behavior -->
                    <div id="behaviorSection" class="bg-gray-50 rounded-lg p-4 mb-3 hidden">
                        <p class="text-sm text-gray-500 mb-2">Behavior</p>
                        <div id="modalPetBehavior" class="flex flex-wrap gap-2"></div>
                    </div>
                    
                    <!-- Likes -->
                    <div id="likesSection" class="bg-gray-50 rounded-lg p-4 mb-3 hidden">
                        <p class="text-sm text-gray-500 mb-2">Likes</p>
                        <div id="modalPetLikes" class="flex flex-wrap gap-2"></div>
                    </div>
                    
                    <!-- Dislikes -->
                    <div id="dislikesSection" class="bg-gray-50 rounded-lg p-4 mb-3 hidden">
                        <p class="text-sm text-gray-500 mb-2">Dislikes</p>
                        <div id="modalPetDislikes" class="flex flex-wrap gap-2"></div>
                    </div>
                    
                    <!-- Diet -->
                    <div id="dietSection" class="bg-gray-50 rounded-lg p-4 mb-3 hidden">
                        <p class="text-sm text-gray-500 mb-2">Diet</p>
                        <div id="modalPetDiet" class="flex flex-wrap gap-2"></div>
                    </div>
                    
                    <!-- Allergy -->
                    <div id="allergySection" class="bg-gray-50 rounded-lg p-4 mb-3 hidden">
                        <p class="text-sm text-gray-500 mb-2">Allergy</p>
                        <div id="modalPetAllergy" class="flex flex-wrap gap-2"></div>
                    </div>
                </div>
                
                <!-- Additional Info -->
                <div class="mt-6 flex gap-3">
                    <a id="modalEditLink" href="#" class="flex-1 bg-primary text-white text-center py-3 rounded-lg font-medium hover:bg-primary-light transition-colors">
                        Edit Pet
                    </a>
                    <button onclick="closePetDetails()" class="flex-1 border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    @if(session('success'))
        <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 p-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Success!</h3>
                    <p class="text-gray-600 mb-6">{{ session('success') }}</p>
                    <button onclick="closeSuccessModal()" class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary-light transition-colors">
                        OK
                    </button>
                </div>
            </div>
        </div>
        <script>
            function closeSuccessModal() {
                document.getElementById('successModal').classList.add('hidden');
            }
        </script>
    @endif

    <script>
        // Pet data for modal
        const petsData = @json($pets);
        
        function togglePetDropdown(event, dropdownId) {
            event.stopPropagation();
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');
        }
        
        function markAsMissing(petId) {
            // Placeholder for mark as missing functionality
            alert('Mark as missing feature coming soon!');
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('[id^="petDropdown"]');
            dropdowns.forEach(dropdown => {
                const button = event.target.closest('button');
                if (!button || !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
        
        function showPetDetails(petId) {
            const pet = petsData.find(p => p.pet_id === petId);
            if (!pet) return;
            
            // Set image
            const modalImg = document.getElementById('modalPetImage');
            if (pet.pet_image) {
                modalImg.src = '{{ asset('storage/') }}/' + pet.pet_image;
            } else {
                modalImg.src = '{{ asset('images/pet.png') }}';
            }
            
            // Set pet info
            document.getElementById('modalPetName').textContent = pet.pet_name;
            document.getElementById('modalPetBreed').textContent = pet.breed;
            document.getElementById('modalPetSpecies').textContent = pet.species;
            document.getElementById('modalPetGender').textContent = pet.sex;
            
            // Calculate age
            let ageDisplay = 'Unknown';
            if (pet.estimated_age) {
                const ageMap = {
                    'less_than_3_months': 'Less than 3 months',
                    '3_to_12_months': '3 to 12 months',
                    '1_year': '1 year old',
                    '2_years': '2 years old',
                    '3_years': '3 years old',
                    '4_years': '4 years old',
                    '5_years': '5 years old',
                    '6_years': '6 years old',
                    '7_years': '7 years old',
                    '8_years': '8 years old',
                    '9_years': '9 years old',
                    '10_years': '10 years old',
                };
                ageDisplay = ageMap[pet.estimated_age] || pet.estimated_age;
            } else if (pet.birthdate) {
                const birthYear = new Date(pet.birthdate).getFullYear();
                const age = new Date().getFullYear() - birthYear;
                ageDisplay = age + ' year' + (age !== 1 ? 's' : '') + ' old';
            }
            document.getElementById('modalPetAge').textContent = ageDisplay;
            
            document.getElementById('modalPetWeight').textContent = pet.pet_weight ? pet.pet_weight + ' kg' : 'N/A';
            document.getElementById('modalPetNeutered').textContent = pet.is_neutered === 'yes' ? 'Yes' : 'No';
            document.getElementById('modalPetCrossbreed').textContent = pet.is_crossbreed === 'yes' ? 'Yes' : 'No';
            
            // Body mark
            const bodyMarkSection = document.getElementById('bodyMarkSection');
            if (pet.body_mark_details) {
                document.getElementById('modalPetBodyMark').textContent = pet.body_mark_details;
                bodyMarkSection.classList.remove('hidden');
            } else {
                bodyMarkSection.classList.add('hidden');
            }
            
            // Additional Information - Training
            const trainingSection = document.getElementById('trainingSection');
            const trainingContainer = document.getElementById('modalPetTraining');
            if (pet.training) {
                const training = typeof pet.training === 'string' ? JSON.parse(pet.training) : pet.training;
                if (training && training.length > 0) {
                    trainingContainer.innerHTML = training.map(t => `<span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">${t}</span>`).join('');
                    trainingSection.classList.remove('hidden');
                } else {
                    trainingSection.classList.add('hidden');
                }
            } else {
                trainingSection.classList.add('hidden');
            }
            
            // Insurance
            const insuranceSection = document.getElementById('insuranceSection');
            const insuranceContainer = document.getElementById('modalPetInsurance');
            if (pet.insurance) {
                const insurance = typeof pet.insurance === 'string' ? JSON.parse(pet.insurance) : pet.insurance;
                if (insurance && insurance.length > 0) {
                    insuranceContainer.innerHTML = insurance.map(i => `<span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">${i}</span>`).join('');
                    insuranceSection.classList.remove('hidden');
                } else {
                    insuranceSection.classList.add('hidden');
                }
            } else {
                insuranceSection.classList.add('hidden');
            }
            
            // Behavior
            const behaviorSection = document.getElementById('behaviorSection');
            const behaviorContainer = document.getElementById('modalPetBehavior');
            if (pet.behavior) {
                const behavior = typeof pet.behavior === 'string' ? JSON.parse(pet.behavior) : pet.behavior;
                if (behavior && behavior.length > 0) {
                    behaviorContainer.innerHTML = behavior.map(b => `<span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">${b}</span>`).join('');
                    behaviorSection.classList.remove('hidden');
                } else {
                    behaviorSection.classList.add('hidden');
                }
            } else {
                behaviorSection.classList.add('hidden');
            }
            
            // Likes
            const likesSection = document.getElementById('likesSection');
            const likesContainer = document.getElementById('modalPetLikes');
            if (pet.likes) {
                const likes = typeof pet.likes === 'string' ? JSON.parse(pet.likes) : pet.likes;
                if (likes && likes.length > 0) {
                    likesContainer.innerHTML = likes.map(l => `<span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">${l}</span>`).join('');
                    likesSection.classList.remove('hidden');
                } else {
                    likesSection.classList.add('hidden');
                }
            } else {
                likesSection.classList.add('hidden');
            }
            
            // Dislikes
            const dislikesSection = document.getElementById('dislikesSection');
            const dislikesContainer = document.getElementById('modalPetDislikes');
            if (pet.dislikes) {
                const dislikes = typeof pet.dislikes === 'string' ? JSON.parse(pet.dislikes) : pet.dislikes;
                if (dislikes && dislikes.length > 0) {
                    dislikesContainer.innerHTML = dislikes.map(d => `<span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">${d}</span>`).join('');
                    dislikesSection.classList.remove('hidden');
                } else {
                    dislikesSection.classList.add('hidden');
                }
            } else {
                dislikesSection.classList.add('hidden');
            }
            
            // Diet
            const dietSection = document.getElementById('dietSection');
            const dietContainer = document.getElementById('modalPetDiet');
            if (pet.diet) {
                const diet = typeof pet.diet === 'string' ? JSON.parse(pet.diet) : pet.diet;
                if (diet && diet.length > 0) {
                    dietContainer.innerHTML = diet.map(d => `<span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm">${d}</span>`).join('');
                    dietSection.classList.remove('hidden');
                } else {
                    dietSection.classList.add('hidden');
                }
            } else {
                dietSection.classList.add('hidden');
            }
            
            // Allergy
            const allergySection = document.getElementById('allergySection');
            const allergyContainer = document.getElementById('modalPetAllergy');
            if (pet.allergy) {
                const allergy = typeof pet.allergy === 'string' ? JSON.parse(pet.allergy) : pet.allergy;
                if (allergy && allergy.length > 0) {
                    allergyContainer.innerHTML = allergy.map(a => `<span class="bg-pink-100 text-pink-800 px-3 py-1 rounded-full text-sm">${a}</span>`).join('');
                    allergySection.classList.remove('hidden');
                } else {
                    allergySection.classList.add('hidden');
                }
            } else {
                allergySection.classList.add('hidden');
            }
            
            // Edit link
            document.getElementById('modalEditLink').href = '/owner/pets/' + pet.pet_id + '/edit';
            
            // Show modal
            document.getElementById('petDetailsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closePetDetails() {
            document.getElementById('petDetailsModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking outside
        document.getElementById('petDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePetDetails();
            }
        });
    </script>

    <!-- Footer -->
    <footer class="bg-white text-gray-900 mt-auto">
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
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Home</a></li>
                        <li><a href="{{ url('/about-us') }}" class="text-gray-600 hover:text-primary transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Services</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Rabies Information</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Pet Registration</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Anti-Rabies Vaccination</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Pet Adoption</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li>City Veterinary Office</li>
                        <li>Dasmariñas City, Cavite</li>
                        <li>Phone: 0966-881-2010</li>
                        <li>Email: vetdasma@yahoo.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-600 text-sm">
                &copy; 2026 Dasmariñas City Veterinary Services. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
