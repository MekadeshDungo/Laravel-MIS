<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class BiteRabiesReport extends Model
{
    protected $table = 'bite_rabies_reports';

    protected $fillable = [
        'report_number',
        'status',
        'report_source',
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
        'exposure_category',
        'animal_species',
        'animal_current_condition',
        'animal_vaccination_status',
        // Standard fields
        'patient_first_name',
        'patient_middle_name',
        'patient_suffix',
        'age',
        'gender',
        'patient_address',
        'patient_barangay',
        'barangay_id',
        'incident_barangay',
        'exact_location',
        'exposure_type',
        'bite_site',
        'category',
        'animal_type',
        'animal_status',
        'vaccination_status',
        'animal_owner_name',
        'animal_owner_contact',
        'reported_by',
        'wound_management',
        'post_exposure_prophylaxis',
        'notes',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'wound_management' => 'array',
    ];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function patientBarangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'patient_barangay', 'barangay_name', 'barangay_name');
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by', 'id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'reference_id')
            ->where('module', 'bite_rabies_report');
    }

    public function scopeByBarangay(Builder $query, int $barangayId): Builder
    {
        return $query->where('barangay_id', $barangayId);
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeByAnimalType(Builder $query, string $type): Builder
    {
        return $query->where('animal_type', $type);
    }

    public function scopeByDateRange(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('incident_date', [$from, $to]);
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
}