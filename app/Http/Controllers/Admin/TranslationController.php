<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\SiteTranslations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TranslationController extends Controller
{
    public function index(): View
    {
        $locales = collect(config('app.available_locales', []))
            ->only(SiteTranslations::LOCALES)
            ->all();

        return view('admin.translations', [
            'rows' => SiteTranslations::allRows(),
            'locales' => $locales,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $rules = [
            'translations' => ['required', 'array'],
            'translations.*.key' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9._-]+$/i'],
            'new_key' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9._-]+$/i'],
        ];
        foreach (SiteTranslations::LOCALES as $locale) {
            $rules["translations.*.{$locale}"] = ['nullable', 'string', 'max:20000'];
            $rules["new_{$locale}"] = ['nullable', 'string', 'max:20000'];
        }
        $validated = $request->validate($rules);

        $valuesByLocale = [];
        foreach (SiteTranslations::LOCALES as $locale) {
            $valuesByLocale[$locale] = [];
        }

        foreach ($validated['translations'] as $row) {
            $key = $row['key'];
            foreach (SiteTranslations::LOCALES as $locale) {
                $valuesByLocale[$locale][$key] = (string) ($row[$locale] ?? '');
            }
        }

        $newKey = trim((string) ($validated['new_key'] ?? ''));
        if ($newKey !== '') {
            foreach (SiteTranslations::LOCALES as $locale) {
                $valuesByLocale[$locale][$newKey] = (string) ($validated["new_{$locale}"] ?? '');
            }
        }

        foreach (SiteTranslations::LOCALES as $locale) {
            SiteTranslations::save($locale, $valuesByLocale[$locale]);
        }

        return back()->with('success', __('site.translations_updated'));
    }
}
