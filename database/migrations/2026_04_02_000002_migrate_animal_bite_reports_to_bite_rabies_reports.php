<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bite_rabies_reports', function (Blueprint $table) {
            $table->enum('report_source', ['client_submission', 'staff_entry', 'migrated'])->default('client_submission')->after('report_number');
            $table->unsignedBigInteger('user_id')->nullable()->after('barangay_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        $biteReports = DB::table('animal_bite_reports')->get();

        foreach ($biteReports as $index => $old) {
            $reportNumber = 'MIG-' . date('Y', strtotime($old->created_at ?? now())) . '-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT);

            $status = match ($old->status) {
                'pending' => 'Pending Review',
                'investigating' => 'Under Review',
                'in_progress' => 'Under Review',
                'resolved' => 'Resolved',
                'closed' => 'Closed',
                default => 'Pending Review',
            };

            $patientGender = ucfirst($old->victim_gender ?? 'male');

            $animalSpecies = ucfirst($old->animal_type ?? 'Dog');

            $animalStatus = match (strtolower($old->animal_status ?? '')) {
                'rabid' => 'Stray',
                'vaccinated' => 'Owned',
                default => 'Unknown',
            };

            $animalVaccinationStatus = match (strtolower($old->animal_vaccination_status ?? '')) {
                'vaccinated' => 'Vaccinated',
                'unvaccinated' => 'Unvaccinated',
                default => 'Unknown',
            };

            $notesParts = [];
            if ($old->remarks) {
                $notesParts[] = $old->remarks;
            }
            if ($old->action_taken) {
                $notesParts[] = 'Action: ' . $old->action_taken;
            }
            if ($old->notes) {
                $notesParts[] = 'Original notes: ' . $old->notes;
            }
            if ($old->referral_hospital) {
                $notesParts[] = 'Referral: ' . $old->referral_hospital;
            }
            if ($old->victim_address) {
                $notesParts[] = 'Address: ' . $old->victim_address;
            }
            $notes = !empty($notesParts) ? implode("\n", $notesParts) : null;

            DB::table('bite_rabies_reports')->insert([
                'report_number' => $reportNumber,
                'report_source' => 'migrated',
                'status' => $status,
                'assigned_to_role' => 'assistant_vet',
                'reporting_facility' => 'Others',
                'facility_name' => 'Migrated Record',
                'date_reported' => $old->bite_date ?? $old->created_at ?? now(),
                'patient_name' => $old->victim_name ?? 'Unknown',
                'patient_age' => $old->victim_age ?? 0,
                'patient_gender' => $patientGender,
                'patient_barangay_id' => $old->barangay_id,
                'patient_contact' => $old->reporter_contact ?? 'N/A',
                'incident_date' => $old->bite_date ?? $old->created_at ?? now(),
                'nature_of_incident' => 'Bitten',
                'bite_site' => $old->bite_location ?? 'Unknown',
                'exposure_category' => match (strtolower($old->bite_severity ?? '')) {
                    'category i' => 'Category I (Lick)',
                    'category ii' => 'Category II (Scratch)',
                    'category iii' => 'Category III (Bite / Deep)',
                    default => 'Category II (Scratch)',
                },
                'animal_species' => $animalSpecies,
                'animal_status' => $animalStatus,
                'animal_owner_name' => $old->animal_owner_name ?? $old->owner_name,
                'animal_vaccination_status' => $animalVaccinationStatus,
                'animal_current_condition' => 'Healthy / Alive',
                'wound_management' => null,
                'post_exposure_prophylaxis' => 'No',
                'notes' => $notes,
                'barangay_id' => $old->barangay_id,
                'user_id' => $old->user_id,
                'created_at' => $old->created_at ?? now(),
                'updated_at' => $old->updated_at ?? now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('bite_rabies_reports')->where('report_source', 'migrated')->delete();

        Schema::table('bite_rabies_reports', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['report_source', 'user_id']);
        });
    }
};
