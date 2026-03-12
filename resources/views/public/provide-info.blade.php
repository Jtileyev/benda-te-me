@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-2">{{ __('site.provide_info') }}</h1>
    <p class="text-muted mb-4">{{ __('site.provide_info_hint') }}</p>

    <div class="alert alert-info mb-4" role="alert">
        <strong>{{ __('site.how_to_use') }}</strong>
        <div>{{ __('site.provide_info_help_short') }}</div>
    </div>

    <form method="POST" action="{{ route('provide-info.store') }}" enctype="multipart/form-data" class="card card-body shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ __('site.target_person_name') }} <span class="text-danger">*</span></label>
            <input name="target_person_name" class="form-control" value="{{ old('target_person_name') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('site.message') }} <span class="text-danger">*</span></label>
            <textarea name="message" class="form-control" rows="4" required>{{ old('message') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="form-label">{{ __('site.contacts') }} <span class="text-danger">*</span></label>
            <input name="contacts" class="form-control" value="{{ old('contacts') }}" required>
        </div>
        <div class="mb-4">
            <label class="form-label">{{ __('site.image') }}</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <button class="btn btn-warning">
            <i class="fa-solid fa-paper-plane me-1"></i>{{ __('site.save') }}
        </button>
    </form>
</div>
@endsection
