<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Vet MIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, -apple-system, sans-serif; }
        .sidebar { width: 260px; position: fixed; height: 100vh; transition: all 0.3s ease; }
        .nav-item.active { background: linear-gradient(90deg, rgba(59,130,246,0.2) 0%, transparent 100%); border-left: 3px solid #3b82f6; }
        .nav-item:hover { background: rgba(59,130,246,0.1); }
        main { margin-left: 260px; min-height: 100vh; transition: margin-left 0.3s ease; }
        .sidebar-section { padding: 1rem 0.75rem; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-title { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; color: #64748b; padding: 0 0.75rem; margin-bottom: 0.5rem; }

        @media (max-width: 767px) {
            .sidebar { left: -260px; z-index: 50; }
            .sidebar.open { left: 0; }
            main { margin-left: 0; }
            .sidebar-overlay.active { display: block !important; }
        }
    </style>
</head>

<body class="bg-gray-100 m-0 p-0">
@php
    // announcement route prefix: admin.* or super-admin.*
    $role = auth()->user()->role ?? 'admin';
    $annPrefix = ($role === 'super_admin') ? 'super-admin' : 'admin';

    // Only admin/super_admin should have portal announcements routes
    $canManageAnnouncements = in_array($role, ['admin', 'super_admin']);
@endphp

    <!-- Mobile Header -->
    <header class="md:hidden bg-white shadow-sm fixed w-full z-40">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-center gap-2">
                <button onclick="toggleSidebar()" class="p-2 rounded-lg hover:bg-gray-100">
                    <i class="bi bi-list text-xl text-gray-700"></i>
                </button>
                <div class="flex items-center gap-2">
                    <i class="bi bi-hospital-fill text-blue-600 text-xl"></i>
                    <span class="font-bold text-gray-800">Vet MIS</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 rounded-lg hover:bg-gray-100 relative">
                        <i class="bi bi-bell text-xl text-gray-700"></i>
                        @if(\App\Models\Announcement::where('created_at', '>=', now()->subDays(7))->count() > 0)
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        @endif
                    </button>

                    <div x-show="open" @click.away="open = false"
                         class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50"
                         style="display: none;">

                        <div class="px-4 py-2 border-b border-gray-100">
                            <h4 class="font-semibold text-gray-800">Announcements</h4>
                        </div>

                        <div class="max-h-64 overflow-y-auto">
                            @forelse(\App\Models\Announcement::latest()->take(5)->get() as $announcement)
                                @if($canManageAnnouncements)
                                    <a href="{{ route($annPrefix . '.announcements.show', $announcement->id) }}"
                                       class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 last:border-0 transition">
                                        <p class="text-sm font-semibold text-gray-800">{{ $announcement->title }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ Str::limit($announcement->content, 80) }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $announcement->created_at->diffForHumans() }}</p>
                                    </a>
                                @else
                                    {{-- For non-admin roles, send them to the public announcements page --}}
                                    <a href="{{ route('announcements.public.index') }}"
                                       class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 last:border-0 transition">
                                        <p class="text-sm font-semibold text-gray-800">{{ $announcement->title }}</p>
                                        <p class="text-xs text-gray-600 mt-1">{{ Str::limit($announcement->content, 80) }}</p>
                                        <p class="text-xs text-gray-400 mt-1">{{ $announcement->created_at->diffForHumans() }}</p>
                                    </a>
                                @endif
                            @empty
                            <div class="px-4 py-6 text-center text-gray-500">
                                <i class="bi bi-bell-slash text-2xl mb-2 block"></i>
                                <p class="text-sm">No announcements</p>
                            </div>
                            @endforelse
                        </div>

                        @if(\App\Models\Announcement::count() > 5)
                        <div class="px-4 py-2 border-t border-gray-100">
                            @if($canManageAnnouncements)
                                <a href="{{ route($annPrefix . '.announcements.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                                    View all announcements
                                </a>
                            @else
                                <a href="{{ route('announcements.public.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                                    View all announcements
                                </a>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar bg-slate-900 text-white">
        <!-- Brand -->
        <div class="p-6 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="bi bi-hospital-fill text-white text-lg"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg">Vet MIS</h1>
                    <p class="text-xs text-slate-400 capitalize">{{ str_replace('_', ' ', auth()->user()->role ?? 'Admin') }} Portal</p>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="p-4 border-b border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                    <span class="font-semibold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-sm truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-slate-400">{{ auth()->user()->email ?? 'admin@vetmis.gov.ph' }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-4 space-y-1 overflow-y-auto" style="height: calc(100vh - 180px);">
            <!-- Dashboard -->
            @php
                $role = auth()->user()->role ?? 'admin';
                $routeMap = [
                    'super_admin'      => 'super-admin',
                    'admin'            => 'admin',
                    'city_vet'         => 'city-vet',
                    'admin_staff'      => 'admin-staff',
                    'disease_control'  => 'disease-control',
                    'city_pound'       => 'city-pound',
                    'meat_inspector'   => 'meat-inspection',
                    'records_staff'    => 'records-staff',
                    'barangay'         => 'barangay',
                    'barangay_encoder' => 'barangay',
                    'clinic'           => 'clinic',
                    'viewer'           => 'viewer',
                    'inventory_staff'  => 'inventory',
                ];
                $prefix = $routeMap[$role] ?? 'admin';
                $dashboardRoute = $prefix . '.dashboard';
            @endphp
            <a href="{{ route($dashboardRoute) }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs($prefix.'.dashboard') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-grid-1x2 text-lg w-6"></i>
                <span>Dashboard</span>
            </a>

            @if(auth()->user()->role === 'super_admin')
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">System Admin</p>
            </div>

            <a href="{{ route('super-admin.users.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('super-admin.users.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-people text-lg w-6"></i>
                <span>User Management</span>
            </a>

            <a href="{{ route('super-admin.system-logs.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('super-admin.system-logs.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-journal-text text-lg w-6"></i>
                <span>System Logs</span>
            </a>

            <a href="{{ route('super-admin.announcements.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('super-admin.announcements.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-megaphone text-lg w-6"></i>
                <span>Announcements</span>
            </a>

            <a href="{{ route('super-admin.all-reports') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('super-admin.all-reports') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-file-earmark-bar-graph text-lg w-6"></i>
                <span>Reports Summary</span>
            </a>
            @elseif(auth()->user()->role === 'admin')
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Operations</p>
            </div>

            <a href="{{ route('admin.users.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('admin.users.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-people text-lg w-6"></i>
                <span>Staff Accounts</span>
            </a>

            <a href="{{ route('admin.system-logs.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('admin.system-logs.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-journal-text text-lg w-6"></i>
                <span>System Logs</span>
            </a>

            <a href="{{ route('admin.announcements.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('admin.announcements.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-megaphone text-lg w-6"></i>
                <span>Announcements</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Reports</p>
            </div>

            <a href="{{ route('admin.bite-reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('admin.bite-reports.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-exclamation-triangle text-lg w-6"></i>
                <span>Animal Bite Reports</span>
            </a>

            <a href="{{ route('admin.vaccination-reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('admin.vaccination-reports.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-shield-check text-lg w-6"></i>
                <span>Rabies Vaccinations</span>
            </a>

            <a href="{{ route('admin.meat-inspection-reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('admin.meat-inspection-reports.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-clipboard-check text-lg w-6"></i>
                <span>Meat Inspection</span>
            </a>

            <a href="{{ route('admin.all-reports') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('admin.all-reports') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-file-earmark-bar-graph text-lg w-6"></i>
                <span>All Reports</span>
            </a>
            @elseif(in_array(auth()->user()->role, ['barangay', 'barangay_encoder']))
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Operations</p>
            </div>

            <a href="{{ route('announcements.public.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('announcements.public.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-megaphone text-lg w-6"></i>
                <span>Announcements (View Only)</span>
            </a>

            <a href="{{ route('barangay.data-entry') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('barangay.data-entry') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-pencil-square text-lg w-6"></i>
                <span>Data Entry</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Reports</p>
            </div>

            <a href="{{ route('barangay.reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('barangay.reports.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-exclamation-triangle text-lg w-6"></i>
                <span>Stray Reports</span>
            </a>

            <a href="{{ route('barangay.impounds.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('barangay.impounds.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-archive text-lg w-6"></i>
                <span>Impounds</span>
            </a>

            <a href="{{ route('barangay.notifications.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('barangay.notifications.*') ? 'bg-blue-600' : '' }}">
                <i class="bi bi-bell text-lg w-6"></i>
                <span>Notifications</span>
            </a>
            @else
            {{-- Other roles get basic menu - dashboard and logout only --}}
            @endif

            <!-- Logout -->
            <div class="pt-4 mt-4 border-t border-slate-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="nav-item w-full flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition">
                        <i class="bi bi-box-arrow-right text-lg w-6"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <main>
        <!-- Top Bar -->
        <header class="bg-white shadow-sm sticky top-0 z-30 hidden md:block">
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                    @yield('breadcrumb')
                    <p class="text-sm text-gray-500">@yield('subheader', 'Welcome back')</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg relative">
                            <i class="bi bi-bell text-xl"></i>
                            @if(\App\Models\Announcement::where('created_at', '>=', now()->subDays(7))->count() > 0)
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            @endif
                        </button>

                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50"
                             style="display: none;">

                            <div class="px-4 py-2 border-b border-gray-100">
                                <h4 class="font-semibold text-gray-800">Announcements</h4>
                            </div>

                            <div class="max-h-64 overflow-y-auto">
                                @forelse(\App\Models\Announcement::latest()->take(5)->get() as $announcement)
                                    @if($canManageAnnouncements)
                                        <a href="{{ route($annPrefix . '.announcements.show', $announcement->id) }}"
                                           class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 last:border-0 transition">
                                            <p class="text-sm font-semibold text-gray-800">{{ $announcement->title }}</p>
                                            <p class="text-xs text-gray-600 mt-1">{{ Str::limit($announcement->content, 80) }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $announcement->created_at->diffForHumans() }}</p>
                                        </a>
                                    @else
                                        <a href="{{ route('announcements.public.index') }}"
                                           class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-50 last:border-0 transition">
                                            <p class="text-sm font-semibold text-gray-800">{{ $announcement->title }}</p>
                                            <p class="text-xs text-gray-600 mt-1">{{ Str::limit($announcement->content, 80) }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $announcement->created_at->diffForHumans() }}</p>
                                        </a>
                                    @endif
                                @empty
                                <div class="px-4 py-6 text-center text-gray-500">
                                    <i class="bi bi-bell-slash text-2xl mb-2 block"></i>
                                    <p class="text-sm">No announcements</p>
                                </div>
                                @endforelse
                            </div>

                            @if(\App\Models\Announcement::count() > 5)
                            <div class="px-4 py-2 border-t border-gray-100">
                                @if($canManageAnnouncements)
                                    <a href="{{ route($annPrefix . '.announcements.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                                        View all announcements
                                    </a>
                                @else
                                    <a href="{{ route('announcements.public.index') }}" class="text-sm text-blue-600 hover:text-blue-700">
                                        View all announcements
                                    </a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-semibold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <span class="text-sm text-gray-700 hidden md:block">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="p-4 md:p-6 pt-16 md:pt-24">
            @yield('content')
        </div>
    </main>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden hidden" onclick="toggleSidebar()"></div>

    <script type="module">
        function testPushNotification() {
            alert('Push notification sent!');
        }
    </script>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var overlay = document.getElementById('sidebar-overlay');
            if (sidebar && overlay) {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('open');
                overlay.classList.toggle('hidden');
                overlay.classList.toggle('active');

                if (sidebar.classList.contains('open')) {
                    sidebar.style.left = '0';
                    document.body.style.overflow = 'hidden';
                } else {
                    sidebar.style.left = '-260px';
                    document.body.style.overflow = 'auto';
                }
            }
        }
    </script>
</body>
</html>
