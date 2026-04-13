<aside id="sidebar" class="sidebar bg-green-800 text-white fixed left-0 top-0 z-50"
       style="width:260px; height:100vh;">
    <!-- Brand -->
    <div class="p-6 border-b border-green-700">
        <div class="flex items-center gap-3">
            <img src="{{ asset('images/dasma logo.png') }}" alt="Logo" class="w-10 h-10 rounded-lg object-contain bg-white p-1">
            <div>
                <h1 class="font-bold text-lg">Dasmariñas City Veterinary Services</h1>
                <p class="text-xs text-green-200">
                    Official Veterinary Office of Dasmariñas City
                </p>
            </div>
        </div>
    </div>

    <!-- User Info -->
    <div class="p-4 border-b border-green-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                <span class="font-semibold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-medium text-sm truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-green-300">{{ auth()->user()->email ?? 'admin@vetmis.gov.ph' }}</p>
            </div>
        </div>
    </div>

    @php
        $role = auth()->user()->getRoleAttribute() ?? 'city_vet';

        // Role -> route name prefix
        $routeMap = [
            'super_admin'      => 'super-admin',
            'city_vet'         => 'city-vet',
            'admin_staff'      => 'admin-staff',
            'admin_asst'       => 'admin-asst',
            'assistant_vet'    => 'assistant-vet',
            'livestock_inspector' => 'livestock',
            'meat_inspector'   => 'meat-inspection',
            'citizen'          => 'owner',
            'clinic'           => 'clinic',
            'hospital'         => 'hospital',
        ];

        $prefix = $routeMap[$role] ?? 'city-vet';

        $isSuperAdmin = ($role === 'super_admin');
        $isAdmin = ($role === 'city_vet');
        $isCityVet = ($role === 'city_vet');
        $isAdminStaff = ($role === 'admin_staff');
        $isAdminAsst = ($role === 'admin_asst');
        $isAssistantVet = ($role === 'assistant_vet');
        $isLivestockInspector = ($role === 'livestock_inspector');
        $isMeatInspector = ($role === 'meat_inspector');
        $isCityPound = ($role === 'city_pound');
        $isClinic = in_array($role, ['clinic', 'hospital']);

        // Dashboard route (always exists per role in your routes)
        $dashboardRoute = $prefix . '.dashboard';
    @endphp

    <!-- Navigation (SCROLLABLE) -->
    <nav class="p-4 space-y-1 overflow-y-auto" style="height: calc(100vh - 180px);">
        <!-- Dashboard -->
        <a href="{{ route($dashboardRoute) }}"
           class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs($prefix.'.dashboard') ? 'bg-green-600 text-white' : '' }}">
            <i class="bi bi-grid-1x2 text-lg w-6"></i>
            <span>Dashboard</span>
        </a>

        {{-- =========================
            SUPER ADMIN MENU
           ========================= --}}
        @if($isSuperAdmin)
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">System Admin</p>
            </div>

            <a href="{{ route('super-admin.users.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('super-admin.users.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-people text-lg w-6"></i>
                <span>User Management</span>
            </a>

            <a href="{{ route('super-admin.system-logs.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('super-admin.system-logs.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-journal-text text-lg w-6"></i>
                <span>System Logs</span>
            </a>

            <a href="{{ route('super-admin.announcements.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('super-admin.announcements.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-megaphone text-lg w-6"></i>
                <span>Announcements</span>
            </a>
        @endif

        {{-- =========================
            ADMIN MENU
           ========================= --}}
        @if($isAdmin)
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Operations</p>
            </div>

            <a href="{{ route('admin.users.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('admin.users.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-people text-lg w-6"></i>
                <span>Staff Accounts</span>
            </a>

            <a href="{{ route('admin.system-logs.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('admin.system-logs.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-journal-text text-lg w-6"></i>
                <span>System Logs</span>
            </a>

            <a href="{{ route('admin.announcements.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('admin.announcements.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-megaphone text-lg w-6"></i>
                <span>Announcements</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Reports</p>
            </div>

            <a href="{{ route('admin.bite-reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('admin.bite-reports.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-exclamation-triangle text-lg w-6"></i>
                <span>Animal Bite Reports</span>
            </a>

            <a href="{{ route('admin.vaccination-reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('admin.vaccination-reports.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-shield-check text-lg w-6"></i>
                <span>Anti-Rabies Vaccination</span>
            </a>

            <a href="{{ route('admin.meat-inspection-reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('admin.meat-inspection-reports.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-clipboard-check text-lg w-6"></i>
                <span>Meat Inspection</span>
            </a>

            <a href="{{ route('admin.all-reports') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('admin.all-reports') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-file-earmark-bar-graph text-lg w-6"></i>
                <span>All Reports</span>
            </a>

        {{-- =========================
            CITY VET MENU (Admin/Operations)
           ========================= --}}
        @elseif($role === 'city_vet')
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Dashboard</p>
            </div>

            <a href="{{ route('city-vet.dashboard') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('city-vet.dashboard') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-speedometer2 text-lg w-6"></i>
                <span>Dashboard</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Analytics & Reports</p>
            </div>

            <a href="{{ route('city-vet.rabies-geomap') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('city-vet.rabies-geomap') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-map text-lg w-6"></i>
                <span>Rabies Geomap</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Clinical</p>
            </div>

            <!-- <a href="{{ route('city-vet.rabies-cases.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('city-vet.rabies-cases.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-exclamation-triangle text-lg w-6"></i>
                <span>Rabies Cases</span>
            </a> -->

            <a href="{{ route('city-vet.rabies-bite-reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('city-vet.rabies-bite-reports.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-virus text-lg w-6"></i>
                <span>Bite & Rabies Reports</span>
            </a>

            <a href="{{ route('city-vet.vaccination-reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('city-vet.vaccination-reports.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-shield-check text-lg w-6"></i>
                <span>Anti-Rabies Vaccination</span>
            </a>

            <a href="{{ route('city-vet.impounds.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('city-vet.impounds.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-archive text-lg w-6"></i>
                <span>Impound Records</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Clinical</p>
            </div>

            @php
                // Get available reports route for current role
                $reportsRoute = null;
                if (Route::has('city-vet.rabies-bite-reports.index')) {
                    $reportsRoute = route('city-vet.rabies-bite-reports.index');
                }
            @endphp

            <a href="{{ route('rabies-cases.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('rabies-cases.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-exclamation-triangle text-lg w-6"></i>
                <span>Rabies Cases</span>
            </a>

            @if($reportsRoute)
            <a href="{{ $reportsRoute }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('city-vet.rabies-bite-reports.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-virus text-lg w-6"></i>
                <span>Bite & Rabies Reports</span>
            </a>
            @endif

            <a href="{{ route('assistant-vet.vaccinations.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('assistant-vet.vaccinations.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-shield-check text-lg w-6"></i>
                <span>Vaccinations</span>
            </a>

            <a href="{{ route('spay-neuter.reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('spay-neuter.reports.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-heart text-lg w-6"></i>
                <span>Spay/Neuter</span>
            </a>

        {{-- =========================
            ADMIN ASST (GATEKEEPER) MENU
           ========================= --}}
        @elseif($isAdminAsst)
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Gatekeeper</p>
            </div>

            <a href="{{ route('admin-asst.pet-registrations.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('admin-asst.pet-registrations.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-paw text-lg w-6"></i>
                <span>Pet Registrations</span>
            </a>

            <a href="{{ route('admin-asst.adoptions.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('admin-asst.adoptions.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-heart-fill text-lg w-6"></i>
                <span>Adoptions</span>
            </a>

            <a href="{{ route('admin-asst.missing-pets.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('admin-asst.missing-pets.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-search text-lg w-6"></i>
                <span>Missing Pets</span>
            </a>

        {{-- =========================
            LIVESTOCK INSPECTOR MENU
           ========================= --}}
        @elseif($isLivestockInspector)
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Livestock Management</p>
            </div>

            <a href="{{ route('livestock.dashboard') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('livestock.dashboard') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-speedometer2 text-lg w-6"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('livestock.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('livestock.index') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-paw text-lg w-6"></i>
                <span>Livestock Records</span>
            </a>

            <a href="{{ route('livestock.census') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('livestock.census') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-bar-chart text-lg w-6"></i>
                <span>Census Summary</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Business Profiling</p>
            </div>

            <a href="{{ route('establishments.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('establishments.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-shop text-lg w-6"></i>
                <span>Establishments</span>
            </a>

        {{-- =========================
            MEAT INSPECTOR MENU
           ========================= --}}
        @elseif($isMeatInspector)
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Meat Inspection</p>
            </div>

            <a href="{{ route('meat-inspection.meat-shop.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('meat-inspection.meat-shop.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-shop text-lg w-6"></i>
                <span>Shop Inspections</span>
            </a>

            <a href="{{ route('meat-inspection.establishments.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('meat-inspection.establishments.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-shop-window text-lg w-6"></i>
                <span>Register Shop</span>
            </a>

            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider">Establishments</p>
            </div>

            <a href="{{ route('establishments.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('establishments.*') ? 'bg-green-600' : '' }}">
                <i class="bi bi-shop text-lg w-6"></i>
                <span>Business Profiling</span>
            </a>

        {{-- =========================
            CITY POUND MENU
           ========================= --}}
        @elseif($isCityPound)
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">City Pound</p>
            </div>

            <a href="{{ route('city-pound.impounds.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('city-pound.impounds.*') ? 'bg-green-600' : '' }}">
                <i class="bi bi-archive text-lg w-6"></i>
                <span>Impound Records</span>
            </a>

            <a href="{{ route('city-pound.impounds.create') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('city-pound.impounds.create') ? 'bg-green-600' : '' }}">
                <i class="bi bi-plus-circle text-lg w-6"></i>
                <span>New Impound</span>
            </a>

            <a href="{{ route('city-pound.adoptions.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('city-pound.adoptions.*') ? 'bg-green-600' : '' }}">
                <i class="bi bi-hearts text-lg w-6"></i>
                <span>Adoption Requests</span>
            </a>

            <a href="{{ route('city-pound.stray-reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('city-pound.stray-reports.*') ? 'bg-green-600' : '' }}">
                <i class="bi bi-exclamation-triangle text-lg w-6"></i>
                <span>Stray Reports</span>
            </a>

        {{-- =========================
            CLINIC/VETERINARIAN MENU
           ========================= --}}
        @elseif($isClinic)
            <div class="pt-4 pb-2">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Clinic Operations</p>
            </div>

            <a href="{{ route('clinic.vaccination-reports.create') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-slate-300 hover:text-white transition {{ request()->routeIs('clinic.vaccination-reports.create') ? 'bg-green-600' : '' }}">
                <i class="bi bi-shield-plus text-lg w-6"></i>
                <span>New Vaccination</span>
            </a>

            <a href="{{ route('clinic.vaccination-reports.index') }}"
               class="nav-item flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition {{ request()->routeIs('clinic.vaccination-reports.*') ? 'bg-green-600 text-white' : '' }}">
                <i class="bi bi-shield-check text-lg w-6"></i>
                <span>Vaccination Records</span>
            </a>

        @else
            {{-- Other roles get basic menu - dashboard and logout only --}}
        @endif

        <!-- Logout (ALWAYS SHOW) -->
        <div class="pt-4 mt-4 border-t border-green-700">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                        class="nav-item w-full flex items-center gap-3 px-4 py-3 rounded-lg text-green-100 hover:bg-green-700 hover:text-white transition">
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
