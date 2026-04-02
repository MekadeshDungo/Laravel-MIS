<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'client_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'suffix',
        'email',
        'phone_number',
        'house_no',
        'street',
        'subdivision',
        'barangay_id',
        'city',
        'province',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the full name of the client.
     */
    public function getFullNameAttribute(): string
    {
        $name = "{$this->first_name}";

        if ($this->middle_name) {
            $name .= " {$this->middle_name}";
        }

        $name .= " {$this->last_name}";

        if ($this->suffix) {
            $name .= " {$this->suffix}";
        }

        return $name;
    }

    /**
     * Get the pets owned by this client.
     */
    public function pets(): HasMany
    {
        return $this->hasMany(Animal::class, 'client_id', 'client_id');
    }

    /**
     * Get the animals owned by this client.
     */
    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class, 'client_id', 'client_id');
    }

    /**
     * Get the livestock owned by this client.
     */
    public function livestock(): HasMany
    {
        return $this->hasMany(Livestock::class, 'owner_id', 'client_id');
    }

    /**
     * Get the barangay where the client resides.
     */
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    /**
     * Scope a query to only include active clients.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
