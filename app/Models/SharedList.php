<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SharedList extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'tags',
        'is_public',
        'likes_count',
        'dislikes_count',
        'copies_count',
        'views_count',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'likes_count' => 'integer',
            'dislikes_count' => 'integer',
            'copies_count' => 'integer',
            'views_count' => 'integer',
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the user that owns the shared list.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the shared list.
     */
    public function items(): HasMany
    {
        return $this->hasMany(SharedListItem::class);
    }

    /**
     * Get the votes for the shared list.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(SharedListVote::class);
    }

    /**
     * Get the comments for the shared list.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(SharedListComment::class);
    }

    /**
     * Scope a query to only include public lists.
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query to order by popularity (likes_count descending).
     */
    public function scopePopular(Builder $query): Builder
    {
        return $query->orderByDesc('likes_count');
    }

    /**
     * Scope a query to order by most recent.
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    /**
     * Calculate the total price of all items in the list.
     */
    public function totalPrice(): float
    {
        return $this->items->sum(function (SharedListItem $item) {
            return $item->product ? $item->product->price * $item->quantity : 0;
        });
    }
}
