@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-2">{{ __('site.personal_cabinet') }}</h1>
    <p class="text-muted mb-4">{{ __('site.cabinet_hint') }}</p>

    <div class="row g-3">
        <div class="col-md-4">
            <a class="card card-body shadow-sm h-100 text-decoration-none" href="{{ route('provide-info.create') }}">
                <h5 class="mb-1">{{ __('site.provide_info') }}</h5>
                <p class="text-muted mb-0">{{ __('site.provide_info_hint') }}</p>
            </a>
        </div>
        <div class="col-md-4">
            <a class="card card-body shadow-sm h-100 text-decoration-none" href="{{ route('video-messages.create') }}">
                <h5 class="mb-1">{{ __('site.add_video_message') }}</h5>
                <p class="text-muted mb-0">{{ __('site.video_create_hint') }}</p>
            </a>
        </div>
        <div class="col-md-4">
            <a class="card card-body shadow-sm h-100 text-decoration-none" href="{{ route('search') }}">
                <h5 class="mb-1">{{ __('site.search_missing') }}</h5>
                <p class="text-muted mb-0">{{ __('site.search_help_short') }}</p>
            </a>
        </div>
    </div>
</div>
@endsection
