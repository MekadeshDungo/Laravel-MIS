<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RabiesCase extends Model
{
    use HasFactory;

    protected $table = 'rabies_cases';

    protected $fillable = [
        'case_number',
        'case_type',
        'species',
        'animal_name',
        'owner_id',
        'owner_name',
        'owner_contact',
        'address',
        'barangay_id',
        'user_id',
        'rabies_report_id',
        'incident_date',
        'incident_location',
        'status',
        'date_submitted',
        'findings',
        'actions_taken',
        'remarks',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'date_submitted' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function rabiesReport()
    {
        return $this->belongsTo(BiteRabiesReport::class, 'rabies_report_id');
    }
}
