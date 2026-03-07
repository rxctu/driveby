<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'logo',
        'address',
        'phone',
        'website',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeSorted(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public static array $types = [
        'kebab' => 'Kebab',
        'pizza' => 'Pizzeria',
        'boulangerie' => 'Boulangerie',
        'restaurant' => 'Restaurant',
        'boucherie' => 'Boucherie',
        'traiteur' => 'Traiteur',
        'autre' => 'Autre',
    ];

    public function getTypeLabelAttribute(): string
    {
        return self::$types[$this->type] ?? ucfirst($this->type);
    }
}
