<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverySlot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'is_active',
        'max_orders',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'day_of_week' => 'integer',
            'is_active' => 'boolean',
            'max_orders' => 'integer',
            'start_time' => 'string',
            'end_time' => 'string',
        ];
    }

    /**
     * Scope a query to only include active delivery slots.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by day of week.
     */
    public function scopeForDay(Builder $query, int $dayOfWeek): Builder
    {
        return $query->where('day_of_week', $dayOfWeek);
    }

    /**
     * Get the day name for display.
     */
    public function getDayNameAttribute(): string
    {
        $days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        return $days[$this->day_of_week] ?? '';
    }

    /**
     * Get the formatted time slot label.
     */
    public function getLabelAttribute(): string
    {
        return $this->day_name.' '.substr($this->start_time, 0, 5).' - '.substr($this->end_time, 0, 5);
    }
}
