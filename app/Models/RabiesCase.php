<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RabiesCase extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rabies_cases';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'pet_id',
        'barangay_id',
        'report_date',
        'classification',
        'action_taken',
        'case_status',
        'encoded_by_user_id',
        'remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'report_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the pet.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Get the barangay.
     */
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    /**
     * Get the user who encoded this case.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'encoded_by_user_id');
    }

    /**
     * Get classification badge.
     */
    public function getClassificationBadgeAttribute()
    {
        $badges = [
            'suspected' => 'warning',
            'confirmed' => 'danger',
        ];

        return $badges[$this->classification] ?? 'secondary';
    }

    /**
     * Get status badge.
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'new' => 'danger',
            'ongoing' => 'warning',
            'closed' => 'success',
        ];

        return $badges[$this->case_status] ?? 'secondary';
    }
}
