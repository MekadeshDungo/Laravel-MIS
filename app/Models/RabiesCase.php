<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabiesCase extends Model
{
    use HasFactory;

    protected $table = 'bite_rabies_reports';

    protected $fillable = [
        'report_number',
        'patient_name',
        'age',
        'gender',
        'patient_address',
        'patient_contact',
        'barangay_id',
        'incident_date',
        'exposure_type',
        'bite_site',
        'category',
        'animal_type',
        'animal_status',
        'vaccination_status',
        'animal_owner_name',
        'animal_owner_contact',
        'reported_by',
        'user_id',
        'wound_management',
        'post_exposure_prophylaxis',
        'notes',
        'status',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rabiesReport()
    {
        return $this->belongsTo(BiteRabiesReport::class, 'report_number', 'report_number');
    }

    public static function generateCaseNumber(): string
    {
        $year = date('Y');
        $lastCase = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastCase
            ? (int) substr($lastCase->report_number, -5) + 1
            : 1;

        return 'RAB-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
