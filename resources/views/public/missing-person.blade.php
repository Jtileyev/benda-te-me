@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-2">{{ __('site.search_missing') }}</h1>
    <p class="text-muted mb-4">{{ __('site.missing_person_hint') }}</p>

    <form method="POST" action="{{ route('missing-person.store') }}" enctype="multipart/form-data" class="card card-body shadow-sm">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('site.full_name') }} <span class="text-danger">*</span></label>
                <input name="full_name" class="form-control" value="{{ old('full_name') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('site.birth_date') }}</label>
                <input name="birth_date" type="date" class="form-control" value="{{ old('birth_date') }}">
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('site.last_seen_place') }} <span class="text-danger">*</span></label>
            <input name="last_seen_place" class="form-control" value="{{ old('last_seen_place') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ __('site.description') }} <span class="text-danger">*</span></label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
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
