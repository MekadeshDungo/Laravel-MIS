<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiteRabiesReport extends Model
{
    use HasFactory;

    protected $table = 'bite_rabies_reports';

    protected $fillable = [
        'report_number',
        'report_source',
        'status',
        'assigned_to_role',
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
    ];

    protected $casts = [
        'patient_age' => 'integer',
        'date_reported' => 'date',
        'incident_date' => 'date',
        'wound_management' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function patientBarangay()
    {
        return $this->belongsTo(Barangay::class, 'patient_barangay_id', 'barangay_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rabiesCase()
    {
        return $this->hasOne(RabiesCase::class, 'rabies_report_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'related_record_id')
            ->where('related_module', 'bite_rabies_report');
    }

    public function getVaccinationStatusAttribute()
    {
        return $this->animal_vaccination_status;
    }

    public function getCurrentConditionAttribute()
    {
        return $this->animal_current_condition;
    }

    public static function generateReportNumber(): string
    {
        $year = date('Y');
        $lastReport = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastReport
            ? (int) substr($lastReport->report_number, -5) + 1
            : 1;

        return 'BR-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public static function notifyAssistantVets(string $reportNumber, int $reportId): void
    {
        $assistantVets = User::where('role', 'assistant_vet')->get();

        foreach ($assistantVets as $vet) {
            Notification::create([
                'user_id' => $vet->id,
                'title' => 'New Bite & Rabies Report',
                'message' => "Report {$reportNumber} has been submitted and needs your review.",
                'related_module' => 'bite_rabies_report',
                'related_record_id' => $reportId,
                'is_read' => false,
            ]);
        }
    }
}
