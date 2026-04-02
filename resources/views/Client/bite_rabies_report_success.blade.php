<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Submitted - Dasmariñas City Veterinary Services</title>

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
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-lg w-full">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-primary px-8 py-6 text-center">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white">Report Submitted Successfully</h1>
            </div>

            <!-- Content -->
            <div class="p-8 text-center">
                <p class="text-gray-600 mb-6">Your Bite & Rabies Incident Report has been submitted and is now pending review by the City Veterinary Office.</p>

                @if(isset($reportNumber))
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                    <p class="text-sm text-green-700 font-medium mb-1">Your Report Number</p>
                    <p class="text-2xl font-bold text-green-800">{{ $reportNumber }}</p>
                </div>
                @endif

                <p class="text-sm text-gray-500 mb-8">Please save this number for your records. You may use it to follow up on the status of your report.</p>

                <a href="{{ url('/') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Back to Home
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">Dasmariñas City Veterinary Services</p>
    </div>
</body>
</html>
