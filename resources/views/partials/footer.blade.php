<footer class="app-footer">
    @php
        $platformIcons = [
            'telegram' => 'fa-brands fa-telegram',
            'instagram' => 'fa-brands fa-instagram',
            'facebook' => 'fa-brands fa-facebook-f',
            'youtube' => 'fa-brands fa-youtube',
            'tiktok' => 'fa-brands fa-tiktok',
            'x' => 'fa-brands fa-x-twitter',
            'twitter' => 'fa-brands fa-x-twitter',
        ];
    @endphp
    <div class="container">
        <div class="app-footer-grid">
            <div>
                <div class="app-footer-brand">
                    <span class="brand-mark"><i class="fa-solid fa-compass"></i></span>
                    {{ __('site.brand') }}
                </div>
                <p class="app-footer-desc">{{ __('site.hero_subtitle_default') }}</p>
            </div>
            <div>
                <h5>{{ __('site.nav_pages') }}</h5>
                <ul class="app-footer-links">
                    <li><a href="{{ route('home') }}">{{ __('site.home') }}</a></li>
                    <li><a href="{{ route('about') }}">{{ __('site.about') }}</a></li>
                    <li><a href="{{ route('search') }}">{{ __('site.search') }}</a></li>
                    <li><a href="{{ route('video-messages.index') }}">{{ __('site.video_messages') }}</a></li>
                </ul>
            </div>
            <div>
                <h5>{{ __('site.actions') }}</h5>
                <ul class="app-footer-links">
                    <li><a href="{{ route('missing-person.create') }}">{{ __('site.search_missing') }}</a></li>
                    <li><a href="{{ route('provide-info.create') }}">{{ __('site.provide_info') }}</a></li>
                    <li><a href="{{ route('live') }}">{{ __('site.live_stream') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="app-footer-bottom">
            <span>&copy; {{ date('Y') }} {{ __('site.brand') }}</span>
            <div class="app-footer-social">
                @foreach(($footerSocialLinks ?? collect()) as $link)
                    @php
                        $icon = $platformIcons[strtolower($link->platform)] ?? 'fa-solid fa-link';
                    @endphp
                    <a href="{{ $link->url }}" target="_blank" rel="noopener" aria-label="{{ $link->platform }}">
                        <i class="{{ $icon }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
