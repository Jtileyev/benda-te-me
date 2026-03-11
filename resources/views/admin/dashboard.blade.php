@extends('layouts.admin')

@section('page-title', __('site.dashboard'))

@php
    $icons = [
        'missing_person_requests' => ['fa-solid fa-user-slash', 'blue'],
        'person_info_reports' => ['fa-solid fa-circle-info', 'teal'],
        'video_messages' => ['fa-solid fa-video', 'gold'],
        'users' => ['fa-solid fa-users', 'rose'],
        'search_queries' => ['fa-solid fa-magnifying-glass', 'blue'],
        'views' => ['fa-solid fa-eye', 'teal'],
    ];
@endphp

@section('content')
<div class="row g-3 mb-4">
    @foreach($stats as $name => $value)
        <div class="col-md-4 col-6">
            <div class="admin-stat-card">
                @if(isset($icons[$name]))
                    <div class="admin-stat-icon {{ $icons[$name][1] }}"><i class="{{ $icons[$name][0] }}"></i></div>
                @else
                    <div class="admin-stat-icon blue"><i class="fa-solid fa-chart-simple"></i></div>
                @endif
                <div>
                    <h4>{{ number_format($value) }}</h4>
                    <div class="stat-label">{{ $name }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="admin-section-title">
    <h2>{{ __('site.quick_links') }}</h2>
</div>

<div class="admin-quick-links">
    <a href="{{ route('admin.requests.index') }}" class="admin-quick-link">
        <i class="fa-solid fa-inbox"></i>
        <span>{{ __('site.requests') }}</span>
    </a>
    <a href="{{ route('admin.videos.index') }}" class="admin-quick-link">
        <i class="fa-solid fa-video"></i>
        <span>{{ __('site.video_messages') }}</span>
    </a>
    <a href="{{ route('admin.users.index') }}" class="admin-quick-link">
        <i class="fa-solid fa-users"></i>
        <span>{{ __('site.users') }}</span>
    </a>
    <a href="{{ route('admin.content.index') }}" class="admin-quick-link">
        <i class="fa-solid fa-file-lines"></i>
        <span>{{ __('site.content') }}</span>
    </a>
    <a href="{{ route('admin.translations.index') }}" class="admin-quick-link">
        <i class="fa-solid fa-language"></i>
        <span>{{ __('site.translations') }}</span>
    </a>
    <a href="{{ route('home') }}" class="admin-quick-link">
        <i class="fa-solid fa-globe"></i>
        <span>{{ __('site.home') }}</span>
    </a>
</div>
@endsection
