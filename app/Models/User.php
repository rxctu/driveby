<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'google_id',
    ];

    protected $guarded = [
        'is_admin',
        'trust_level',
        'is_verified',
        'admin_notes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            // RGPD: Encrypt PII at rest
            'phone' => 'encrypted',
            'address' => 'encrypted',
            'trust_level' => 'integer',
            'is_verified' => 'boolean',
        ];
    }

    /**
     * Get the orders for the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the shared lists for the user.
     */
    public function sharedLists(): HasMany
    {
        return $this->hasMany(SharedList::class);
    }

    /**
     * Get trust level label.
     */
    public function trustBadge(): string
    {
        return match ($this->trust_level) {
            0 => 'Nouveau',
            1 => 'A surveiller',
            2 => 'Normal',
            3 => 'Fiable',
            4 => 'Tres fiable',
            5 => 'VIP',
            default => 'Inconnu',
        };
    }

    /**
     * Get trust level color class.
     */
    public function trustColor(): string
    {
        return match ($this->trust_level) {
            0 => 'bg-gray-100 text-gray-700',
            1 => 'bg-red-100 text-red-700',
            2 => 'bg-yellow-100 text-yellow-700',
            3 => 'bg-blue-100 text-blue-700',
            4 => 'bg-emerald-100 text-emerald-700',
            5 => 'bg-purple-100 text-purple-700',
            default => 'bg-gray-100 text-gray-600',
        };
    }

    /**
     * Check if this is a new customer (no completed orders).
     */
    public function isNewCustomer(): bool
    {
        return $this->trust_level === 0 && ! $this->is_verified;
    }
}
