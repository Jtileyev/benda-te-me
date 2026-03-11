@extends('layouts.admin')

@section('page-title', __('site.content'))

@section('content')
<div class="admin-section-title" style="margin-top: 0;">
    <h2><i class="fa-solid fa-plus-circle"></i> {{ __('site.add_content') }}</h2>
</div>

<form method="POST" action="{{ route('admin.content.update') }}" class="admin-form-card mb-4">
    @csrf @method('PUT')
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">{{ __('site.key') }}</label>
            <input class="form-control" name="key" placeholder="{{ __('site.key') }}" required>
        </div>
        <div class="col-md-2">
            <label class="form-label">{{ __('site.locale') }}</label>
            <select class="form-select" name="locale"><option value="ru">RU</option><option value="en">EN</option></select>
        </div>
        <div class="col-md-5">
            <label class="form-label">{{ __('site.value') }}</label>
            <input class="form-control" name="value" placeholder="{{ __('site.value') }}" required>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100"><i class="fa-solid fa-plus me-1"></i>{{ __('site.save') }}</button>
        </div>
    </div>
</form>

<div class="admin-section-title">
    <h2><i class="fa-solid fa-file-lines"></i> {{ __('site.text_content') }}</h2>
</div>

<div class="admin-card mb-4">
    <div class="table-responsive">
        <table class="table table-sm table-striped mb-0">
            <thead><tr>
                <th>{{ __('site.key') }}</th>
                <th>{{ __('site.locale') }}</th>
                <th>{{ __('site.value') }}</th>
            </tr></thead>
            <tbody>
            @foreach($content as $item)
                <tr>
                    <td><code style="font-size: 0.8rem; color: var(--text-muted);">{{ $item->key }}</code></td>
                    <td><span class="status-badge" style="background: var(--light-bg); color: var(--text-muted);">{{ strtoupper($item->locale) }}</span></td>
                    <td>{{ $item->value }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="admin-section-title">
    <h2><i class="fa-solid fa-share-nodes"></i> {{ __('site.social_links') }}</h2>
</div>

<div class="row g-3">
    @foreach($socialLinks as $social)
        <div class="col-md-6">
            <form method="POST" action="{{ route('admin.content.social.update', $social) }}" class="admin-social-card">
                @csrf @method('PUT')
                <div class="admin-social-icon">
                    <i class="fa-brands fa-{{ strtolower($social->platform) }}"></i>
                </div>
                <div class="flex-grow-1">
                    <div class="fw-semibold mb-2" style="font-size: 0.88rem;">{{ $social->platform }}</div>
                    <input class="form-control form-control-sm mb-2" name="url" value="{{ $social->url }}" placeholder="URL" required>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-1">
                            <label class="form-label mb-0" style="font-size: 0.72rem; color: var(--text-muted);">#</label>
                            <input class="form-control form-control-sm" type="number" name="sort_order" value="{{ $social->sort_order }}" style="width: 56px;">
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" @checked($social->is_active) id="social-{{ $social->id }}">
                            <label class="form-check-label" for="social-{{ $social->id }}" style="font-size: 0.8rem;">{{ __('site.active') }}</label>
                        </div>
                        <button class="btn btn-primary btn-sm ms-auto" style="font-size: 0.78rem;">{{ __('site.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    @endforeach
</div>
@endsection
