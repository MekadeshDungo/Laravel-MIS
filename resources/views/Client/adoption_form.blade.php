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

        <!-- Form Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-8">
            <form method="POST" action="#" enctype="multipart/form-data">
                @csrf

                <!-- APPLICATION INFO -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">APPLICATION INFO</h3>

                    <div class="grid md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Name <span class="text-red-500">*</span>
                                <span class="text-gray-500 text-xs ml-2">(First name and Last name)</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" name="first_name" placeholder="First Name"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                                <input type="text" name="last_name" placeholder="Last Name"
                                       class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="address" placeholder="Lot/Block/Street/Subdivision/Barangay"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Phone <span class="text-red-500">*</span>
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-4 py-2.5 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
                                    +63
                                </span>
                                <input type="tel" name="phone" placeholder="943 210 2012" maxlength="12"
                                       class="flex-1 px-4 py-2.5 rounded-r-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" placeholder="name@example.com"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Birth Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="birth_date"
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

                        <!-- Pronouns -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Pronouns <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="pronouns" placeholder="He/Him, She/Her, They/Them"
                                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
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

                <!-- ALTERNATE CONTACT -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">ALTERNATE CONTACT</h3>

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

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium mb-1.5">
                                Phone <span class="text-red-500">*</span>
                            </label>
                            <div class="flex">
                                <span class="inline-flex items-center px-4 py-2.5 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
                                    +63
                                </span>
                                <input type="tel" name="alt_phone" placeholder="943 210 2012" maxlength="12"
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
                </div>

                <!-- QUESTIONNAIRE -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">QUESTIONNAIRE</h3>
                    
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
                </div>

                <!-- HOME PHOTOS -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">HOME PHOTOS</h3>
                    
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
                </div>

                <!-- UPLOAD VALID ID -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">UPLOAD VALID ID</h3>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1.5">
                            Upload a valid ID <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="valid_id" accept="image/*"
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        <p class="text-xs text-gray-500 mt-1">Max. file size: 8mb</p>
                    </div>
                </div>

                <!-- INTERVIEW & VISITATION -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">INTERVIEW & VISITATION</h3>
                    
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
                </div>

                <!-- SUBMIT -->
                <button type="submit"
                        class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-light">
                    Submit Application
                </button>
            </form>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6 text-sm">
            <a href="{{ url('/adoption') }}" class="text-primary font-medium">← Back to Adoption</a>
        </div>
    </div>
</main>

</body>
</html>
