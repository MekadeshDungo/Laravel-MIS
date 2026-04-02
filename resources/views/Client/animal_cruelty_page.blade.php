<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Cruelty & Pet Neglect - Dasmariñas City Veterinary Services</title>
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
        .faq-item {
            transition: all 0.3s ease;
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

    <!-- Hero Section -->
    <section class="bg-red-600 min-h-[500px] flex items-center justify-center py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side: Title and Description -->
                <div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">Animal Cruelty and Pet Neglect</h1>
                    <p class="text-lg md:text-xl text-red-100 max-w-xl mb-6">
                        Animal cruelty and pet neglect are criminal offenses. You must intervene. If the reporting citizen is committed to executing an affidavit and appearing in court, PAWS will provide FREE legal assistance.
                    </p>
                    <p class="text-lg md:text-xl text-red-100 max-w-xl mb-6">
                        Do not turn a blind eye. PAWS needs YOUR help to stop offenders from hurting other animals.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ url('/animal-cruelty/form') }}" class="bg-white text-red-600 px-8 py-4 rounded-xl font-semibold text-lg hover:bg-gray-200 transition-colors">
                            File a Report
                        </a>
                    </div>
                </div>
                
                <!-- Right Side: Placeholder Image -->
                <div class="flex justify-center">
                    <div class="w-full max-w-lg aspect-square bg-white/10 rounded-2xl flex items-center justify-center border border-white/20">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-white/50 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <p class="text-white/70 text-lg">Animal Protection</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to Stop Cruelty & Neglect Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Left Side: How to Stop sections -->
                <div class="space-y-8">
                    <!-- How to Stop Animal Cruelty -->
                    <div class="bg-red-50 rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-red-700 mb-4">How to Stop Animal Cruelty</h2>
                        <p class="text-gray-700">
                            When witnessing animal cruelty, which includes 'dog katay' or someone directly inflicting harm to an animal, stop the offender IMMEDIATELY and then call 911 or the barangay. Posting on social media is not the same as reporting to the authorities. By the time your post reaches the authorities, it will be too late.
                        </p>
                    </div>

                    <!-- How to Stop Pet Neglect -->
                    <div class="bg-yellow-50 rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-yellow-700 mb-4">How to Stop Pet Neglect</h2>
                        <p class="text-gray-700">
                            First, try the friendly approach and educate the pet owner on responsible pet ownership. If the behavior continues, you must gather evidence such as photos and videos showing a pattern of neglect and execute a witness affidavit. This is the only time that PAWS or the authorities can confiscate the neglected pet.
                        </p>
                    </div>
                </div>

                <!-- Right Side: FAQ -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
                    
                    <div class="space-y-4">
                        <!-- FAQ 1 -->
                        <div class="bg-gray-50 rounded-xl overflow-hidden">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-semibold text-gray-900">Can't you just confiscate animals from cruel or neglectful owners?</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden px-6 pb-4 text-gray-600">
                                <p>PAWS is not a government agency and does not have the authority to do this. Because animal cruelty and pet neglect are criminal offenses, they must be reported to the authorities by calling 911 or your barangay. Sadly, most people only report to PAWS but they are not willing to take any legal action. They call for justice, but they are unwilling to do their part as the witness.</p>
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="bg-gray-50 rounded-xl overflow-hidden">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-semibold text-gray-900">Is dog "katay" legal?</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden px-6 pb-4 text-gray-600">
                                <p>NO. If you see dog slaughter in progress, you must stop it IMMEDIATELY and report it to the barangay. In many cases, it is enough to save the animal's life.</p>
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="bg-gray-50 rounded-xl overflow-hidden">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-semibold text-gray-900">My pet got run over ("nasagasaan"). What can I do?</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden px-6 pb-4 text-gray-600">
                                <p>These cases are handled by the barangay or police. You may press charges, but also remember that allowing your pet to roam freely outside your home (even in the presence of the owner) is a violation of RA9482 or The Anti Rabies Act.</p>
                            </div>
                        </div>

                        <!-- FAQ 4 -->
                        <div class="bg-gray-50 rounded-xl overflow-hidden">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-semibold text-gray-900">My neighbor is neglecting their pet. Can you help?</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden px-6 pb-4 text-gray-600">
                                <p>Please talk to your neighbor first and attempt to educate them in a friendly manner. PAWS cannot intervene or confiscate an owned pet without legal grounds. If you wish to file a case, please follow due process so that PAWS can assist.</p>
                            </div>
                        </div>

                        <!-- FAQ 5 -->
                        <div class="bg-gray-50 rounded-xl overflow-hidden">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-semibold text-gray-900">Can you rescue if I agree to foster the animal?</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden px-6 pb-4 text-gray-600">
                                <p>Yes. As the animal's temporary caregiver, you also need to be present during the rescue operation and foster agreement signing. By doing this, you are providing the rescued animal a temporary home until they are vaccinated, neutered, and ready to be admitted to the shelter.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How to File a Case Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-start">
                <!-- Left Side: How to File a Case -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">How to File a Case</h2>
                    <p class="text-gray-700 mb-6">
                        Call barangay officials and/or police hotline 911 immediately. Posting on social media is NOT taking action. Tagging PAWS and other animal welfare groups is NOT taking action.
                    </p>
                    <p class="text-gray-700 mb-8">
                        We offer FREE LEGAL ASSISTANCE to pet owners and concerned citizens who want to pursue legal action against animal offenders. To qualify for this program, certain conditions need to be met.
                    </p>

                    <!-- FAQ Style Steps -->
                    <div class="space-y-4">
                        <!-- Step 1 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-semibold text-gray-900">1. Gather evidence</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden px-6 pb-4 text-gray-600">
                                <p>Often, the most compelling evidence is the animal itself. However, if it's not possible to confiscate the animal, other pieces of evidence must be present. Videos, photos, and other witness accounts will build a stronger case against the animal offender, especially if it's a case of pet neglect.</p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-semibold text-gray-900">2. Prepare the necessary documents</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden px-6 pb-4 text-gray-600">
                                <p class="mb-3">1) Witness affidavit (PRIORITY)</p>
                                <p class="mb-3">2) Complainant affidavit (could be different from the witness)</p>
                                <p class="mb-3">3) Copy of valid government ID of witness and complainant</p>
                                <p class="mb-3">4) Copy of blotter or incident report from the police/barangay</p>
                                <p class="mb-3">5) Photos/videos of the animal (as many as possible)</p>
                                <p class="mb-3">6) Veterinarian's affidavit and other attachments</p>
                                <p class="mt-4 text-sm italic">An affidavit is a narration of facts which include the complete details of the incident: 1) Name/s of the people involved, 2) date, time and location of the incident, and 3) a detailed description of the events that occurred. Without an affidavit, no charges can be filed.</p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-semibold text-gray-900">3. Sign an Agreement with PAWS</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden px-6 pb-4 text-gray-600">
                                <p>You need to sign an agreement with PAWS indicating that you, the complainant and primary witness, will not back out. This is because PAWS will be shouldering all the legal expenses, which will commence as soon as the case is filed. We do not want our efforts and resources to go to waste.</p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                            <button onclick="toggleFaq(this)" class="w-full px-6 py-4 text-left flex justify-between items-center focus:outline-none">
                                <span class="font-semibold text-gray-900">4. Testify in court</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="hidden px-6 pb-4 text-gray-600">
                                <p>Finally, you need to be prepared to appear in court and testify. PAWS has had numerous victories in court, all of which would not have been possible if it weren't for the determination and perseverance of ordinary citizens who bravely spoke on behalf of these voiceless, helpless victims.</p>
                            </div>
                        </div>
                        
                        <!-- File a Report Button -->
                        <div class="mt-6">
                            <a href="{{ url('/animal-cruelty/form') }}" class="inline-block bg-red-600 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:bg-red-700 transition-colors">
                                File a Report
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Placeholder Image -->
                <div class="flex justify-center lg:sticky lg:top-24">
                    <div class="w-full max-w-lg aspect-square bg-gradient-to-br from-red-100 to-red-200 rounded-2xl flex items-center justify-center shadow-lg">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-red-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                            <p class="text-red-600/70 text-lg font-medium">Legal Assistance</p>
                            <p class="text-red-500/50 text-sm">PAWS Free Legal Program</p>
                        </div>
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
                        <li><a href="{{ url('/about-us') }}" class="text-gray-600 hover:text-primary transition-colors">About Us</a></li>
                    </ul>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="font-semibold text-lg mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-primary transition-colors">Pet Registration</a></li>
                        <li><a href="{{ url('/kapon') }}" class="text-gray-600 hover:text-primary transition-colors">Kapon Program</a></li>
                        <li><a href="{{ url('/vaccination') }}" class="text-gray-600 hover:text-primary transition-colors">Anti-Rabies Vaccination</a></li>
                        <li><a href="{{ url('/adoption') }}" class="text-gray-600 hover:text-primary transition-colors">Adoption</a></li>
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
