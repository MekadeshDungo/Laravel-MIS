<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExposureCase extends Model
{
    use HasFactory;

    protected $table = 'exposure_cases';

    protected $fillable = [
        'case_number',
        'report_type',
        'status',
        'report_source',
        'reporting_facility',
        'facility_name',
        'date_reported',
        'patient_name',
        'patient_age',
        'patient_gender',
        'patient_barangay_id',
        'patient_contact',
        'incident_date',
        'nature_of_incident',
        'bite_site',
        'exposure_category',
        'animal_species',
        'animal_status',
        'animal_owner_name',
        'animal_vaccination_status',
        'animal_current_condition',
        'wound_management',
        'post_exposure_prophylaxis',
        'notes',
        'barangay_id',
        'user_id',
        'original_report_id',
    ];

    protected $casts = [
        'patient_age' => 'integer',
        'date_reported' => 'date',
        'incident_date' => 'date',
        'wound_management' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function patientBarangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'patient_barangay_id', 'barangay_id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function originalReport(): BelongsTo
    {
        return $this->belongsTo(BiteRabiesReport::class, 'original_report_id');
    }

    public static function generateCaseNumber(): string
    {
        $year = date('Y');
        $lastCase = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastCase
            ? (int) substr($lastCase->case_number, -5) + 1
            : 1;

        return 'EXP-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public static function migrateFromBiteRabiesReports(): int
    {
        $reports = BiteRabiesReport::whereNull('original_report_id')->get();
        $count = 0;

        foreach ($reports as $report) {
            $statusMap = [
                'Pending Review' => 'pending',
                'Under Review' => 'approved',
                'resolved' => 'closed',
            ];

            $case = self::create([
                'case_number' => $report->report_number,
                'report_type' => 'bite',
                'status' => $statusMap[$report->status] ?? 'pending',
                'report_source' => $report->report_source,
                'reporting_facility' => $report->reporting_facility,
                'facility_name' => $report->facility_name,
                'date_reported' => $report->date_reported,
                'patient_name' => $report->patient_name,
                'patient_age' => $report->patient_age,
                'patient_gender' => $report->patient_gender,
                'patient_barangay_id' => $report->patient_barangay_id,
                'patient_contact' => $report->patient_contact,
                'incident_date' => $report->incident_date,
                'nature_of_incident' => $report->nature_of_incident,
                'bite_site' => $report->bite_site,
                'exposure_category' => $report->exposure_category,
                'animal_species' => $report->animal_species,
                'animal_status' => $report->animal_status,
                'animal_owner_name' => $report->animal_owner_name,
                'animal_vaccination_status' => $report->animal_vaccination_status,
                'animal_current_condition' => $report->animal_current_condition,
                'wound_management' => $report->wound_management,
                'post_exposure_prophylaxis' => $report->post_exposure_prophylaxis,
                'notes' => $report->notes,
                'barangay_id' => $report->barangay_id,
                'user_id' => $report->user_id,
                'original_report_id' => $report->id,
            ]);

            $report->update(['original_report_id' => $case->id]);
            $count++;
        }

        return $count;
    }

    public function getMarkerColor(): string
    {
        return match ($this->report_type) {
            'bite' => '#eab308',
            'suspected_rabies' => '#f97316',
            'confirmed_rabies' => '#dc2626',
            default => '#22c55e',
        };
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'approved' => 'Approved',
            'closed' => 'Closed',
            default => 'Unknown',
        };
    }

    public function getReportTypeLabel(): string
    {
        return match ($this->report_type) {
            'bite' => 'Bite',
            'suspected_rabies' => 'Suspected Rabies',
            'confirmed_rabies' => 'Confirmed Rabies',
            default => 'Unknown',
        };
    }
}