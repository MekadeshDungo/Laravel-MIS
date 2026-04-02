<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Livestock extends Model
{
    use HasFactory;

    protected $table = 'livestock';
    protected $primaryKey = 'livestock_id';

    protected $fillable = [
        'owner_id',
        'barangay_id',
        'species',
        'breed',
        'color',
        'gender',
        'age',
        'age_unit',
        'tag_number',
        'owner_name',
        'owner_contact',
        'address',
        'status',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'age' => 'integer',
    ];

    /**
     * Get the barangay that owns the livestock.
     */
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    /**
     * Get the user who recorded this livestock.
     */
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Scope to filter by barangay.
     */
    public function scopeByBarangay($query, $barangayId)
    {
        return $query->where('barangay_id', $barangayId);
    }

    /**
     * Scope to filter by species.
     */
    public function scopeBySpecies($query, $species)
    {
        return $query->where('species', $species);
    }

    /**
     * Get total count per species.
     */
    public static function getTotalCountBySpecies()
    {
        return self::selectRaw('species, COUNT(*) as total_count')
            ->groupBy('species')
            ->get();
    }

    /**
     * Get total count per barangay.
     */
    public static function getTotalCountByBarangay()
    {
        return self::selectRaw('barangay_id, COUNT(*) as total_count')
            ->groupBy('barangay_id')
            ->with('barangay')
            ->get();
    }
}
