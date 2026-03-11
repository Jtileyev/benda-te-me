@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">{{ __('site.video_messages') }}</h1>
        @auth
            <a class="btn btn-warning" href="{{ route('video-messages.create') }}">
                <i class="fa-solid fa-plus me-1"></i>{{ __('site.add_video_message') }}
            </a>
        @endauth
    </div>

    <div class="row g-3">
        @forelse($videoMessages as $video)
            <div class="col-md-4">
                <div class="video-card">
                    <div class="video-card-thumb">
                        @if($video->preview_image)
                            <img src="{{ asset('storage/' . $video->preview_image) }}" alt="{{ $video->title }}">
                        @endif
                        <div class="play-icon" style="position: absolute;">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    </div>
                    <div class="video-card-body">
                        <h5>{{ $video->title }}</h5>
                        <p>{{ Str::limit($video->description, 100) }}</p>
                        @if($video->video_url)
                            <a target="_blank" rel="noopener" href="{{ $video->video_url }}">{{ __('site.open_video') }}</a>
                        @elseif($video->video_path)
                            <a target="_blank" rel="noopener" href="{{ asset('storage/' . $video->video_path) }}">{{ __('site.open_video') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="search-empty">
                    <i class="fa-solid fa-video-slash d-block"></i>
                    <p>{{ __('site.no_video_messages_yet') }}</p>
                </div>
            </div>
        @endforelse
    </div>
    <div class="mt-4">{{ $videoMessages->links() }}</div>
</div>
@endsection
