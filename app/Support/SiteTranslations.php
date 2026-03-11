<?php

namespace App\Support;

use Illuminate\Support\Arr;

class SiteTranslations
{
    public const LOCALES = ['en', 'ru'];

    public static function load(string $locale): array
    {
        if (!in_array($locale, self::LOCALES, true)) {
            return [];
        }

        $path = resource_path("lang/{$locale}/site.php");
        if (!is_file($path)) {
            return [];
        }

        $data = include $path;
        return is_array($data) ? $data : [];
    }

    public static function save(string $locale, array $translations): void
    {
        if (!in_array($locale, self::LOCALES, true)) {
            return;
        }

        ksort($translations);
        $normalized = [];
        foreach ($translations as $key => $value) {
            if (!is_string($key)) {
                continue;
            }
            $normalized[$key] = (string) $value;
        }

        $content = self::buildPhpArrayFile($normalized);
        file_put_contents(resource_path("lang/{$locale}/site.php"), $content);
    }

    public static function allRows(): array
    {
        $en = self::load('en');
        $ru = self::load('ru');

        $keys = array_values(array_unique(array_merge(array_keys($en), array_keys($ru))));
        sort($keys);

        $rows = [];
        foreach ($keys as $key) {
            $rows[] = [
                'key' => $key,
                'en' => Arr::get($en, $key, ''),
                'ru' => Arr::get($ru, $key, ''),
            ];
        }

        return $rows;
    }

    private static function buildPhpArrayFile(array $translations): string
    {
        $lines = ["<?php", "", "return ["];
        foreach ($translations as $key => $value) {
            $exportedKey = var_export($key, true);
            $exportedValue = var_export($value, true);
            $lines[] = "    {$exportedKey} => {$exportedValue},";
        }
        $lines[] = "];";
        $lines[] = "";

        return implode("\n", $lines);
    }
}
