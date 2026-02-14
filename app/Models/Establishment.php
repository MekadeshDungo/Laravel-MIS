<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'establishments';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'barangay_id',
        'name',
        'type',
        'permit_no',
        'address',
        'contact_number',
        'owner_name',
        'status',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the barangay.
     */
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    /**
     * Get the user who created this establishment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get inspections for this establishment.
     */
    public function inspections()
    {
        return $this->hasMany(MeatInspectionReport::class, 'establishment_id');
    }

    /**
     * Get establishment type badge.
     */
    public function getTypeBadgeAttribute()
    {
        $badges = [
            'meat_shop' => 'danger',
            'poultry' => 'warning',
            'pet_shop' => 'info',
            'vet_clinic' => 'primary',
            'livestock_facility' => 'success',
            'other' => 'secondary',
        ];

        return $badges[$this->type] ?? 'secondary';
    }

    /**
     * Get formatted type name.
     */
    public function getTypeNameAttribute()
    {
        $names = [
            'meat_shop' => 'Meat Shop',
            'poultry' => 'Poultry',
            'pet_shop' => 'Pet Shop',
            'vet_clinic' => 'Veterinary Clinic',
            'livestock_facility' => 'Livestock Facility',
            'other' => 'Other',
        ];

        return $names[$this->type] ?? ucfirst($this->type);
    }
}
