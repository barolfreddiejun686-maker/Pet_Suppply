<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    public const PET_TYPES = [
        'dog' => 'Dog',
        'cat' => 'Cat',
        'fish' => 'Fish',
        'bird' => 'Bird',
        'small_pet' => 'Small pet',
        'reptile' => 'Reptile',
        'all' => 'All pets',
    ];

    protected $fillable = [
        'category_id', 'brand_id', 'supplier_id',
        'name', 'sku', 'pet_type', 'description',
        'cost_price', 'price', 'stock', 'reorder_level', 'expiry_date',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'price' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock', '<=', 'reorder_level');
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->stock <= $this->reorder_level;
    }
}
