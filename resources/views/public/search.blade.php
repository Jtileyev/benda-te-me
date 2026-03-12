@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('site.search_missing') }}</h1>
    <div class="alert alert-info mb-4" role="alert">
        <strong>{{ __('site.how_to_use') }}</strong>
        <div>{{ __('site.search_help_short') }}</div>
    </div>

    @php
        $activeSection = session('search_section', $section ?? 'missing');
        if (!in_array($activeSection, ['missing', 'reports'], true)) {
            $activeSection = 'missing';
        }
        $results = session('search_results');
    @endphp

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a class="nav-link @if($activeSection === 'missing') active @endif" href="{{ route('search', ['section' => 'missing']) }}">
                {{ __('site.user_requests') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if($activeSection === 'reports') active @endif" href="{{ route('search', ['section' => 'reports']) }}">
                {{ __('site.person_info_reports') }}
            </a>
        </li>
    </ul>

    <div class="search-form-wrap">
        <form method="POST" action="{{ route('search.store') }}">
            @csrf
            <input type="hidden" name="section" value="{{ $activeSection }}">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0" style="border-radius: var(--radius-sm) 0 0 var(--radius-sm);">
                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                </span>
                <input class="form-control border-start-0" name="query" value="{{ old('query', session('search_query')) }}"
                       placeholder="{{ __('site.search_placeholder') }}" required>
                <button class="btn btn-warning" type="submit">{{ __('site.search') }}</button>
            </div>
        </form>
    </div>

    @if($activeSection === 'reports')
        <h2 class="h5 mb-3">{{ $results ? __('site.search_results_title') : __('site.person_info_reports') }}</h2>
        @forelse(($results ?? $latestInfoReports ?? collect()) as $report)
            <div class="search-result-card">
                <div class="search-result-icon">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="search-result-info">
                    <h5>{{ $report->target_person_name }}</h5>
                    <p>{{ \Illuminate\Support\Str::limit($report->message, 120) }}</p>
                    @if(!empty($report->contacts))
                        <p><i class="fa-solid fa-address-book"></i> {{ $report->contacts }}</p>
                    @endif
                    @if(!empty($report->image_path))
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $report->image_path) }}" target="_blank" rel="noopener">
                                <img src="{{ asset('storage/' . $report->image_path) }}"
                                     alt="{{ $report->target_person_name }}"
                                     style="max-width: 140px; border-radius: 10px; border: 1px solid #e2e8f0;">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="search-empty">
                <i class="fa-regular fa-face-frown d-block"></i>
                <p>{{ __('site.no_results') }}</p>
            </div>
        @endforelse
    @else
        <h2 class="h5 mb-3">{{ $results ? __('site.search_results_title') : __('site.user_requests') }}</h2>
        @forelse(($results ?? $latestMissingRequests ?? collect()) as $result)
            <div class="search-result-card">
                <div class="search-result-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="search-result-info">
                    <h5>{{ $result->full_name }}</h5>
                    <p><i class="fa-solid fa-location-dot"></i> {{ $result->last_seen_place }}</p>
                    @if(!empty($result->birth_date))
                        <p><i class="fa-regular fa-calendar"></i> {{ __('site.birth_date') }}: {{ \Illuminate\Support\Carbon::parse($result->birth_date)->format('Y-m-d') }}</p>
                    @endif
                    @if(!empty($result->description))
                        <p>{{ \Illuminate\Support\Str::limit($result->description, 120) }}</p>
                    @endif
                    @if(!empty($result->contacts))
                        <p><i class="fa-solid fa-address-book"></i> {{ $result->contacts }}</p>
                    @endif
                    @if(!empty($result->image_path))
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $result->image_path) }}" target="_blank" rel="noopener">
                                <img src="{{ asset('storage/' . $result->image_path) }}"
                                     alt="{{ $result->full_name }}"
                                     style="max-width: 140px; border-radius: 10px; border: 1px solid #e2e8f0;">
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="search-empty">
                <i class="fa-regular fa-face-frown d-block"></i>
                <p>{{ __('site.no_results') }}</p>
            </div>
        @endforelse
    @endif
</div>
@endsection
