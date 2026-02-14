<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stock_movements';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'inventory_item_id',
        'movement_type',
        'quantity',
        'previous_quantity',
        'new_quantity',
        'reference_number',
        'remarks',
        'user_id',
        'movement_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'previous_quantity' => 'integer',
            'new_quantity' => 'integer',
            'movement_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the inventory item.
     */
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    /**
     * Get the user who made this movement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for stock-in movements.
     */
    public function scopeStockIn($query)
    {
        return $query->where('movement_type', 'stock_in');
    }

    /**
     * Scope for stock-out movements.
     */
    public function scopeStockOut($query)
    {
        return $query->where('movement_type', 'stock_out');
    }

    /**
     * Scope for adjustment movements.
     */
    public function scopeAdjustment($query)
    {
        return $query->where('movement_type', 'adjustment');
    }

    /**
     * Scope for date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('movement_date', [$startDate, $endDate]);
    }

    /**
     * Get movement type badge color.
     */
    public function getTypeBadgeAttribute()
    {
        $colors = [
            'stock_in' => 'success',
            'stock_out' => 'danger',
            'adjustment' => 'warning',
            'return' => 'info',
        ];

        return $colors[$this->movement_type] ?? 'secondary';
    }

    /**
     * Get formatted movement type.
     */
    public function getFormattedTypeAttribute()
    {
        $types = [
            'stock_in' => 'Stock In',
            'stock_out' => 'Stock Out',
            'adjustment' => 'Adjustment',
            'return' => 'Return',
        ];

        return $types[$this->movement_type] ?? ucfirst($this->movement_type);
    }
}
