<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'category',
        'unit',
        'quantity',
        'minimum_stock',
        'unit_price',
        'description',
        'expiry_date',
        'barangay_id',
        'status',
        'created_by',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'quantity' => 'integer',
        'minimum_stock' => 'integer',
        'unit_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function isLowStock()
    {
        return $this->quantity <= $this->minimum_stock;
    }
}