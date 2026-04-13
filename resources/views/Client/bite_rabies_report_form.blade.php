<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rabies Bite Incident Report - Dasmariñas City Veterinary Services</title>

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
            </nav>
        </div>
    </div>
</header>

<!-- Main -->
<main class="py-10">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Title -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold">Rabies Bite Incident Report</h2>
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
            <form method="POST" action="{{ route('bite-rabies-report.store') }}">
                @csrf

                <!-- SECTION I: SOURCE OF REPORT -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        I. SOURCE OF REPORT
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Reporting Facility -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Reporting Facility <span class="text-red-500">*</span>
                            </label>
                            <select name="reporting_facility" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('reporting_facility') border-red-500 @enderror">
                                <option value="">Select Facility Type</option>
                                <option value="Registered Veterinary Clinics" {{ old('reporting_facility') == 'Registered Veterinary Clinics' ? 'selected' : '' }}>Registered Veterinary Clinics</option>
                                <option value="Animal Bite Centers (ABCs)" {{ old('reporting_facility') == 'Animal Bite Centers (ABCs)' ? 'selected' : '' }}>Animal Bite Centers (ABCs)</option>
                                <option value="Hospitals" {{ old('reporting_facility') == 'Hospitals' ? 'selected' : '' }}>Hospitals</option>
                                <option value="Others" {{ old('reporting_facility') == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('reporting_facility')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Facility Name (for Others) -->
                        <div id="facility_name_container" class="{{ old('reporting_facility') == 'Others' ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium mb-1.5">
                                Facility Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="facility_name" value="{{ old('facility_name') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('facility_name') border-red-500 @enderror"
                                   placeholder="Enter facility name">
                            @error('facility_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Reported -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Date Reported <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_reported" value="{{ old('date_reported', date('Y-m-d')) }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('date_reported') border-red-500 @enderror">
                            @error('date_reported')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION II: PATIENT (HUMAN) INFORMATION -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        II. PATIENT (HUMAN) INFORMATION
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Full Name / Case ID -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Full Name / Case ID <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="patient_name" value="{{ old('patient_name') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('patient_name') border-red-500 @enderror"
                                   placeholder="Last Name, First Name, Middle Name or Case ID">
                            @error('patient_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Age -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Age <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="patient_age" value="{{ old('patient_age') }}" min="0" max="150"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('patient_age') border-red-500 @enderror"
                                   placeholder="Enter age">
                            @error('patient_age')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Gender <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="patient_gender" value="Male" {{ old('patient_gender') == 'Male' ? 'checked' : '' }}
                                           class="text-primary focus:ring-primary">
                                    <span class="ml-2">Male</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="patient_gender" value="Female" {{ old('patient_gender') == 'Female' ? 'checked' : '' }}
                                           class="text-primary focus:ring-primary">
                                    <span class="ml-2">Female</span>
                                </label>
                            </div>
                            @error('patient_gender')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address (Barangay) -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Address (Barangay) <span class="text-red-500">*</span>
                            </label>
                            <select name="patient_barangay_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('patient_barangay_id') border-red-500 @enderror">
                                <option value="">Select Barangay</option>
                                @foreach($barangays as $barangay)
                                    <option value="{{ $barangay->barangay_id }}" {{ old('patient_barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                                        {{ $barangay->barangay_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_barangay_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Contact Number <span class="text-red-500">*</span>
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-4 py-2.5 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
                                    +63
                                </span>
                                <input type="tel" name="patient_contact" value="{{ old('patient_contact') }}" maxlength="11"
                                       class="flex-1 px-4 py-2.5 rounded-r-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('patient_contact') border-red-500 @enderror"
                                       placeholder="91234567890">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Must be exactly 11 digits</p>
                            @error('patient_contact')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION III: INCIDENT DETAILS -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        III. INCIDENT DETAILS
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Date of Incident -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Date of Incident <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="incident_date" value="{{ old('incident_date') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('incident_date') border-red-500 @enderror">
                            @error('incident_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nature of Incident -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Nature of Incident <span class="text-red-500">*</span>
                            </label>
                            <select name="nature_of_incident" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('nature_of_incident') border-red-500 @enderror">
                                <option value="">Select Nature</option>
                                <option value="Bitten" {{ old('nature_of_incident') == 'Bitten' ? 'selected' : '' }}>Bitten</option>
                                <option value="Scratched" {{ old('nature_of_incident') == 'Scratched' ? 'selected' : '' }}>Scratched</option>
                                <option value="Licked (Open Wound)" {{ old('nature_of_incident') == 'Licked (Open Wound)' ? 'selected' : '' }}>Licked (Open Wound)</option>
                            </select>
                            @error('nature_of_incident')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bite Site (Body Part) -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Bite Site (Body Part) <span class="text-red-500">*</span>
                            </label>
                            <select name="bite_site" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('bite_site') border-red-500 @enderror">
                                <option value="">Select Body Part</option>
                                <option value="Head/Neck" {{ old('bite_site') == 'Head/Neck' ? 'selected' : '' }}>Head/Neck</option>
                                <option value="Upper Extremities" {{ old('bite_site') == 'Upper Extremities' ? 'selected' : '' }}>Upper Extremities</option>
                                <option value="Trunk" {{ old('bite_site') == 'Trunk' ? 'selected' : '' }}>Trunk</option>
                                <option value="Lower Extremities" {{ old('bite_site') == 'Lower Extremities' ? 'selected' : '' }}>Lower Extremities</option>
                            </select>
                            @error('bite_site')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Exposure Category -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Exposure Category <span class="text-red-500">*</span>
                            </label>
                            <select name="exposure_category" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('exposure_category') border-red-500 @enderror">
                                <option value="">Select Category</option>
                                <option value="Category I (Lick)" {{ old('exposure_category') == 'Category I (Lick)' ? 'selected' : '' }}>Category I (Lick)</option>
                                <option value="Category II (Scratch)" {{ old('exposure_category') == 'Category II (Scratch)' ? 'selected' : '' }}>Category II (Scratch)</option>
                                <option value="Category III (Bite / Deep)" {{ old('exposure_category') == 'Category III (Bite / Deep)' ? 'selected' : '' }}>Category III (Bite / Deep)</option>
                            </select>
                            <div class="mt-1">
                                <button type="button" class="text-xs text-primary hover:underline" onclick="toggleTooltip('exposure-tooltip')">
                                    What does this mean?
                                </button>
                                <div id="exposure-tooltip" class="hidden mt-2 p-3 bg-gray-100 rounded-lg text-xs">
                                    <p><strong>Category I:</strong> Touching/feeding animals, licks on intact skin</p>
                                    <p><strong>Category II:</strong> Nibbling, scratches without bleeding, licks on broken skin</p>
                                    <p><strong>Category III:</strong> Bites, deep scratches, mucous membrane contact with saliva</p>
                                </div>
                            </div>
                            @error('exposure_category')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Incident Location (Barangay) -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Incident Location (Barangay) <span class="text-red-500">*</span>
                            </label>
                            <select name="barangay_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('barangay_id') border-red-500 @enderror" required>
                                <option value="">Select Incident Location</option>
                                @foreach($barangays as $barangay)
                                    <option value="{{ $barangay->barangay_id }}" {{ old('barangay_id') == $barangay->barangay_id ? 'selected' : '' }}>
                                        {{ $barangay->barangay_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SECTION IV: ANIMAL INFORMATION -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        IV. ANIMAL INFORMATION
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Animal Species -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Animal Species <span class="text-red-500">*</span>
                            </label>
                            <select name="animal_species" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('animal_species') border-red-500 @enderror">
                                <option value="">Select Species</option>
                                <option value="Dog" {{ old('animal_species') == 'Dog' ? 'selected' : '' }}>Dog</option>
                                <option value="Cat" {{ old('animal_species') == 'Cat' ? 'selected' : '' }}>Cat</option>
                                <option value="Others" {{ old('animal_species') == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('animal_species')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Animal Status -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Animal Status <span class="text-red-500">*</span>
                            </label>
                            <select name="animal_status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('animal_status') border-red-500 @enderror">
                                <option value="">Select Status</option>
                                <option value="Stray" {{ old('animal_status') == 'Stray' ? 'selected' : '' }}>Stray</option>
                                <option value="Owned" {{ old('animal_status') == 'Owned' ? 'selected' : '' }}>Owned</option>
                                <option value="Wild" {{ old('animal_status') == 'Wild' ? 'selected' : '' }}>Wild</option>
                            </select>
                            @error('animal_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Animal Owner Name -->
                        <div id="animal_owner_container" class="{{ old('animal_status') == 'Owned' ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium mb-1.5">
                                Animal Owner Name
                            </label>
                            <input type="text" name="animal_owner_name" value="{{ old('animal_owner_name') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                   placeholder="Enter owner's name">
                        </div>

                        <!-- Vaccination Status -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Vaccination Status <span class="text-red-500">*</span>
                            </label>
                            <select name="animal_vaccination_status" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('animal_vaccination_status') border-red-500 @enderror">
                                <option value="">Select Status</option>
                                <option value="Vaccinated" {{ old('animal_vaccination_status') == 'Vaccinated' ? 'selected' : '' }}>Vaccinated</option>
                                <option value="Unvaccinated" {{ old('animal_vaccination_status') == 'Unvaccinated' ? 'selected' : '' }}>Unvaccinated</option>
                                <option value="Unknown" {{ old('animal_vaccination_status') == 'Unknown' ? 'selected' : '' }}>Unknown</option>
                            </select>
                            @error('animal_vaccination_status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Condition -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Current Condition <span class="text-red-500">*</span>
                            </label>
                            <select name="animal_current_condition" class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none @error('animal_current_condition') border-red-500 @enderror">
                                <option value="">Select Condition</option>
                                <option value="Healthy / Alive" {{ old('animal_current_condition') == 'Healthy / Alive' ? 'selected' : '' }}>Healthy / Alive</option>
                                <option value="Dead" {{ old('animal_current_condition') == 'Dead' ? 'selected' : '' }}>Dead</option>
                                <option value="Missing / Escaped" {{ old('animal_current_condition') == 'Missing / Escaped' ? 'selected' : '' }}>Missing / Escaped</option>
                                <option value="Euthanized" {{ old('animal_current_condition') == 'Euthanized' ? 'selected' : '' }}>Euthanized</option>
                            </select>
                            @error('animal_current_condition')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SECTION V: CLINICAL ACTION -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        V. CLINICAL ACTION
                    </h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Wound Management -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Wound Management
                            </label>
                            <div class="space-y-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="wound_management[]" value="Washed with Soap"
                                           {{ is_array(old('wound_management')) && in_array('Washed with Soap', old('wound_management')) ? 'checked' : '' }}
                                           class="text-primary focus:ring-primary rounded">
                                    <span class="ml-2">Washed with Soap</span>
                                </label>
                                <br>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="wound_management[]" value="Antiseptic Applied"
                                           {{ is_array(old('wound_management')) && in_array('Antiseptic Applied', old('wound_management')) ? 'checked' : '' }}
                                           class="text-primary focus:ring-primary rounded">
                                    <span class="ml-2">Antiseptic Applied</span>
                                </label>
                                <br>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="wound_management[]" value="None"
                                           {{ is_array(old('wound_management')) && in_array('None', old('wound_management')) ? 'checked' : '' }}
                                           class="text-primary focus:ring-primary rounded">
                                    <span class="ml-2">None</span>
                                </label>
                            </div>
                        </div>

                        <!-- Post-Exposure Prophylaxis (PEP) -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Post-Exposure Prophylaxis (PEP) <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="post_exposure_prophylaxis" value="Yes" {{ old('post_exposure_prophylaxis') == 'Yes' ? 'checked' : '' }}
                                           class="text-primary focus:ring-primary">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="post_exposure_prophylaxis" value="No" {{ old('post_exposure_prophylaxis') == 'No' ? 'checked' : '' }}
                                           class="text-primary focus:ring-primary">
                                    <span class="ml-2">No</span>
                                </label>
                            </div>
                            @error('post_exposure_prophylaxis')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Additional Notes -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Additional Notes
                            </label>
                            <textarea name="notes" rows="3"
                                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none"
                                      placeholder="Enter any additional information...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-center space-y-4">
                    <button type="submit" class="bg-primary text-white px-12 py-4 rounded-xl font-semibold text-lg hover:bg-primary-light transition-colors">
                        Submit Report
                    </button>
                    <div>
                        <a href="{{ url('/') }}" class="inline-block text-gray-600 hover:text-primary transition-colors">
                            ← Back to Home
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-white text-gray-900 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-500 text-sm">© 2025 Dasmariñas City Veterinary Services. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    // Show/hide facility name field
    document.querySelector('select[name="reporting_facility"]').addEventListener('change', function() {
        const facilityNameContainer = document.getElementById('facility_name_container');
        if (this.value === 'Others') {
            facilityNameContainer.classList.remove('hidden');
        } else {
            facilityNameContainer.classList.add('hidden');
        }
    });

    // Show/hide animal owner field
    document.querySelector('select[name="animal_status"]').addEventListener('change', function() {
        const ownerContainer = document.getElementById('animal_owner_container');
        if (this.value === 'Owned') {
            ownerContainer.classList.remove('hidden');
        } else {
            ownerContainer.classList.add('hidden');
        }
    });

    // Toggle tooltip
    function toggleTooltip(id) {
        const element = document.getElementById(id);
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
        } else {
            element.classList.add('hidden');
        }
    }
</script>

</body>
</html>
