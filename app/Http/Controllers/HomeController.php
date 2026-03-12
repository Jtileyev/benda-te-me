<?php

namespace App\Http\Controllers;

use App\Models\SiteContent;
use App\Models\SocialLink;
use App\Models\ViewCounter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();

        $counter = ViewCounter::firstOrCreate(['page_key' => 'home'], ['total_views' => 223652]);

        $content = [
            'hero_title' => SiteContent::content('hero_title', $locale, __('site.hero_title_default')),
            'hero_subtitle' => SiteContent::content('hero_subtitle', $locale, __('site.hero_subtitle_default')),
            'join_title' => SiteContent::content('join_title', $locale, __('site.join_title_default')),
            'join_subtitle' => SiteContent::content('join_subtitle', $locale, __('site.join_subtitle_default')),
        ];

        $actions = [
            [
                'label' => Auth::check() ? __('site.personal_cabinet') : __('site.authorization'),
                'href' => Auth::check() ? route('cabinet') : route('login'),
                'fa' => Auth::check() ? 'fa-solid fa-user' : 'fa-solid fa-right-to-bracket',
            ],
            ['label' => __('site.search'), 'href' => route('search'), 'fa' => 'fa-solid fa-magnifying-glass'],
            ['label' => __('site.search_missing'), 'href' => route('missing-person.create'), 'fa' => 'fa-solid fa-user-plus'],
            ['label' => __('site.provide_info'), 'href' => route('provide-info.create'), 'fa' => 'fa-solid fa-circle-info'],
            ['label' => __('site.video_messages'), 'href' => route('video-messages.index'), 'fa' => 'fa-solid fa-video'],
            ['label' => __('site.add_video_message'), 'href' => route('video-messages.create'), 'fa' => 'fa-solid fa-plus'],
            ['label' => __('site.about'), 'href' => route('about'), 'fa' => 'fa-regular fa-address-card'],
            ['label' => __('site.live_stream'), 'href' => route('live'), 'fa' => 'fa-solid fa-tower-broadcast'],
        ];

        $socialLinks = SocialLink::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        if ($socialLinks->isEmpty()) {
            $socialLinks = collect([
                (object) ['platform' => 'Telegram', 'url' => 'https://t.me'],
                (object) ['platform' => 'Instagram', 'url' => 'https://instagram.com'],
                (object) ['platform' => 'Facebook', 'url' => 'https://facebook.com'],
            ]);
        }

        return view('public.home', [
            'content' => $content,
            'actions' => $actions,
            'socialLinks' => $socialLinks,
            'totalViews' => $counter->total_views,
        ]);
    }

    public function setLocale(string $locale): RedirectResponse
    {
        $available = array_keys(config('app.available_locales', []));

        if (in_array($locale, $available, true)) {
            session(['locale' => $locale]);
        }

        return back();
    }

    public function cabinet(): View
    {
        return view('public.cabinet');
    }
}
