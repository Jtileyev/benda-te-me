@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="about-hero">
        <h1>{{ __('site.about') }}</h1>
        <p class="lead">{{ __('site.welcome') }}</p>
    </div>

    <div class="about-features">
        <div class="about-feature-card">
            <div class="about-feature-icon blue"><i class="fa-solid fa-magnifying-glass"></i></div>
            <h3>{{ __('site.about_feature_search') }}</h3>
            <p>{{ __('site.about_feature_search_desc') }}</p>
        </div>
        <div class="about-feature-card">
            <div class="about-feature-icon gold"><i class="fa-solid fa-video"></i></div>
            <h3>{{ __('site.about_feature_video') }}</h3>
            <p>{{ __('site.about_feature_video_desc') }}</p>
        </div>
        <div class="about-feature-card">
            <div class="about-feature-icon teal"><i class="fa-solid fa-people-group"></i></div>
            <h3>{{ __('site.about_feature_community') }}</h3>
            <p>{{ __('site.about_feature_community_desc') }}</p>
        </div>
    </div>

    <div class="about-steps">
        <h2>{{ __('site.about_how_it_works') }}</h2>
        <div class="about-steps-grid">
            <div class="about-step">
                <div class="about-step-number">1</div>
                <h4>{{ __('site.about_step_1') }}</h4>
                <p>{{ __('site.about_step_1_desc') }}</p>
            </div>
            <div class="about-step">
                <div class="about-step-number">2</div>
                <h4>{{ __('site.about_step_2') }}</h4>
                <p>{{ __('site.about_step_2_desc') }}</p>
            </div>
            <div class="about-step">
                <div class="about-step-number">3</div>
                <h4>{{ __('site.about_step_3') }}</h4>
                <p>{{ __('site.about_step_3_desc') }}</p>
            </div>
        </div>
    </div>

    <div class="about-cta">
        <h2>{{ __('site.join_project') }}</h2>
        <p>{{ __('site.join_subtitle_default') }}</p>
        <a href="{{ route('register') }}" class="btn">{{ __('site.register') }}</a>
    </div>
</div>
@endsection
