<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pet;
use App\Models\User;
use App\Models\PetOwner;
use App\Models\RabiesVaccinationReport;
use App\Models\BiteRabiesReport;
use App\Models\Vaccination;

/**
 * RecordsController - Records Management Module
 *
 * THESIS ROLE MAPPING:
 * - Primary Role: admin_staff (Administrative Assistant IV / Book Binder 4)
 * - Also accessible by: super_admin, city_vet
 *
 * MODULE ASSIGNMENTS:
 * - Pet Registration Records
 * - Owner Records (via Client model)
 * - Vaccination Encoding
 * - Records Search
 *
 * Note: Pet owners are stored in 'clients' table, not 'users' table.
 * Users table is for staff accounts only.
 */
class RecordsController extends Controller
{
    /**
     * Show records staff dashboard.
     *
     * Module: Dashboard
     * Role: admin_staff
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get statistics (using Client for owners, Pet for pets)
        $stats = [
            'total_pets' => Pet::count(),
            'total_owners' => PetOwner::count(),
            'total_vaccinations' => Vaccination::count(),
            'vaccinated_animals' => Pet::where('vaccination_status', 'vaccinated')->count(),
            'unvaccinated_animals' => Pet::where('vaccination_status', 'unvaccinated')->count(),
            'bite_reports' => BiteRabiesReport::count(),
            'pending_bite_reports' => BiteRabiesReport::where('status', 'Pending Review')->count(),
        ];

        // Get recent registrations with eager loading
        $recentPets = Pet::with(['owner', 'barangay'])->latest()->take(5)->get();

        // Get recent vaccinations with eager loading
        $recentVaccinations = Vaccination::with(['pet', 'user'])->latest()->take(5)->get();

        return view('dashboard.admin-staff', compact('user', 'stats', 'recentPets', 'recentVaccinations'));
    }

    /**
     * Display pet registration list.
     */
    public function pets(Request $request)
    {
        $search = $request->get('search', '');
        $species = $request->get('species', '');
        $vaccinationStatus = $request->get('vaccination_status', '');

        $pets = Pet::with(['owner', 'barangay'])
            ->when($search, function ($query) use ($search) {
                $query->where('pet_name', 'like', "%{$search}%")
                      ->orWhere('license_number', 'like', "%{$search}%")
                      ->orWhereHas('owner', function ($q) use ($search) {
                          $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                      });
            })
            ->when($species, function ($query) use ($species) {
                $query->where('species', $species);
            })
            ->when($vaccinationStatus, function ($query) use ($vaccinationStatus) {
                $query->where('vaccination_status', $vaccinationStatus);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('records-staff.pets.index', compact('pets', 'search', 'species', 'vaccinationStatus'));
    }

    /**
     * Show pet registration form.
     *
     * Module: Pet Registration
     * Role: admin_staff
     */
    public function createPet()
    {
        // Use PetOwner model for owners (pet owners)
        $owners = PetOwner::orderBy('last_name')->get();
        return view('records-staff.pets.create', compact('owners'));
    }

    /**
     * Store new pet registration.
     */
    public function storePet(Request $request)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|in:dog,cat,other',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|string|in:male,female,unknown',
            'color' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'owner_id' => 'nullable|exists:pet_owners,owner_id',
            'owner_name' => 'nullable|string|max:255',
            'owner_contact' => 'nullable|string|max:20',
            'license_number' => 'nullable|string|unique:pets',
            'microchip_number' => 'nullable|string',
            'health_status' => 'nullable|string',
            'vaccination_status' => 'nullable|string|in:vaccinated,unvaccinated,pending',
            'notes' => 'nullable|string',
        ]);

        // Handle owner - either select existing or create new
        $ownerId = null;
        if (!empty($request->owner_id)) {
            $ownerId = $request->owner_id;
        } elseif (!empty($request->owner_name)) {
            // Create a new pet owner
            $owner = PetOwner::create([
                'first_name' => $request->owner_name,
                'phone_number' => $request->owner_contact ?? 'N/A',
            ]);
            $ownerId = $owner->owner_id;
        }

