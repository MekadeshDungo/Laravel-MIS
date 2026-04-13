<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeatInspectionReport extends Model
{
    use HasFactory;
    protected $table = 'meat_inspections';

    protected $fillable = [
        'inspector_user_id',
        'establishment_name',
        'establishment_type',
        'establishment_address',
        'owner_name',
        'owner_contact',
        'inspection_date',
        'inspection_time',
        'inspector_name',
        'inspection_type',
        'overall_rating',
        'findings',
        'observations',
        'recommendations',
        'compliance_status',
        'penalty_imposed',
        'next_inspection_date',
        'attachments',
        'notes',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'inspection_time' => 'time',
        'next_inspection_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'inspector_user_id');
    }

    public function scopeCompliant($query)
    {
        return $query->where('compliance_status', 'compliant');
    }

    public function scopeNonCompliant($query)
    {
        return $query->where('compliance_status', 'non_compliant');
    }
}
