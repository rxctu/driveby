<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryMovement extends Model
{
    protected $fillable = [
        'product_id',
        'barcode_mapping_id',
        'type',
        'unit_type',
        'unit_count',
        'quantity_per_unit',
        'total_quantity',
        'barcode',
        'note',
        'dlc',
        'dluo',
        'lot_number',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'dlc' => 'date',
            'dluo' => 'date',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function barcodeMapping(): BelongsTo
    {
        return $this->belongsTo(BarcodeMapping::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
