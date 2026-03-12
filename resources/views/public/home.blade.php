@extends('layouts.landing')

@php
    $platformMeta = [
        'facebook'  => ['icon' => 'fa-brands fa-facebook-f',  'color' => '#1877F2'],
        'instagram' => ['icon' => 'fa-brands fa-instagram',   'color' => '#E4405F'],
        'tiktok'    => ['icon' => 'fa-brands fa-tiktok',      'color' => '#010101'],
        'vk'        => ['icon' => 'fa-brands fa-vk',          'color' => '#4680C2'],
        'vk.com'    => ['icon' => 'fa-brands fa-vk',          'color' => '#4680C2'],
        'telegram'  => ['icon' => 'fa-brands fa-telegram',    'color' => '#26A5E4'],
        'twitter'   => ['icon' => 'fa-brands fa-x-twitter',   'color' => '#14171A'],
        'x'         => ['icon' => 'fa-brands fa-x-twitter',   'color' => '#14171A'],
        'ok'        => ['icon' => 'fa-brands fa-odnoklassniki','color' => '#EE8208'],
        'ok.ru'     => ['icon' => 'fa-brands fa-odnoklassniki','color' => '#EE8208'],
        'youtube'   => ['icon' => 'fa-brands fa-youtube',     'color' => '#FF0000'],
        'snapchat'  => ['icon' => 'fa-brands fa-snapchat',    'color' => '#FFFC00'],
        'whatsapp'  => ['icon' => 'fa-brands fa-whatsapp',    'color' => '#25D366'],
    ];
@endphp

@section('content')
<section class="hero-clone">
    <!-- Sun rays -->
    <div class="hero-rays"></div>
    <div class="hero-sun-glow"></div>
    <!-- Ocean waves -->
    <div class="hero-waves">
        <svg viewBox="0 0 1440 200" preserveAspectRatio="none">
            <path class="wave wave-1" d="M0,100 C160,160 320,40 480,100 C640,160 800,40 960,100 C1120,160 1280,40 1440,100 L1440,200 L0,200 Z"/>
            <path class="wave wave-2" d="M0,130 C200,70 400,170 600,110 C800,50 1000,160 1200,100 C1320,70 1400,120 1440,110 L1440,200 L0,200 Z"/>
            <path class="wave wave-3" d="M0,150 C120,120 240,170 360,140 C480,110 600,170 720,140 C840,110 960,165 1080,135 C1200,105 1320,160 1440,140 L1440,200 L0,200 Z"/>
        </svg>
    </div>
    <div class="hero-inner">
        <!-- Language switcher -->
        @php $locales = config('app.available_locales', []); @endphp
        <div class="hero-lang-dropdown">
            <button class="hero-lang-toggle" type="button" onclick="this.parentElement.classList.toggle('open')">
                <span>{{ $locales[app()->getLocale()]['flag'] ?? '' }}</span>
                <span>{{ strtoupper(app()->getLocale()) }}</span>
                <i class="fa-solid fa-chevron-down"></i>
            </button>
            <div class="hero-lang-menu">
                @foreach($locales as $code => $meta)
                    <a href="{{ route('locale.set', $code) }}"
                       class="hero-lang-option @if(app()->getLocale() === $code) active @endif">
                        <span>{{ $meta['flag'] }}</span>
                        <span>{{ $meta['name'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <img class="hero-logo" src="{{ asset('images/hero-logo.svg') }}" alt="logo">
        <p class="hero-views">{!! str_replace(number_format($totalViews), '<span class="count-up" data-target="' . $totalViews . '">0</span>', __('site.views', ['count' => number_format($totalViews)])) !!}</p>

        <form class="search-row" method="POST" action="{{ route('search.store') }}">
            @csrf
            <input name="query" value="{{ old('query') }}" placeholder="{{ __('site.search_placeholder') }}" aria-label="Search query">
            <button type="submit">{{ __('site.search') }}</button>
        </form>

        <div class="actions-grid">
            @foreach($actions as $action)
                <a href="{{ $action['href'] }}" class="action-item" aria-label="{{ $action['label'] }}">
                    <span class="icon-wrap">
                        <i class="{{ $action['fa'] }}"></i>
                    </span>
                    <span class="label">{{ $action['label'] }}</span>
                </a>
            @endforeach
            <!-- Marketplace (coming soon) -->
            <a href="#" class="action-item action-item--soon" onclick="event.preventDefault();" aria-label="{{ __('site.marketplace') }}">
                <span class="icon-wrap">
                    <i class="fa-solid fa-store"></i>
                </span>
                <span class="label">{{ __('site.marketplace') }}</span>
                <span class="action-badge">{{ __('site.coming_soon') }}</span>
            </a>
        </div>
    </div>
</section>

<section class="link-bars-wrap">
    <div class="link-bars">
        <a href="{{ route('search') }}">{{ __('site.how_to_search') }}</a>
        <a href="{{ route('missing-person.create') }}">{{ __('site.participate') }}</a>
        <a href="{{ route('about') }}">{{ __('site.project_purpose') }}</a>
    </div>
</section>

<section class="join-clone">
    <h2>{{ $content['join_title'] }}</h2>
    <p>{{ $content['join_subtitle'] }}</p>
    <a href="{{ route('register') }}">{{ __('site.connections') }}</a>
</section>

@if($socialLinks->count())
<section class="social-section">
    <div class="social-section-inner">
        <h3 class="social-section-title">{{ __('site.subscribe_us') }}</h3>
        <div class="social-buttons">
            @foreach($socialLinks as $link)
                @php
                    $key = strtolower($link->platform);
                    $meta = $platformMeta[$key] ?? ['icon' => 'fa-solid fa-link', 'color' => '#3a6b84'];
                @endphp
                <a href="{{ $link->url }}" target="_blank" rel="noopener"
                   class="social-btn" style="--btn-color: {{ $meta['color'] }};">
                    <span class="social-btn-icon"><i class="{{ $meta['icon'] }}"></i></span>
                    <span class="social-btn-text">
                        <span class="social-btn-cta">{{ __('site.subscribe_cta') }}</span>
                        <span class="social-btn-name">{{ $link->platform }}</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
