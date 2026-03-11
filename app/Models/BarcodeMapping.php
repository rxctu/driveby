<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarcodeMapping extends Model
{
    protected $fillable = [
        'barcode',
        'product_id',
        'unit_type',
        'quantity_per_unit',
        'supplier_ref',
        'label',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public static function unitTypeLabels(): array
    {
        return [
            'unite' => 'Unite',
            'pack' => 'Pack',
            'carton' => 'Carton',
            'palette' => 'Palette',
        ];
    }
}
