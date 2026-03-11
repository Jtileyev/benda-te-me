<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'locale',
        'value',
        'updated_by',
    ];

    public static function content(string $key, string $locale, string $fallback): string
    {
        $row = static::query()
            ->where('key', $key)
            ->where('locale', $locale)
            ->first();

        return $row?->value ?? $fallback;
    }
}
