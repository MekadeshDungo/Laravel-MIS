<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | VetMIS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-size: 1.5rem;
        }
        .hero-section {
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            color: white;
            padding: 80px 0;
        }
        .main-content {
            flex: 1;
        }
        .footer {
            background: #1a1a2e;
            color: white;
            padding: 3rem 0;
            margin-top: auto;
        }
        .announcement-card {
            transition: transform 0.3s;
        }
        .announcement-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-hospital-fill me-2"></i>VetMIS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('announcements.public.index') ? 'active' : '' }}" 
                           href="{{ route('announcements.public.index') }}">
                            <i class="bi bi-megaphone me-1"></i>Announcements
                        </a>
                    </li>
                    @if(auth()->check())
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-outline-light btn-sm" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Dashboard
                            </a>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-hospital-fill me-2"></i>VetMIS
                    </h5>
                    <p class="text-white-50">Veterinary Services Office Management Information System</p>
                    <p class="text-white-50 mb-0">Promoting animal health and public safety</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="fw-bold mb-3">Contact Us</h6>
                    <p class="mb-1"><i class="bi bi-geo-alt me-2"></i>City Veterinary Office</p>
                    <p class="mb-1"><i class="bi bi-telephone me-2"></i>(123) 456-7890</p>
                    <p class="mb-0"><i class="bi bi-envelope me-2"></i>vetoffice@example.com</p>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="row">
                <div class="col-md-6">
                    <small class="text-white-50">&copy; {{ date('Y') }} VetMIS. All rights reserved.</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-white-50">Office Hours: Monday - Friday, 8:00 AM - 5:00 PM</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
