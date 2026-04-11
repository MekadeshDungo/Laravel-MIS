<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Application - Dasmariñas City Veterinary Services</title>
    
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
            <h2 class="text-3xl font-bold">ADOPTION APPLICATION</h2>
            <p class="mt-2 text-gray-600 text-sm text-left">
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
                    <span class="text-sm font-medium text-gray-700" id="stepLabel">Step 1 of 6</span>
                    <span class="text-sm font-medium text-primary" id="stepTitle">Part 1: Application Information</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progressBar" class="bg-primary h-2.5 rounded-full transition-all duration-300" style="width: 16.67%"></div>
                </div>
                <div class="flex justify-between mt-2">
                    <div class="text-xs text-center flex-1">
                        <div id="step1Indicator" class="font-semibold text-primary">1</div>
                        <div class="text-gray-500">Application</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step2Indicator" class="font-semibold text-gray-400">2</div>
                        <div class="text-gray-400">Alt. Contact</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step3Indicator" class="font-semibold text-gray-400">3</div>
                        <div class="text-gray-400">Questionnaire</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step4Indicator" class="font-semibold text-gray-400">4</div>
                        <div class="text-gray-400">Home Photos</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step5Indicator" class="font-semibold text-gray-400">5</div>
                        <div class="text-gray-400">Valid ID</div>
                    </div>
                    <div class="text-xs text-center flex-1">
                        <div id="step6Indicator" class="font-semibold text-gray-400">6</div>
                        <div class="text-gray-400">Interview</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="#" enctype="multipart/form-data" id="adoptionForm">
                @csrf

                <!-- PART 1: APPLICATION INFORMATION -->
                <div id="part1" class="form-part">
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 1: Application Information</h3>

                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium mb-1.5">
                                    Name <span class="text-red-500">*</span>
                                    <span class="text-gray-500 text-xs ml-2">(First name and Last name)</span>
                                </label>
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" name="first_name" placeholder="First name" value="{{ old('first_name', $petOwner->first_name ?? '') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                    <input type="text" name="last_name" placeholder="Last name" value="{{ old('last_name', $petOwner->last_name ?? '') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" placeholder="name@example.com" value="{{ old('email', $user->email ?? '') }}"
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
                                    <input type="tel" name="mobile_number" placeholder="943 210 2012" maxlength="14" value="{{ old('mobile_number', $petOwner->phone_number ?? '') }}" oninput="formatPhone(this)"
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
                                    <input type="tel" name="alt_mobile_number" placeholder="943 210 2012" maxlength="14" value="{{ old('alt_mobile_number', $petOwner->alternate_phone_number ?? '') }}" oninput="formatPhone(this)"
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

                            <!-- Birth Date -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Birth Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="birth_date" value="{{ old('birth_date', $petOwner->date_of_birth ?? '') }}"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>

                            <!-- Occupation -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Occupation
                                </label>
                                <input type="text" name="occupation" placeholder="Your occupation"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>

                            <!-- Company/Business Name -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Company/Business Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="company" placeholder="Company/Business Name"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <p class="text-xs text-gray-500 italic mt-1">Please type N/A if unemployed</p>
                            </div>

                            <!-- Social Media -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Social Media
                                </label>
                                <input type="text" name="social_media" placeholder="Facebook/Instagram URL"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <p class="text-xs text-gray-500 italic mt-1">Please type N/A if none</p>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium mb-1.5">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="Single" class="text-primary">
                                        <span class="ml-2">Single</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="Married" class="text-primary">
                                        <span class="ml-2">Married</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="status" value="Others" class="text-primary">
                                        <span class="ml-2">Others</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Have you adopted before? -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium mb-1.5">
                                    Have you adopted before? <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="adopted_before" value="yes" class="text-primary">
                                        <span class="ml-2">Yes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="adopted_before" value="no" class="text-primary">
                                        <span class="ml-2">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Navigation Buttons for Part 1 -->
                    <div class="flex justify-between items-center mt-8">
                        <a href="{{ url('/adoption') }}" class="text-gray-600 hover:text-primary transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Back to Adoption Page
                        </a>
                        <button type="button" onclick="goToStep(2)" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Next: Alternate Contact
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PART 2: ALTERNATE CONTACT -->
                <div id="part2" class="form-part hidden">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 2: Alternate Contact</h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Name <span class="text-red-500">*</span>
                                <span class="text-gray-500 text-xs ml-2">(First name and Last name)</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="alt_first_name" placeholder="First Name"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <input type="text" name="alt_last_name" placeholder="Last Name"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                        </div>

                        <!-- Relationship -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Relationship <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="alt_relationship" placeholder="Relationship to you"
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
                                <input type="tel" name="alt_phone" placeholder="943 210 2012" maxlength="14" oninput="formatPhone(this)"
                                       class="flex-1 px-4 py-2.5 rounded-r-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="alt_email" placeholder="name@example.com"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
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
                            Next: Questionnaire
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PART 3: QUESTIONNAIRE -->
                <div id="part3" class="form-part hidden">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 3: Questionnaire</h3>
                    
                    <p class="text-sm text-gray-600 italic mb-6">
                        In an effort to help the process go smoothly, please be as detailed as possible with your responses to the questions below.
                    </p>

                    <div class="space-y-6">
                        <!-- What are you looking to adopt? -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                What are you looking to adopt? <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="adopt_type" value="Cat" class="text-primary">
                                    <span class="ml-2">Cat</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="adopt_type" value="Dog" class="text-primary">
                                    <span class="ml-2">Dog</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="adopt_type" value="Both" class="text-primary">
                                    <span class="ml-2">Both</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="adopt_type" value="Not Decided" class="text-primary">
                                    <span class="ml-2">Not Decided</span>
                                </label>
                            </div>
                        </div>

                        <!-- Are you applying to adopt a specific shelter animal? -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Are you applying to adopt a specific shelter animal? <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="specific_animal" value="Yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="specific_animal" value="No" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Describe your ideal pet -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Describe your ideal pet, including its sex, age, appearance, temperament, etc. <span class="text-red-500">*</span>
                            </label>
                            <textarea name="ideal_pet" rows="4" 
                                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                      placeholder="Describe your ideal pet in detail..."></textarea>
                        </div>

                        <!-- What type of building do you live in? -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                What type of building do you live in? <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="building_type" value="House" class="text-primary">
                                    <span class="ml-2">House</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="building_type" value="Condo" class="text-primary">
                                    <span class="ml-2">Condo</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="building_type" value="Apartment" class="text-primary">
                                    <span class="ml-2">Apartment</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="building_type" value="Other" class="text-primary">
                                    <span class="ml-2">Other</span>
                                </label>
                            </div>
                        </div>

                        <!-- Do you rent? -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Do you rent? <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="rent" value="Yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="rent" value="No" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- What happens to your pet if you move? -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                What happens to your pet if or when you move? <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pet_move_plan" placeholder="Your answer"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Who do you live with? -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Who do you live with? <span class="text-red-500">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="live_with[]" value="Living alone" class="text-primary">
                                    <span class="ml-2">Living alone</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="live_with[]" value="Children over 18" class="text-primary">
                                    <span class="ml-2">Children over 18</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="live_with[]" value="Spouse" class="text-primary">
                                    <span class="ml-2">Spouse</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="live_with[]" value="Children below 18" class="text-primary">
                                    <span class="ml-2">Children below 18</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="live_with[]" value="Parents and Relatives" class="text-primary">
                                    <span class="ml-2">Parents and Relatives</span>
                                </label>
                            </div>
                        </div>

                        <!-- Are any members allergic? -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Are any members of your household allergic to animals? <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="allergic" value="Yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="allergic" value="No" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Who will care for the pet? -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Who will be responsible for feeding, grooming, and generally caring for your pet? <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pet_caregiver" placeholder="Your answer"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Who will be financially responsible? -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Who will be financially responsible for your pet's needs (i.e. food, vet bills, etc.)? <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="financial_responsible" placeholder="Your answer"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Who will look after pet in emergency? -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Who will look after your pet if you go on vacation or in case of emergency? <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="emergency_care" placeholder="Your answer"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Hours pet left alone -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                How many hours in an average workday will your pet be left alone? <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="hours_alone" placeholder="Your answer"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Steps to introduce pet -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                What steps will you take to introduce your new pet to his/her new surroundings? <span class="text-red-500">*</span>
                            </label>
                            <textarea name="introduction_steps" rows="4" 
                                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                      placeholder="Describe your plan..."></textarea>
                        </div>

                        <!-- Family support decision? -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Does everyone in the family support your decision to adopt a pet? <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="family_support" value="Yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="family_support" value="No" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Please explain -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Please explain
                            </label>
                            <textarea name="family_support_explain" rows="2" 
                                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                      placeholder="Please explain..."></textarea>
                        </div>

                        <!-- Do you have other pets? -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Do you have other pets? <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="other_pets" value="Yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="other_pets" value="No" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Have you had pets in the past? -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Have you had pets in the past? <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="past_pets" value="Yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="past_pets" value="No" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
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
                            Next: Home Photos
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PART 4: HOME PHOTOS -->
                <div id="part4" class="form-part hidden">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 4: Home Photos</h3>
                    
                    <p class="text-sm text-gray-600 italic mb-4">
                        Please attach photos of your home. This has replaced our on-site ocular inspections.
                    </p>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Front of the house -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Front of the house</label>
                            <input type="file" name="photo_front_house" accept="image/*"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Street photo -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Street photo</label>
                            <input type="file" name="photo_street" accept="image/*"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Living room -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Living room</label>
                            <input type="file" name="photo_living_room" accept="image/*"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Dining area -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Dining area</label>
                            <input type="file" name="photo_dining" accept="image/*"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Kitchen -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Kitchen</label>
                            <input type="file" name="photo_kitchen" accept="image/*"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Bedroom/s -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Bedroom/s (if your pet will have access)</label>
                            <input type="file" name="photo_bedroom" accept="image/*"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Windows (if adopting a cat) -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Windows (if adopting a cat)</label>
                            <input type="file" name="photo_windows" accept="image/*"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Front & backyard (if adopting a dog) -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">Front & backyard (if adopting a dog)</label>
                            <input type="file" name="photo_backyard" accept="image/*"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 mt-4">
                        We value your privacy. Your photos will not be used for purposes other than this adoption application. <span class="text-red-500">*</span>
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Max. file size: 8mb</p>

                    <!-- Navigation Buttons for Part 4 -->
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="goToStep(3)" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </button>
                        <button type="button" onclick="goToStep(5)" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Next: Upload Valid ID
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PART 5: UPLOAD VALID ID -->
                <div id="part5" class="form-part hidden">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 5: Upload Valid ID</h3>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1.5">
                            Upload a valid ID <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="valid_id" accept="image/*"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <p class="text-xs text-gray-500 mt-1">Max. file size: 8mb</p>
                    </div>

                    <!-- Navigation Buttons for Part 5 -->
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="goToStep(4)" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </button>
                        <button type="button" onclick="goToStep(6)" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Next: Interview & Visitation
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- PART 6: INTERVIEW & VISITATION -->
                <div id="part6" class="form-part hidden">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b bg-green-50 px-4 py-2 rounded-lg">Part 6: Interview & Visitation</h3>
                    
                    <p class="text-sm text-gray-600 mb-4">
                        Minors must be accompanied by a parent or guardian.
                    </p>

                    <div class="space-y-6">
                        <!-- Zoom interview -->
                        <div>
                            <p class="text-sm font-medium mb-2">
                                Are you able to be interviewed through zoom meeting? <span class="text-red-500">*</span>
                            </p>
                            <p class="text-xs text-gray-500 italic mb-2">
                                if yes please fill in the questions below, if no proceed to the next question
                            </p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="zoom_interview" value="Yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="zoom_interview" value="No" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Preferred date for Zoom interview -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Preferred date for Zoom interview
                            </label>
                            <input type="date" name="zoom_date"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Preferred time for Zoom interview -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Preferred time for Zoom interview
                            </label>
                            <div class="flex gap-4">
                                <input type="number" name="zoom_time_hour" placeholder="HH" min="1" max="12"
                                       class="w-20 px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <input type="number" name="zoom_time_min" placeholder="MM" min="0" max="59"
                                       class="w-20 px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <select name="zoom_time_ampm"
                                        class="w-24 px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none appearance-none bg-white"
                                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23066D33%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 12px 12px;">
                                    <option value="AM">AM</option>
                                    <option value="PM">PM</option>
                                </select>
                            </div>
                            <p class="text-xs text-gray-500 italic mt-2">
                                We can't guarantee the availability of your requested time.
                            </p>
                        </div>

                        <!-- Shelter visit -->
                        <div>
                            <p class="text-sm font-medium mb-2">
                                Will you be able to visit the shelter for the meet-and-greet? <span class="text-red-500">*</span>
                            </p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="shelter_visit" value="Yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="shelter_visit" value="No" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons for Part 6 -->
                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="goToStep(5)" class="bg-gray-200 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Previous
                        </button>
                        <button type="submit"
                                class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-light transition-colors flex items-center">
                            Submit Application
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Back to Adoption Page Link -->
                    <div class="text-center mt-6">
                        <a href="{{ url('/adoption') }}" class="text-gray-600 hover:text-primary transition-colors">
                            ← Back to Adoption Page
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    // Format phone number with automatic spacing (3 3 4)
    function formatPhone(input) {
        let value = input.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 0) {
            // Format as XXX XXX XXXX
            if (value.length <= 3) {
                value = value;
            } else if (value.length <= 6) {
                value = value.substring(0, 3) + ' ' + value.substring(3);
            } else {
                value = value.substring(0, 3) + ' ' + value.substring(3, 6) + ' ' + value.substring(6, 10);
            }
        }
        input.value = value;
    }

    // Apply formatPhone to all phone fields on load
    document.addEventListener('DOMContentLoaded', function() {
        const phoneFields = document.querySelectorAll('input[name="mobile_number"], input[name="alt_phone"]');
        phoneFields.forEach(field => {
            field.addEventListener('input', function() {
                formatPhone(this);
            });
        });
    });

    // Step navigation
    function goToStep(step) {
        // Validate current step before moving forward
        if (!validateStep(step - 1) && step > 1) {
            return;
        }

        // Hide all parts
        document.querySelectorAll('.form-part').forEach(part => {
            part.classList.add('hidden');
        });

        // Show the target part
        document.getElementById('part' + step).classList.remove('hidden');

        // Update progress bar
        const progress = (step / 6) * 100;
        document.getElementById('progressBar').style.width = progress + '%';
        document.getElementById('stepLabel').textContent = 'Step ' + step + ' of 6';

        // Update step titles
        const titles = [
            '',
            'Part 1: Application Information',
            'Part 2: Alternate Contact',
            'Part 3: Questionnaire',
            'Part 4: Home Photos',
            'Part 5: Upload Valid ID',
            'Part 6: Interview & Visitation'
        ];
        document.getElementById('stepTitle').textContent = titles[step];

        // Update step indicators
        for (let i = 1; i <= 6; i++) {
            const indicator = document.getElementById('step' + i + 'Indicator');
            if (i <= step) {
                indicator.classList.remove('text-gray-400');
                indicator.classList.add('text-primary');
            } else {
                indicator.classList.remove('text-primary');
                indicator.classList.add('text-gray-400');
            }
        }

        // Scroll to top of form
        document.querySelector('.bg-white.border').scrollIntoView({ behavior: 'smooth' });
    }

    // Validation function for each step
    function validateStep(step) {
        const part = document.getElementById('part' + step);
        const requiredFields = part.querySelectorAll('[name]');
        let isValid = true;
        let firstError = null;

        // Clear previous error styles
        part.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500');
        });

        // Check required fields for this step
        requiredFields.forEach(field => {
            const name = field.name;
            
            // Skip checkbox arrays and non-required fields
            if (name.includes('[]') || 
                name === 'family_support_explain' || 
                name === 'alt_mobile_number' ||
                name === 'occupation' ||
                name === 'social_media' ||
                name === 'zoom_date' ||
                name === 'zoom_time_hour' ||
                name === 'zoom_time_min' ||
                name === 'zoom_time_ampm') {
                return;
            }

            // Check if required field is empty
            if (!field.value.trim() && field.type !== 'radio' && field.type !== 'checkbox') {
                isValid = false;
                field.classList.add('border-red-500');
                if (!firstError) firstError = field;
            }

            // Check radio buttons
            if (field.type === 'radio') {
                const radioGroup = part.querySelectorAll('input[name="' + name + '"]');
                const checked = Array.from(radioGroup).some(r => r.checked);
                if (!checked) {
                    isValid = false;
                    if (!firstError) firstError = radioGroup[0];
                }
            }

            // Check checkboxes
            if (field.type === 'checkbox' && field.name.includes('[]')) {
                const checkboxGroup = part.querySelectorAll('input[name="' + name + '"]');
                const checked = Array.from(checkboxGroup).some(c => c.checked);
                if (!checked) {
                    isValid = false;
                    if (!firstError) firstError = checkboxGroup[0];
                }
            }
        });

        if (!isValid) {
            // Show error message
            alert('Please fill in all required fields before proceeding.');
            if (firstError) {
                firstError.focus();
            }
            return false;
        }

        return true;
    }
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
