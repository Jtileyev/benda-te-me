@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-2">{{ __('site.add_video_message') }}</h1>
    <p class="text-muted mb-4">{{ __('site.video_create_hint') }}</p>

    <form method="POST" action="{{ route('video-messages.store') }}" enctype="multipart/form-data" class="card card-body shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ __('site.title') }} <span class="text-danger">*</span></label>
            <input name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('site.description') }}</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('site.video_file') }}</label>
                <input type="file" name="video_file" class="form-control" accept="video/*">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('site.video_url') }}</label>
                <input name="video_url" class="form-control" value="{{ old('video_url') }}" placeholder="https://...">
            </div>
        </div>
        <div class="mb-4">
            <label class="form-label">{{ __('site.preview_image') }}</label>
            <input type="file" name="preview_image" class="form-control" accept="image/*">
        </div>
        <button class="btn btn-warning">
            <i class="fa-solid fa-paper-plane me-1"></i>{{ __('site.save') }}
        </button>
    </form>
</div>
@endsection
