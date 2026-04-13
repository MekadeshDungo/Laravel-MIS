<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'inventory_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'item_name',
        'item_code',
        'category',
        'description',
        'unit',
        'quantity',
        'min_stock_level',
        'expiry_date',
        'supplier',
        'cost_per_unit',
        'location',
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
            'expiry_date' => 'date',
            'cost_per_unit' => 'decimal:2',
            'quantity' => 'integer',
            'min_stock_level' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user who created this inventory item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all stock movements for this item.
     */
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Scope for filtering by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for low stock items.
     */
    public function scopeLowStock($query)
    {
        return $query->where('quantity', '<=', 'min_stock_level');
    }

    /**
     * Scope for expiring items.
     */
    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('expiry_date', '<=', now()->addDays($days))
                     ->where('expiry_date', '>=', now());
    }

    /**
     * Scope for expried items.
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    /**
     * Check if item is low stock.
     */
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_stock_level;
    }

    /**
     * Check if item is expired.
     */
    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if item is expiring soon.
     */
    public function isExpiringSoon($days = 30): bool
    {
        return $this->expiry_date && 
               $this->expiry_date->isFuture() && 
               $this->expiry_date->diffInDays(now()) <= $days;
    }

    /**
     * Get stock status badge.
     */
    public function getStockStatusAttribute()
    {
        if ($this->isExpired()) {
            return 'danger';
        }
        if ($this->isExpiringSoon()) {
            return 'warning';
        }
        if ($this->isLowStock()) {
            return 'warning';
        }
        return 'success';
    }
}
