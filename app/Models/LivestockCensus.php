<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LivestockCensus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'livestock_censuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'barangay_id',
        'species',
        'no_of_heads',
        'no_of_farmers',
        'report_year',
        'report_month',
        'encoded_by_user_id',
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
     * Get the user who encoded this census.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'encoded_by_user_id');
    }

    /**
     * Get species badge.
     */
    public function getSpeciesBadgeAttribute()
    {
        $badges = [
            'cattle' => 'primary',
            'carabao' => 'info',
            'swine' => 'warning',
            'horse' => 'success',
            'goat' => 'secondary',
            'dog' => 'danger',
            'pigeon' => 'dark',
        ];

        return $badges[$this->species] ?? 'secondary';
    }

    /**
     * Get formatted species name.
     */
    public function getSpeciesNameAttribute()
    {
        return ucfirst($this->species);
    }
}
