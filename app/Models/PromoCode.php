<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order', 'max_discount',
        'max_uses', 'used_count', 'max_uses_per_user',
        'starts_at', 'expires_at', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order' => 'decimal:2',
            'max_discount' => 'decimal:2',
            'starts_at' => 'date',
            'expires_at' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function isValid(float $subtotal = 0): array
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Ce code promo n\'est plus actif.'];
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return ['valid' => false, 'message' => 'Ce code promo n\'est pas encore valide.'];
        }

        if ($this->expires_at && now()->gt($this->expires_at->endOfDay())) {
            return ['valid' => false, 'message' => 'Ce code promo a expire.'];
        }

        if ($this->max_uses !== null && $this->used_count >= $this->max_uses) {
            return ['valid' => false, 'message' => 'Ce code promo a atteint sa limite d\'utilisation.'];
        }

        if ($this->min_order && $subtotal < $this->min_order) {
            return [
                'valid' => false,
                'message' => 'Commande minimum de ' . number_format($this->min_order, 2, ',', ' ') . ' EUR requise.',
            ];
        }

        return ['valid' => true, 'message' => ''];
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === 'percentage') {
            $discount = $subtotal * ($this->value / 100);
            if ($this->max_discount) {
                $discount = min($discount, $this->max_discount);
            }
        } else {
            $discount = $this->value;
        }

        return min($discount, $subtotal);
    }

    public function getLabel(): string
    {
        if ($this->type === 'percentage') {
            return '-' . intval($this->value) . '%';
        }
        return '-' . number_format($this->value, 2, ',', ' ') . ' EUR';
    }
}
