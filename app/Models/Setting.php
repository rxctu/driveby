<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    /** Alias for get(). */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        return static::get($key, $default);
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, string $value): static
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value],
        );
    }

    /** Alias for set(). */
    public static function setValue(string $key, mixed $value): static
    {
        return static::set($key, (string) $value);
    }
}
