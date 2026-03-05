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
<header class="bg-white border-b border-gray-200">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center space-x-4">
        <img src="{{ asset('images/dasma logo.png') }}" class="w-12 h-12 object-contain" alt="Logo">
        <div>
            <h1 class="text-lg font-bold">Dasmariñas City Veterinary Services</h1>
            <p class="text-sm text-gray-600">Official Veterinary Office of Dasmariñas City</p>
        </div>
    </div>
</header>

<!-- Main -->
<main class="py-10">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Title -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">SPAY/NEUTER (KAPON)</h2>
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

        <!-- Form Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-8">
            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf

                <!-- A. OWNER'S INFO -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">A. OWNER'S INFO</h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Pet Owner's Name <span class="text-red-500">*</span>
                                <span class="text-gray-500 text-xs ml-2">(First name and Last name)</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="first_name" placeholder="First Name"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <input type="text" name="last_name" placeholder="Last Name"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" placeholder="Enter Email"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Confirm Email -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Confirm Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="confirm_email" placeholder="Confirm Email"
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
                                <input type="tel" name="mobile_number" placeholder="943 210 2012" maxlength="12"
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
                            <input type="text" name="house_no" placeholder="House No. / Unit No."
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Street -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Street <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="street" placeholder="Street"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Barangay -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Barangay <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="barangay" placeholder="Barangay"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>
                    </div>
                </div>

                <!-- B. PET'S INFO -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">B. PET'S INFO</h3>

                    <!-- Important Notes -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                        <p class="font-semibold text-yellow-700 mb-2">IMPORTANT NOTES:</p>
                        <ul class="list-disc list-inside text-sm text-yellow-700 space-y-1">
                            <li><strong>Single Booking Restriction:</strong> At the moment, only one booking can be submitted for the same patient types (species/gender). If you have different patient types and would like them scheduled on the same date, please email us.</li>
                            <li><strong>Post-Cesarean/Major Surgery Cases:</strong> If your pet has undergone cesarean or major surgery related to reproductive organs, please book at another veterinary clinic.</li>
                            <li><strong>Vaccinations and Kapon Surgery:</strong> If your pet has been recently vaccinated or is scheduled for vaccination, we recommend scheduling 2 weeks before or after.</li>
                        </ul>
                        <p class="text-sm text-yellow-600 mt-2 italic">Upon submitting your application, please check your email and download the attached documents regarding your pet's pre- and post-operative care.</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Patient Type -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Patient Type (Species / Gender) <span class="text-red-500">*</span>
                            </label>
                            <select name="patient_type" id="patient_type" 
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <option value="">Select Patient Type</option>
                                <option value="male_cat">Male Cat</option>
                                <option value="female_cat">Female Cat</option>
                                <option value="male_dog">Male Dog</option>
                                <option value="female_dog">Female Dog</option>
                            </select>
                        </div>

                        <!-- Number of Pets (dynamic based on patient type) -->
                        <div class="md:col-span-2" id="pet_count_container">
                            <label class="block text-sm font-medium mb-1.5" id="pet_count_label">
                                How many male cats? <span class="text-red-500">*</span>
                            </label>
                            <select name="pet_count" id="pet_count"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="more">More than 10</option>
                            </select>
                        </div>

                        <!-- Breed -->
                        <div class="md:col-span-2" id="breedSection">
                            <label class="block text-sm font-medium mb-1" id="breed_label">
                                Breed <span class="text-red-500">*</span>
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
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden input to store selected breed value -->
                            <input type="hidden" name="breed" id="breedInput" value="">
                            
                            <!-- Display selected breed tags -->
                            <div id="selectedBreedDisplay" class="mt-3 hidden">
                                <div class="flex flex-wrap gap-2" id="selectedBreedTags"></div>
                            </div>
                        </div>

                        <!-- Pet's Weight -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Pet's Weight <span class="text-red-500">*</span>
                                <span class="text-gray-500 text-xs">(in kgs, if you do not know the weight type "N/A")</span>
                            </label>
                            <input type="text" name="pet_weight" placeholder="Weight in kg"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Pet's Age -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Pet's Age <span class="text-red-500">*</span>
                            </label>
                            <select name="pet_age"
                                    class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <option value="">Select Age</option>
                                <option value="6-8_months">6-8 months</option>
                                <option value="9-11_months">9-11 months</option>
                                <option value="1_year">1 year old</option>
                                <option value="2-3_years">2-3 years old</option>
                                <option value="4_years">4 years old</option>
                                <option value="5-6_years">5-6 years old</option>
                                <option value="7-8_years">7-8 years old</option>
                                <option value="9-10_years">9-10 years old</option>
                                <option value="11-14_years">11-14 years old</option>
                                <option value="15_plus">15 years old and above</option>
                                <option value="stray">Stray (Unknown)</option>
                            </select>
                        </div>

                        <!-- Pet's Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Pet's Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pet_name" placeholder="Pet's Name"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Date -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="appointment_date"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Upload Photos -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Upload photos of Pet/s <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                <input type="file" name="pet_photos[]" id="pet_photos" multiple accept="image/*"
                                       class="hidden">
                                <label for="pet_photos" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-gray-600">Click to upload photos</p>
                                    <p class="text-sm text-gray-500 mt-1">Please upload clear photos of your pet so our veterinarian can properly evaluate.</p>
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 italic mt-1">Required views: Head, Face, Body – top and side view (while standing on all four legs) and Genitals. Max. file size: 8MB</p>
                        </div>
                    </div>
                </div>

                <!-- C. AGREEMENT -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">C. AGREEMENT</h3>

                    <!-- Blood Test Section -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <p class="font-medium text-gray-700 mb-2">Blood Test Agreement</p>
                        
                        <!-- For mixed/purebred dogs and/or over 4 years old -->
                        <div class="mb-4" id="blood_test_mixed">
                            <p class="text-sm text-gray-600 mb-2">For those with mixed or purebred dogs and/or over 4 years old:</p>
                            <p class="text-xs text-gray-500 mb-2">A Blood test package for CBC, SGPT & CREA is available at the PAWS Clinic for only ₱1,250 (inclusive of check-up). This will be scheduled by our staff prior to the kapon schedule as results cannot be released on the same day. Please also be informed that we do not recommend pursuing blood tests for in-heat female dogs.</p>
                            
                            <div class="space-y-2">
                                <label class="inline-flex items-start">
                                    <input type="radio" name="blood_test_mixed_option" value="office_test" class="mt-1 text-primary">
                                    <span class="ml-2 text-sm text-gray-700">Yes, I would like to have blood test (CBC, SGPT & CREA) of my pet at the office before my chosen kapon appointment date.</span>
                                </label>
                                <label class="inline-flex items-start">
                                    <input type="radio" name="blood_test_mixed_option" value="submit_results" class="mt-1 text-primary">
                                    <span class="ml-2 text-sm text-gray-700">Yes, I will submit the blood test results (CBC, SGPT & CREA) of my pet/s to vetdasma@gmail.com 2 days before my chosen appointment date.</span>
                                </label>
                                <label class="inline-flex items-start">
                                    <input type="radio" name="blood_test_mixed_option" value="waiver_mixed" class="mt-1 text-primary">
                                    <span class="ml-2 text-sm text-gray-700">This waiver does not apply to me, my pet/s is/are healthy CAT/ASPIN (not mixed/purebred dog) under 4 years old. <strong class="text-red-600">The Vet and its shelter veterinarian will not be held liable in the event of complications, injury, or death that may result from the surgery due to undiagnosed illnesses that could have been treated if a blood test was performed.</strong></span>
                                </label>
                            </div>
                        </div>

                        <!-- For Aspins, Cats under 4 years old -->
                        <div id="blood_test_aspin">
                            <p class="text-sm text-gray-600 mb-2">For those with Aspins, Cats under 4 years old:</p>
                            <p class="text-xs text-gray-500 mb-2">A Blood test package for CBC, SGPT & CREA is available at the PAWS Clinic for only ₱1,250 (inclusive of check-up).</p>
                            
                            <div class="space-y-2">
                                <label class="inline-flex items-start">
                                    <input type="radio" name="blood_test_aspin_option" value="office_test" class="mt-1 text-primary">
                                    <span class="ml-2 text-sm text-gray-700">I would like to have the blood test of my pet at PAWS before my chosen kapon appointment date.</span>
                                </label>
                                <label class="inline-flex items-start">
                                    <input type="radio" name="blood_test_aspin_option" value="submit_results" class="mt-1 text-primary">
                                    <span class="ml-2 text-sm text-gray-700">I will submit the blood test results of my pet/s to vetdasma@gmail.com 2 days before my chosen appointment date.</span>
                                </label>
                                <label class="inline-flex items-start">
                                    <input type="radio" name="blood_test_aspin_option" value="waive_risk" class="mt-1 text-primary">
                                    <span class="ml-2 text-sm text-gray-700">I understand the risks of not getting the blood test for my pet/s so I am waiving the option as I am sure that my pet/s is/are healthy ASPIN/S or CAT/S under 4 years old. <strong class="text-red-600">The Vet and its shelter veterinarian will not be held liable in the event of complications, injury, or death that may result from the surgery due to undiagnosed illnesses that could have been treated if a blood test was performed.</strong></span>
                                </label>
                                <p class="text-xs text-gray-500 ml-6 italic">DO NOT choose this option if your dog/s is/are mixed/purebred or over 4 years old. NO option to waive for these categories.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Yes/No Questions -->
                    <div class="space-y-4">
                        <!-- Never spayed/neutered -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                My pet/s has/have never been spayed or neutered before. <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="never_spayed" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="never_spayed" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Previous surgery -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                My pet had undergone previous surgery. <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="previous_surgery" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="previous_surgery" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Good health -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                My pet/s has/have been in good health for the past three weeks or longer. <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="good_health" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="good_health" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Other health information -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Other health information about your pet
                            </label>
                            <p class="text-xs text-gray-500 italic mb-2">If your pet has any existing or previously treated health condition that was not disclosed to us prior to the procedure, PAWS cannot be held liable for any health issues that may arise afterward.</p>
                            <textarea name="health_info" rows="3"
                                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none resize-y"
                                      placeholder="Please share any relevant medical information..."></textarea>
                        </div>

                        <!-- Physical Assessment -->
                        <div>
                            <label class="inline-flex items-start">
                                <input type="checkbox" name="physical_assessment" value="yes" class="mt-1 text-primary">
                                <span class="ml-2 text-sm text-gray-700"><strong>Physical Assessment:</strong> Your pet's safety is our priority. While we offer low-cost kapon and our resident licensed veterinarian is highly capable of performing the procedure, please understand that as an NGO with limited facilities and no confinement area; we may not be equipped to handle certain medical conditions. By checking the box, you acknowledged that a veterinary assessment is required before surgery, and that the procedure may be declined based on the results of the evaluation.</span>
                            </label>
                        </div>

                        <!-- Pyometra -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                My pet has pyometra <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="pyometra" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="pyometra" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- In Heat -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                My dog/s is/are in heat. <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="in_heat" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="in_heat" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Fasting -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                My pet/s will not eat any food or any liquids for the past 12 hours prior to surgery. <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="fasting" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="fasting" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Secure cage/leash -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                I understand that I must place my pets inside a secure cage or leash. PAWS will not be liable for any escaped animals due to defective cages or leashes. <span class="text-red-500">*</span>
                            </label>
                            <p class="text-xs text-gray-500 italic mb-2">Many cases of animals escaping involve soft or foldable or collapsible cages that have not been secured properly. Also, please do not attempt to open your pet's cages or remove leashes within the veterinary office.</p>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="secure_cage" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="secure_cage" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Keep indoors -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                I will keep my pet/s indoors until they are fully healed (2-3 days for cats; 1 week for dogs; 2 weeks for pregnant females). <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="keep_indoors" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="keep_indoors" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Keep incision dry -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                I will keep their incision dry and refrain from bathing this animal for the next 2 weeks, and place an e-collar if needed. <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="keep_dry" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="keep_dry" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Full authority -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                I hereby give the PAWS Animal Rehabilitation Center (PARC) and its attending veterinarians and staff, full authority while the animal is under their care, to perform the spay/neuter operation and whatever treatment that the latter feel may be necessary. <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="full_authority" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="full_authority" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>

                        <!-- Valid ID -->
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                I will bring and present a valid primary ID before entering the premises of PAWS for security purposes. <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="valid_id" value="yes" class="text-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="valid_id" value="no" class="text-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation of Location and Costs -->
                    <div class="mt-6">
                        <label class="inline-flex items-start">
                            <input type="checkbox" name="confirmation" value="yes" class="mt-1 text-primary">
                            <span class="ml-2 text-sm text-gray-700"><strong>Confirmation of location and costs:</strong> I am aware that the spay/neuter surgery will be performed at the veterinary office located in Dasmariñas City. I have also reviewed the rates below and I am aware of the estimated total cost and all no-shows will be charged 50% of the spay/neuter fee.</span>
                        </label>
                    </div>

                    <!-- Rates Card -->
                    <div class="mt-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                        <h4 class="text-lg font-bold text-green-700 mb-4">Kapon Base Rates</h4>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <p class="font-medium text-gray-700">Native Female cat</p>
                                <p class="text-primary font-bold">₱1,000</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <p class="font-medium text-gray-700">Native Male cat</p>
                                <p class="text-primary font-bold">₱700</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <p class="font-medium text-gray-700">Native Female dog up to 15kg</p>
                                <p class="text-primary font-bold">₱1,500</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <p class="font-medium text-gray-700">Native Female dog 16-20kg</p>
                                <p class="text-primary font-bold">₱2,000</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <p class="font-medium text-gray-700">Native Male dog up to 15kg</p>
                                <p class="text-primary font-bold">₱1,000</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <p class="font-medium text-gray-700">Native Male dog 16-20kg</p>
                                <p class="text-primary font-bold">₱1,500</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-4 italic">Additional fees may apply for mixed/purebred, pregnant, undescended testicles, pyometra, and excess weight.</p>
                    </div>

                    <!-- Disclaimer -->
                    <div class="mt-4 bg-red-50 border-l-4 border-red-500 p-4">
                        <p class="text-sm text-red-700">*** The Philippine Animal Welfare Society and its licensed veterinarian will not be held liable in the event of complications, including injury or death, during surgery. These may result due to undiagnosed illnesses that may be detected and treated if a blood test is performed.</p>
                        <p class="text-sm text-red-700 mt-2">*** Pure and half-breed pets or brachycephalic (short-nosed) breeds are required to submit the results of blood tests prior to surgery. It is highly recommended that aspins and puspins with preexisting conditions be tested as well.</p>
                        <p class="text-sm text-red-700 mt-2">*** Photos of brachycephalic breed (short-nose dogs), small breeds and overweight breeds are needed to be evaluated first by our veterinarian before getting their blood test as some of them cannot be accommodated at the PAWS clinic as they may need confinement which is not available at PAWS.</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center space-y-4">
                    <button type="submit" class="bg-primary text-white px-12 py-4 rounded-xl font-semibold text-lg hover:bg-primary-light transition-colors">
                        Submit
                    </button>
                    <div>
                        <a href="{{ url('/kapon') }}" class="inline-block text-gray-600 hover:text-primary transition-colors">
                            ← Back to Kapon
                        </a>
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
