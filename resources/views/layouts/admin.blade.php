<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Dasmariñas City Veterinary Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: { 50:'#eef2ff',100:'#e0e7ff',200:'#c7d2fe',300:'#a5b4fc',400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca',800:'#3730a3',900:'#312e81',950:'#1e1b4b' },
                        sidebar: { DEFAULT:'#0f172a',light:'#1e293b',hover:'#334155',active:'#1e40af' }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }

        .sidebar {
            width: 256px;
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 50;
            transition: transform 0.25s ease;
        }

        main {
            margin-left: 256px;
            min-height: 100vh;
        }

        .main-header {
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            border-radius: 8px;
            color: #94a3b8;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.15s ease;
            text-decoration: none;
        }
        .nav-item:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .nav-item.active-nav {
            background: #15803d;
            color: #fff;
            box-shadow: 0 2px 8px rgba(21,128,61,0.35);
        }
        .nav-item i { width: 20px; text-align: center; font-size: 16px; flex-shrink: 0; }

        .sidebar-divider { height: 1px; background: rgba(255,255,255,0.1); margin: 12px 16px; }
        .sidebar-section-label {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #86efac;
            padding: 12px 16px 6px;
        }

        @media (max-width: 767px) {
            .sidebar { transform: translateX(-256px); }
            .sidebar.open { transform: translateX(0); }
            main { margin-left: 0; }
            .sidebar-overlay.active { display: block !important; }
        }
    </style>
</head>

<body class="bg-slate-50 m-0 p-0 min-h-screen">
@php
    $role = auth()->check() ? auth()->user()->role : null;
