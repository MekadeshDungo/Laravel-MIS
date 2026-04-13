<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeatShopInspection extends Model
{
    use HasFactory;

    protected $table = 'meat_shop_inspections';

    protected $fillable = [
        'meat_shop_id',
        'address',
        'inspection_date',
        'ticket_number',
        'licensing',
        'storage',
        'meat_quality',
        'sanitation',
        'lighting',
        'personal_hygiene',
        'equipment',
        'apprehension_status',
        'apprehended_by_user_id',
        'remarks',
    ];

    protected $casts = [
        'inspection_date' => 'date',
    ];

    public function meatShop(): BelongsTo
    {
        return $this->belongsTo(MeatEstablishment::class, 'meat_shop_id', 'establishment_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'apprehended_by_user_id');
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('inspection_date', $date);
    }

    public function scopeByShop($query, $shopId)
    {
        return $query->where('meat_shop_id', $shopId);
    }
}
