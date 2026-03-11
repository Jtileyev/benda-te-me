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
        return view('admin.translations', [
            'rows' => SiteTranslations::allRows(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'translations' => ['required', 'array'],
            'translations.*.key' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9._-]+$/i'],
            'translations.*.en' => ['nullable', 'string', 'max:20000'],
            'translations.*.ru' => ['nullable', 'string', 'max:20000'],
            'new_key' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9._-]+$/i'],
            'new_en' => ['nullable', 'string', 'max:20000'],
            'new_ru' => ['nullable', 'string', 'max:20000'],
        ]);

        $en = [];
        $ru = [];

        foreach ($validated['translations'] as $row) {
            $key = $row['key'];
            $en[$key] = (string) ($row['en'] ?? '');
            $ru[$key] = (string) ($row['ru'] ?? '');
        }

        $newKey = trim((string) ($validated['new_key'] ?? ''));
        if ($newKey !== '') {
            $en[$newKey] = (string) ($validated['new_en'] ?? '');
            $ru[$newKey] = (string) ($validated['new_ru'] ?? '');
        }

        SiteTranslations::save('en', $en);
        SiteTranslations::save('ru', $ru);

        return back()->with('success', __('site.translations_updated'));
    }
}