@endphp

    <!-- Mobile Header -->
    <header class="md:hidden bg-white border-b border-slate-200 fixed w-full z-40">
        <div class="flex items-center justify-between px-4 h-14">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="p-1.5 rounded-lg hover:bg-slate-100">
                    <i class="bi bi-list text-xl text-slate-600"></i>
                </button>
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/dasma logo.png') }}" alt="Logo" class="w-7 h-7 rounded object-contain">
                    <span class="font-bold text-slate-800 text-sm">City Vet MIS</span>
                </div>
            </div>
            <div class="w-8 h-8 bg-brand-600 rounded-full flex items-center justify-center">
                <span class="text-white text-xs font-bold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-green-800 text-white">
        <!-- Brand -->
        <div class="flex items-center gap-3 px-5 h-16 border-b border-green-700">
            <img src="{{ asset('images/dasma logo.png') }}" alt="Logo" class="w-9 h-9 rounded-lg object-contain bg-white p-0.5">
            <div class="min-w-0">
                <h1 class="font-bold text-[14px] leading-tight truncate">Dasmariñas City Vet</h1>
                <p class="text-[10px] text-green-200 leading-tight">Disease Surveillance MIS</p>
            </div>
        </div>

        <!-- User Info -->
        <div class="px-4 py-3 border-b border-green-700">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="font-bold text-sm">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[13px] font-medium text-green-100 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[11px] text-green-300 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
            </div>
        </div>

        @php
            $role = auth()->check() ? auth()->user()->role : null;
            $routeMap = [
                'super_admin'      => 'super-admin',
                'admin'            => 'admin',
                'city_vet'         => 'city-vet',
                'admin_staff'      => 'admin-staff',
                'admin_asst'       => 'admin-asst',
                'assistant_vet'    => 'assistant-vet',
                'livestock_inspector' => 'livestock',
                'meat_inspector'   => 'meat-inspection',
                'citizen'          => 'owner',
            ];
            $prefix = $routeMap[$role] ?? 'admin';
            $dashboardRoute = $prefix . '.dashboard';
        @endphp

        <!-- Navigation -->
        <nav class="px-3 py-4 overflow-y-auto" style="height: calc(100vh - 140px);">
            <div class="sidebar-section-label">Main</div>
            <a href="{{ route($dashboardRoute) }}"
               class="nav-item {{ request()->routeIs($prefix.'.dashboard') ? 'active-nav' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>

            @if(auth()->check() && auth()->user()->role === 'super_admin')
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">System Admin</div>

            <a href="{{ route('super-admin.users.index') }}" class="nav-item {{ request()->routeIs('super-admin.users.*') ? 'active-nav' : '' }}">
                <i class="bi bi-people"></i><span>User Management</span>
            </a>
            <a href="{{ route('super-admin.system-logs.index') }}" class="nav-item {{ request()->routeIs('super-admin.system-logs.*') ? 'active-nav' : '' }}">
                <i class="bi bi-journal-text"></i><span>System Logs</span>
            </a>
            <a href="{{ route('super-admin.announcements.index') }}" class="nav-item {{ request()->routeIs('super-admin.announcements.*') ? 'active-nav' : '' }}">
                <i class="bi bi-megaphone"></i><span>Announcements</span>
            </a>

            @elseif(auth()->check() && auth()->user()->role === 'admin')
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Operations</div>

            <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active-nav' : '' }}">
                <i class="bi bi-people"></i><span>Staff Accounts</span>
            </a>
            <a href="{{ route('admin.system-logs.index') }}" class="nav-item {{ request()->routeIs('admin.system-logs.*') ? 'active-nav' : '' }}">
                <i class="bi bi-journal-text"></i><span>System Logs</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Reports</div>


                <i class="bi bi-exclamation-triangle"></i><span>Animal Bite Reports</span>
            </a>
            <a href="{{ route('admin.vaccination-reports.index') }}" class="nav-item {{ request()->routeIs('admin.vaccination-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-shield-check"></i><span>Rabies Anti-Rabies Vaccination</span>
            </a>
            <a href="{{ route('admin.meat-inspection-reports.index') }}" class="nav-item {{ request()->routeIs('admin.meat-inspection-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-clipboard-check"></i><span>Meat Inspection</span>
            </a>
            <a href="{{ route('admin.all-reports') }}" class="nav-item {{ request()->routeIs('admin.all-reports') ? 'active-nav' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i><span>All Reports</span>
            </a>

            @elseif(auth()->check() && auth()->user()->role === 'city_vet')
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Rabies Control</div>

            <a href="{{ route('city-vet.rabies-geomap') }}" class="nav-item {{ request()->routeIs('city-vet.rabies-geomap') ? 'active-nav' : '' }}">
                <i class="bi bi-map"></i><span>Rabies Geomap</span>
            </a>
            <!-- TODO: Re-enable if needed -->
            <!-- <a href="{{ route('city-vet.exposure-cases.index') }}" class="nav-item {{ request()->routeIs('city-vet.exposure-cases.*') ? 'active-nav' : '' }}">
                <i class="bi bi-shield-exclamation"></i><span>Exposure Cases</span>
            </a> -->
            <!-- <a href="{{ route('city-vet.rabies-cases.index') }}" class="nav-item {{ request()->routeIs('city-vet.rabies-cases.*') ? 'active-nav' : '' }}">
                <i class="bi bi-exclamation-triangle"></i><span>Rabies Cases</span>
            </a> -->
            <a href="{{ route('city-vet.rabies-bite-reports.index') }}" class="nav-item {{ request()->routeIs('city-vet.rabies-bite-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-virus"></i><span>Bite & Rabies Reports</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Anti-Rabies Vaccination</div>

            <a href="{{ route('city-vet.vaccination-reports.index') }}" class="nav-item {{ request()->routeIs('city-vet.vaccination-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-shield-check"></i><span>Vaccination Reports</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Management</div>

            <a href="{{ route('city-vet.impounds.index') }}" class="nav-item {{ request()->routeIs('city-vet.impounds.*') ? 'active-nav' : '' }}">
                <i class="bi bi-archive"></i><span>Impound Records</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Reports</div>

            <a href="{{ route('city-vet.all-reports') }}" class="nav-item {{ request()->routeIs('city-vet.all-reports') ? 'active-nav' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i><span>Analytics & Reports</span>
            </a>

            @elseif(auth()->check() && auth()->user()->role === 'admin_staff')
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Records</div>

            <a href="{{ route('admin-staff.pets.index') }}" class="nav-item {{ request()->routeIs('admin-staff.pets.*') ? 'active-nav' : '' }}">
                <i class="bi bi-paw"></i><span>Pet Registration</span>
            </a>
            <a href="{{ route('admin-staff.owners.index') }}" class="nav-item {{ request()->routeIs('admin-staff.owners.*') ? 'active-nav' : '' }}">
                <i class="bi bi-people"></i><span>Owner Records</span>
            </a>
            <a href="{{ route('admin-staff.vaccinations.index') }}" class="nav-item {{ request()->routeIs('admin-staff.vaccinations.*') ? 'active-nav' : '' }}">
                <i class="bi bi-shield-check"></i><span>Vaccination Encoding</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Missing Pets</div>

            <a href="{{ route('admin-staff.missing-pets.index') }}" class="nav-item {{ request()->routeIs('admin-staff.missing-pets.*') ? 'active-nav' : '' }}">
                <i class="bi bi-exclamation-triangle"></i><span>Missing Pets</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Adoption</div>

            <a href="{{ route('admin-staff.adoption-pets.index') }}" class="nav-item {{ request()->routeIs('admin-staff.adoption-pets.*') ? 'active-nav' : '' }}">
                <i class="bi bi-hearts"></i><span>Adoption Pets</span>
            </a>
            <a href="{{ route('admin-staff.adoption-pets.create') }}" class="nav-item {{ request()->routeIs('admin-staff.adoption-pets.create') ? 'active-nav' : '' }}">
                <i class="bi bi-plus-circle"></i><span>Add Pet for Adoption</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Medical</div>

            <a href="{{ route('assistant-vet.medical-records.index') }}" class="nav-item {{ request()->routeIs('assistant-vet.medical-records.*') ? 'active-nav' : '' }}">
                <i class="bi bi-file-medical"></i><span>Medical & Vaccination Records</span>
            </a>

            @elseif(auth()->check() && auth()->user()->role === 'assistant_vet')
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Clinical</div>

            <!-- <a href="{{ route('assistant-vet.rabies-cases.index') }}" class="nav-item {{ request()->routeIs('assistant-vet.rabies-cases.*') ? 'active-nav' : '' }}">
                <i class="bi bi-exclamation-triangle"></i><span>Rabies Cases</span>
            </a> -->
            <a href="{{ route('city-vet.rabies-bite-reports.index') }}" class="nav-item {{ request()->routeIs('city-vet.rabies-bite-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-file-medical"></i><span>Bite Reports</span>
            </a>
            <a href="{{ route('assistant-vet.vaccinations.index') }}" class="nav-item {{ request()->routeIs('assistant-vet.vaccinations.*') ? 'active-nav' : '' }}">
                <i class="bi bi-shield-check"></i><span>Anti-Rabies Vaccination</span>
            </a>
            <a href="{{ route('assistant-vet.spay-neuter.index') }}" class="nav-item {{ request()->routeIs('assistant-vet.spay-neuter.*') ? 'active-nav' : '' }}">
                <i class="bi bi-heart"></i><span>Spay/Neuter</span>
            </a>

            @elseif(auth()->check() && auth()->user()->role === 'admin_asst')
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Gatekeeper</div>

            <a href="{{ route('admin-asst.pet-registrations.index') }}" class="nav-item {{ request()->routeIs('admin-asst.pet-registrations.*') ? 'active-nav' : '' }}">
                <i class="bi bi-paw"></i><span>Pet Registrations</span>
            </a>
            <a href="{{ route('admin-asst.adoptions.index') }}" class="nav-item {{ request()->routeIs('admin-asst.adoptions.*') ? 'active-nav' : '' }}">
                <i class="bi bi-heart-fill"></i><span>Adoptions</span>
            </a>
            <a href="{{ route('admin-asst.missing-pets.index') }}" class="nav-item {{ request()->routeIs('admin-asst.missing-pets.*') ? 'active-nav' : '' }}">
                <i class="bi bi-search"></i><span>Missing Pets</span>
            </a>

            @elseif(auth()->check() && auth()->user()->role === 'meat_inspector')
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Meat Inspection</div>

            <a href="{{ route('meat-inspection.meat-shop.index') }}" class="nav-item {{ request()->routeIs('meat-inspection.meat-shop.*') ? 'active-nav' : '' }}">
                <i class="bi bi-shop"></i><span>Shop Inspections</span>
            </a>
            <a href="{{ route('meat-inspection.establishments.index') }}" class="nav-item {{ request()->routeIs('meat-inspection.establishments.*') ? 'active-nav' : '' }}">
                <i class="bi bi-shop-window"></i><span>Register Shop</span>
            </a>

            @elseif(auth()->check() && auth()->user()->role === 'livestock_inspector')
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Livestock</div>

            <a href="{{ route('livestock.dashboard') }}" class="nav-item {{ request()->routeIs('livestock.dashboard') ? 'active-nav' : '' }}">
                <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('livestock.census') }}" class="nav-item {{ request()->routeIs('livestock.census') ? 'active-nav' : '' }}">
                <i class="bi bi-bar-chart-line"></i><span>Livestock Census</span>
            </a>
            <a href="{{ route('livestock.index') }}" class="nav-item {{ request()->routeIs('livestock.index') ? 'active-nav' : '' }}">
                <i class="bi bi-list-check"></i><span>Livestock Records</span>
            </a>
            <a href="{{ route('establishments.index') }}" class="nav-item {{ request()->routeIs('establishments.index') && !request()->routeIs('meat-inspection.establishments.*') ? 'active-nav' : '' }}">
                <i class="bi bi-shop"></i><span>Business Profiling</span>
            </a>

            @elseif(auth()->check() && auth()->user()->role === 'veterinarian')
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Clinic Portal</div>

            <a href="{{ route('clinic.dashboard') }}" class="nav-item {{ request()->routeIs('clinic.dashboard') ? 'active-nav' : '' }}">
                <i class="bi bi-speedometer2"></i><span>Dashboard</span>
            </a>

            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Reports</div>

            <a href="{{ route('clinic.bite-reports.index') }}" class="nav-item {{ request()->routeIs('clinic.bite-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-exclamation-triangle"></i><span>Bite Reports</span>
            </a>
            <a href="{{ route('clinic.bite-reports.create') }}" class="nav-item {{ request()->routeIs('clinic.bite-reports.create') ? 'active-nav' : '' }}">
                <i class="bi bi-plus-circle"></i><span>Submit Bite Report</span>
            </a>
            <a href="{{ route('clinic.vaccination-reports.index') }}" class="nav-item {{ request()->routeIs('clinic.vaccination-reports.*') ? 'active-nav' : '' }}">
                <i class="bi bi-eyedropper"></i><span>Vaccination Reports</span>
            </a>
            <a href="{{ route('clinic.vaccination-reports.create') }}" class="nav-item {{ request()->routeIs('clinic.vaccination-reports.create') ? 'active-nav' : '' }}">
                <i class="bi bi-plus-circle"></i><span>New Vaccination</span>
            </a>

            @else
            <div class="sidebar-divider"></div>
            <div class="sidebar-section-label">Information</div>
            @endif

            <div class="sidebar-divider"></div>
            <div class="px-2 pt-2 mt-auto flex justify-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-item">
                        <i class="bi bi-box-arrow-right"></i><span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main>
        <!-- Top Bar -->
        <header class="main-header bg-white border-b border-slate-200 hidden md:block">
            <div class="flex items-center justify-between px-6 h-16">
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">@yield('header', 'Dashboard')</h2>
                    <p class="text-xs text-slate-400 mt-0.5">@yield('subheader', 'Welcome back')</p>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Notifications -->
                    @php
                        $unreadNotifications = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->latest()->take(10)->get();
                        $unreadCount = $unreadNotifications->count();
                    @endphp
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative p-2 rounded-lg hover:bg-slate-100 transition">
                            <i class="bi bi-bell text-xl text-slate-600"></i>
                            @if($unreadCount > 0)
                                <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </button>
                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-slate-200 z-50 hidden" style="display: none;">
                            <div class="p-3 border-b border-slate-100">
                                <h3 class="font-semibold text-slate-800">Notifications</h3>
                            </div>
                            <div class="max-h-80 overflow-y-auto">
                                @forelse($unreadNotifications as $notification)
                                    <a href="#" class="block p-3 hover:bg-slate-50 border-b border-slate-50 last:border-0">
                                        <div class="flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $notification->priority === 'high' ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                                <i class="bi bi-bell-fill text-sm"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-sm font-medium text-slate-800 truncate">{{ $notification->title }}</p>
                                                <p class="text-xs text-slate-500 truncate">{{ $notification->message }}</p>
                                                <p class="text-[10px] text-slate-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-4 text-center text-slate-500">
                                        <i class="bi bi-bell-slash text-2xl mb-2"></i>
                                        <p class="text-sm">No new notifications</p>
                                    </div>
                                @endforelse
                            </div>
                            @if($unreadCount > 0)
                                <div class="p-2 border-t border-slate-100">
                                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-center text-sm text-blue-600 hover:text-blue-800 py-1">
                                            Mark all as read
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pl-3 border-l border-slate-200">
                        <div class="w-8 h-8 bg-brand-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs font-bold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <span class="text-sm font-medium text-slate-600 hidden md:block">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 md:hidden hidden" onclick="toggleSidebar()"></div>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('hidden');
                overlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : 'auto';
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
