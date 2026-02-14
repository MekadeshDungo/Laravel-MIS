<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpayNeuterReport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'spay_neuter_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'pet_name',
        'pet_type',
        'breed',
        'age',
        'sex',
        'color_markings',
        'owner_name',
        'owner_contact',
        'owner_address',
        'procedure_type',
        'procedure_date',
        'veterinarian',
        'clinic_name',
        'weight',
        'status',
        'remarks',
        'report_date',
        'barangay',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'procedure_date' => 'date',
            'report_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user who created this report.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for filtering by procedure type.
     */
    public function scopeByProcedureType($query, $type)
    {
        return $query->where('procedure_type', $type);
    }

    /**
     * Scope for filtering by pet type.
     */
    public function scopeByPetType($query, $type)
    {
        return $query->where('pet_type', $type);
    }

    /**
     * Scope for filtering by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('procedure_date', [$startDate, $endDate]);
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'completed' => 'success',
            'scheduled' => 'info',
            'cancelled' => 'danger',
            'pending' => 'warning',
        ];

        return $colors[$this->status] ?? 'secondary';
    }
}
