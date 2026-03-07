<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'customer_name',
        'customer_phone',
        'customer_address',
        'delivery_instructions',
        'delivery_fee',
        'subtotal',
        'total',
        'delivery_slot',
        'delivery_date',
        'payment_method',
        'payment_status',
        'stripe_payment_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'delivery_fee' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
            'delivery_date' => 'date',
            // RGPD: Encrypt PII at rest
            'customer_name' => 'encrypted',
            'customer_phone' => 'encrypted',
            'customer_address' => 'encrypted',
            'delivery_instructions' => 'encrypted',
        ];
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'EPI-'.strtoupper(uniqid());
        } while (static::where('order_number', $number)->exists());

        return $number;
    }
}
