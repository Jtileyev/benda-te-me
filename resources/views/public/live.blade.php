@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('site.live_stream') }}</h1>

    <div class="live-container">
        <div class="live-player-wrap">
            <div class="live-player">
                <div class="live-player-icon">
                    <i class="fa-solid fa-tower-broadcast"></i>
                </div>
                <h3>{{ __('site.live_coming_soon') }}</h3>
                <p>{{ __('site.live_placeholder') }}</p>
            </div>
        </div>

        <div class="live-info-cards">
            <div class="live-info-card">
                <i class="fa-solid fa-bell"></i>
                <div>
                    <h5>{{ __('site.live_notifications') }}</h5>
                    <p>{{ __('site.live_notifications_desc') }}</p>
                </div>
            </div>
            <div class="live-info-card">
                <i class="fa-solid fa-clock"></i>
                <div>
                    <h5>{{ __('site.live_schedule') }}</h5>
                    <p>{{ __('site.live_schedule_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
