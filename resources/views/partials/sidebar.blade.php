<aside id="sidebar" class="sidebar bg-slate-900 text-white fixed left-0 top-0 z-50"
       style="width:260px; height:100vh;">
    <!-- Brand -->
    <div class="p-6 border-b border-slate-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="bi bi-hospital-fill text-white text-lg"></i>
            </div>
            <div>
                <h1 class="font-bold text-lg">Vet MIS</h1>
                <p class="text-xs text-slate-400 capitalize">
                    {{ str_replace('_', ' ', auth()->user()->role ?? 'Admin') }} Portal
                </p>
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

    @php
        $role = auth()->user()->role ?? 'admin';

        // Role -> route name prefix
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

        $isSuperAdmin = ($role === 'super_admin');
        $isAdmin = ($role === 'admin');
        $isBarangay = in_array($role, ['barangay', 'barangay_encoder']);
        $isAdminPortal = $isSuperAdmin || $isAdmin;

        // Dashboard route (always exists per role in your routes)
        $dashboardRoute = $prefix . '.dashboard';
    @endphp

    <!-- Navigation (SCROLLABLE) -->
    <nav class="p-4 space-y-1 overflow-y-auto" style="height: calc(100vh - 180px);">
        <!-- Dashboard -->
        <a href="{{ route($dashboardRoute) }}"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs($prefix.'.dashboard') ? 'bg-blue-600' : '' }}">
            <i class="bi bi-grid-1x2 text-lg w-6"></i>
            <span>Dashboard</span>
        </a>

        {{-- =========================
            SUPER ADMIN MENU
           ========================= --}}
        @if($isSuperAdmin)
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
        @endif

        {{-- =========================
            ADMIN MENU
           ========================= --}}
        @elseif($isAdmin)
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
        @elseif($isBarangay)
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

        <!-- Logout (ALWAYS SHOW) -->
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

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (!sidebar || !overlay) return;

    sidebar.classList.toggle('open');
    sidebar.classList.toggle('hidden');

    overlay.classList.toggle('hidden');
    overlay.classList.toggle('active');
}
</script>
