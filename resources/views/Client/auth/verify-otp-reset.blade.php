<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Reset Code - Dasmariñas City Veterinary Services</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
</head>
<body class="font-sans antialiased bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full overflow-hidden flex-shrink-0">
                    <img src="{{ asset('images/dasma logo.png') }}" alt="Dasmariñas City Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Dasmariñas City Veterinary Services</h1>
                    <p class="text-sm text-gray-600">Official Veterinary Office of Dasmariñas City</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Title -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900">Reset Your Password</h2>
                <p class="mt-2 text-gray-600">We've sent a 6-digit verification code to</p>
                <p class="font-semibold text-primary">{{ $email }}</p>
            </div>

            <!-- Error/Success Messages -->
            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- OTP Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <form id="otpForm" method="POST" action="{{ route('password.otp.verify') }}">
                    @csrf
                    
                    <!-- OTP Inputs -->
                    <div class="flex justify-center gap-3 mb-8">
                        <input type="text" class="otp-input w-14 h-14 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" maxlength="1" name="otp1" required>
                        <input type="text" class="otp-input w-14 h-14 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" maxlength="1" name="otp2" required>
                        <input type="text" class="otp-input w-14 h-14 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" maxlength="1" name="otp3" required>
                        <input type="text" class="otp-input w-14 h-14 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" maxlength="1" name="otp4" required>
                        <input type="text" class="otp-input w-14 h-14 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" maxlength="1" name="otp5" required>
                        <input type="text" class="otp-input w-14 h-14 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" maxlength="1" name="otp6" required>
                    </div>
                    
                    <input type="hidden" name="otp" id="fullOtp">
                    
                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-primary hover:bg-primary-light text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                        Verify Code
                    </button>
                </form>
                
                <!-- Resend Link -->
                <div class="mt-6 text-center">
                    <p class="text-gray-600">Didn't receive the code?</p>
                    <a href="{{ route('password.otp.resend') }}" id="resendLink" class="text-primary hover:text-primary-light font-semibold">Resend Code</a>
                    <p class="text-sm text-gray-500 mt-2">Resend available in <span id="countdown">60</span> seconds</p>
                </div>
            </div>
            
            <!-- Back to Forgot Password -->
            <div class="mt-6 text-center">
                <a href="{{ route('password.request') }}" class="text-gray-600 hover:text-primary">
                    ← Back to Forgot Password
                </a>
            </div>
        </div>
    </main>

    <script>
        // Auto-focus and auto-advance inputs
        const inputs = document.querySelectorAll('.otp-input');
        
        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1) {
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                }
            });
            
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && e.target.value === '') {
                    if (index > 0) {
                        inputs[index - 1].focus();
                    }
                }
            });
            
            // Only allow numbers
            input.addEventListener('keypress', (e) => {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });
        
        // Form submission - combine all 6 inputs into one
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let otp = '';
            inputs.forEach(input => {
                otp += input.value;
            });
            
            document.getElementById('fullOtp').value = otp;
            
            // Submit the form
            this.submit();
        });
        
        // Countdown timer for resend
        let countdown = 60;
        const countdownElement = document.getElementById('countdown');
        const resendLink = document.getElementById('resendLink');
        
        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                resendLink.style.pointerEvents = 'auto';
                resendLink.style.opacity = '1';
            }
        }, 1000);
    </script>
</body>
</html>