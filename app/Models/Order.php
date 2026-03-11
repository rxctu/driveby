<?php

namespace App\Models;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

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
        'validation_code',
        'validated_at',
        'customer_name',
        'customer_phone',
        'customer_address',
        'delivery_instructions',
        'delivery_fee',
        'delivery_distance',
        'promo_code',
        'promo_discount',
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
            'validated_at' => 'datetime',
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

    /**
     * Generate a unique 8-character validation code for pickup.
     */
    public static function generateValidationCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (static::where('validation_code', $code)->exists());

        return $code;
    }

    /**
     * Get QR code as a base64 data URI for the validation code.
     */
    public function qrCodeDataUri(): ?string
    {
        if (! $this->validation_code) {
            return null;
        }

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'scale' => 8,
            'imageBase64' => true,
            'quietzoneSize' => 2,
        ]);

        return (new QRCode($options))->render($this->validation_code);
    }

    /**
     * Check if the order has been validated via QR/code.
     */
    public function isValidated(): bool
    {
        return $this->validated_at !== null;
    }
}
