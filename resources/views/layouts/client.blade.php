<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Vet MIS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#066D33',
                        'primary-light': '#088442',
                        secondary: '#6B21A8',
                        'secondary-light': '#7C3AED',
                    }
                }
            }
        }
    </script>
    <style>
        .hero-bg {
            background: linear-gradient(rgba(6, 109, 51, 0.9), rgba(6, 109, 51, 0.8)), url('https://images.unsplash.com/photo-1587300003388-59208cc962cb?auto=format&fit=crop&q=80&w=2000');
            background-size: cover;
            background-position: center;
        }
        .pet-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(6, 109, 51, 0.15);
        }
    </style>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    {{ $slot }}
    
    @stack('scripts')
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        function showLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
        }

        function hideLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const button = e.target.closest('button[onclick="toggleDropdown()"]');
            if (!dropdown.contains(e.target) && !button) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>