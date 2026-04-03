<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Barangay;

class MeatEstablishment extends Model
{
    use HasFactory;

    protected $table = 'meat_establishments';
    protected $primaryKey = 'establishment_id';

    protected $fillable = [
        'establishment_name',
        'establishment_type',
        'owner_name',
        'contact_person',
        'contact_number',
        'email',
        'barangay_id',
        'address_text',
        'landmark',
        'permit_no',
        'registered_by_user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by_user_id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }
}
