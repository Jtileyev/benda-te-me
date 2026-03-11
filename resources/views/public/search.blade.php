@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('site.search_missing') }}</h1>

    <div class="search-form-wrap">
        <form method="POST" action="{{ route('search.store') }}">
            @csrf
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

    @if(session('search_results'))
        @forelse(session('search_results') as $result)
            <div class="search-result-card">
                <div class="search-result-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="search-result-info">
                    <h5>{{ $result->full_name }}</h5>
                    <p><i class="fa-solid fa-location-dot"></i> {{ $result->last_seen_place }}</p>
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
