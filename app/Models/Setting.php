<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    private const CACHE_KEY = 'settings.all';

    protected $fillable = ['key', 'value'];

    public $timestamps = true;

    /**
     * Settings loaded during the current request.
     *
     * @var array<string, string|null>|null
     */
    private static ?array $loaded = null;

    public static function get(string $key, $default = null)
    {
        static::$loaded ??= Cache::rememberForever(self::CACHE_KEY, function () {
            return static::query()->pluck('value', 'key')->all();
        });

        return static::$loaded[$key] ?? $default;
    }

    public static function put(string $key, $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        static::flushCache();
    }

    public static function flushCache(): void
    {
        static::$loaded = null;
        Cache::forget(self::CACHE_KEY);
    }
}
