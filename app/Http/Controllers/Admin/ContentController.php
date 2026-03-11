<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSiteContentRequest;
use App\Models\SiteContent;
use App\Models\SocialLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(): View
    {
        return view('admin.content', [
            'content' => SiteContent::query()->orderBy('key')->orderBy('locale')->get(),
            'socialLinks' => SocialLink::query()->orderBy('sort_order')->get(),
        ]);
    }

    public function update(UpdateSiteContentRequest $request): RedirectResponse
    {
        SiteContent::updateOrCreate(
            ['key' => $request->validated('key'), 'locale' => $request->validated('locale')],
            ['value' => $request->validated('value'), 'updated_by' => auth()->id()]
        );

        return back()->with('success', __('site.content_updated'));
    }

    public function updateSocial(Request $request, SocialLink $socialLink): RedirectResponse
    {
        $validated = $request->validate([
            'url' => ['required', 'url', 'max:2048'],
            'is_active' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
        ]);

        $socialLink->update([
            'url' => $validated['url'],
            'sort_order' => $validated['sort_order'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return back()->with('success', __('site.content_updated'));
    }
}
