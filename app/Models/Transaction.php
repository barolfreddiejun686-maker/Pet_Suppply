<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    public const TYPES = [
        'stock_in' => 'Stock in (restock)',
        'stock_out' => 'Stock out (sale)',
    ];

    protected $fillable = [
        'reference_no', 'type', 'supplier_id', 'customer_name',
        'notes', 'total', 'transacted_at',
    ];

    protected $casts = [
        'transacted_at' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