        Pet::create([
            'owner_id' => $ownerId,
            'pet_name' => $validated['name'],
            'animal_type' => $validated['species'], // Map species to animal_type
            'species' => $validated['species'],
            'breed' => $validated['breed'] ?? null,
            'age' => $validated['age'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'color' => $validated['color'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'license_number' => $validated['license_number'] ?? null,
            'microchip_number' => $validated['microchip_number'] ?? null,
            'health_status' => $validated['health_status'] ?? null,
            'vaccination_status' => $validated['vaccination_status'] ?? 'unvaccinated',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('records-staff.pets.index')->with('success', 'Pet registered successfully.');
    }

    /**
     * Display pet details.
     */
    public function showAnimal(Pet $pet)
    {
        $pet->load('owner', 'vaccinations');
        return view('records-staff.pets.show', compact('pet'));
    }

    /**
     * Show pet edit form.
     */
    public function editAnimal(Pet $pet)
    {
        $owners = User::where('role', 'citizen')->orderBy('name')->get();
        return view('records-staff.pets.edit', compact('pet', 'owners'));
    }

    /**
     * Update pet record.
     */
    public function updateAnimal(Request $request, Pet $pet)
    {
        $validated = $request->validate([
            'pet_name' => 'required|string|max:255',
            'species' => 'required|string|in:dog,cat,other',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|string|in:male,female,unknown',
            'color' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'owner_id' => 'nullable|exists:pet_owners,owner_id',
            'license_number' => 'nullable|string|unique:pets,license_number,' . $pet->pet_id,
            'microchip_number' => 'nullable|string',
            'health_status' => 'nullable|string',
            'vaccination_status' => 'nullable|string|in:vaccinated,unvaccinated,pending',
            'vaccination_date' => 'nullable|date',
            'next_vaccination_date' => 'nullable|date|after:vaccination_date',
            'notes' => 'nullable|string',
        ]);

        $pet->update($validated);

        return redirect()->route('records-staff.pets.show', $pet)->with('success', 'Pet record updated successfully.');
    }

    /**
     * Display owner records list.
     */
    public function owners(Request $request)
    {
        $search = $request->get('search', '');

        $owners = User::role('citizen')
            ->whereHas('petOwner', function ($query) use ($search) {
                $query->when($search, function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%");
                });
            })
            ->with('petOwner')
            ->withCount('pets')
            ->orderBy('first_name')
            ->paginate(15);

        return view('records-staff.owners.index', compact('owners', 'search'));
    }

    /**
     * Display owner details with their pets.
     */
    public function showOwner(User $owner)
    {
        $petOwner = $owner->petOwner;
        
        return view('records-staff.owners.show', compact('owner', 'petOwner'));
    }

    /**
     * Display vaccination encoding form.
     */
    public function createVaccination()
    {
        $pets = Pet::orderBy('pet_name')->get();
        return view('records-staff.vaccinations.create', compact('pets'));
    }

    /**
     * Store vaccination record.
     */
    public function storeVaccination(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_contact' => 'nullable|string|max:20',
            'patient_address' => 'nullable|string',
            'pet_name' => 'required|string|max:255',
            'pet_species' => 'required|string|in:dog,cat,other',
            'pet_breed' => 'nullable|string|max:255',
            'pet_age' => 'nullable|integer',
            'pet_gender' => 'nullable|string|in:male,female,unknown',
            'pet_color' => 'nullable|string|max:255',
            'vaccine_brand' => 'required|string|max:255',
            'vaccine_batch_number' => 'nullable|string|max:255',
            'vaccination_date' => 'required|date',
            'vaccination_time' => 'nullable',
            'next_vaccination_date' => 'nullable|date|after:vaccination_date',
            'weight' => 'nullable|numeric',
            'vaccination_type' => 'nullable|string',
            'observations' => 'nullable|string',
            'status' => 'nullable|string|in:completed,pending',
            'notes' => 'nullable|string',
        ]);

        RabiesVaccinationReport::create([
            'user_id' => Auth::id(),
            'clinic_name' => 'VSO Records',
            'patient_name' => $validated['patient_name'],
            'patient_contact' => $validated['patient_contact'] ?? null,
            'patient_address' => $validated['patient_address'] ?? null,
            'pet_name' => $validated['pet_name'],
            'pet_species' => $validated['pet_species'],
            'pet_breed' => $validated['pet_breed'] ?? null,
            'pet_age' => $validated['pet_age'] ?? null,
            'pet_gender' => $validated['pet_gender'] ?? null,
            'pet_color' => $validated['pet_color'] ?? null,
            'vaccine_brand' => $validated['vaccine_brand'],
            'vaccine_batch_number' => $validated['vaccine_batch_number'] ?? null,
            'vaccination_date' => $validated['vaccination_date'],
            'vaccination_time' => $validated['vaccination_time'] ?? null,
            'next_vaccination_date' => $validated['next_vaccination_date'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'vaccination_type' => $validated['vaccination_type'] ?? null,
            'observations' => $validated['observations'] ?? null,
            'status' => $validated['status'] ?? 'completed',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('admin-staff.dashboard')->with('success', 'Vaccination record encoded successfully.');
    }

    /**
     * Display vaccination records list.
     */
    public function vaccinations(Request $request)
    {
        $search = $request->get('search', '');
        $status = $request->get('status', '');
        $month = $request->get('month', '');

        $vaccinations = RabiesVaccinationReport::with('user')
            ->when($search, function ($query) use ($search) {
                $query->where('patient_name', 'like', "%{$search}%")
                      ->orWhere('pet_name', 'like', "%{$search}%")
                      ->orWhere('vaccine_brand', 'like', "%{$search}%");
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('vaccination_date', $month);
            })
            ->orderBy('vaccination_date', 'desc')
            ->paginate(15);

        return view('records-staff.vaccinations.index', compact('vaccinations', 'search', 'status', 'month'));
    }

    /**
     * Display vaccination record details.
     */
    public function showVaccination(RabiesVaccinationReport $report)
    {
        return view('records-staff.vaccinations.show', compact('report'));
    }

    /**
     * Global records search.
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');

        if (empty($search)) {
            return redirect()->route('admin-staff.dashboard');
        }

        // Search pets
        $pets = Pet::where('name', 'like', "%{$search}%")
            ->orWhere('license_number', 'like', "%{$search}%")
            ->orWhere('microchip_number', 'like', "%{$search}%")
            ->with('owner')
            ->take(10)
            ->get();

        // Search owners
        $owners = User::where('role', 'citizen')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('contact_number', 'like', "%{$search}%");
            })
            ->withCount('pets')
            ->take(10)
            ->get();

        // Search vaccinations
        $vaccinations = RabiesVaccinationReport::where('patient_name', 'like', "%{$search}%")
            ->orWhere('pet_name', 'like', "%{$search}%")
            ->take(10)
            ->get();

        return view('records-staff.search', compact('search', 'pets', 'owners', 'vaccinations'));
    }
}
