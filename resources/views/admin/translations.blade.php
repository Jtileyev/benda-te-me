@extends('layouts.admin')

@section('page-title', __('site.translations'))

@section('content')
<form method="POST" action="{{ route('admin.translations.update') }}">
    @csrf
    @method('PUT')

    <div class="admin-card mb-4">
        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead><tr>
                    <th style="min-width: 180px;">{{ __('site.translation_key') }}</th>
                    @foreach($locales as $code => $meta)
                        <th style="min-width: 260px;">{{ strtoupper($code) }} @if(!empty($meta['name'])) ({{ $meta['name'] }}) @endif</th>
                    @endforeach
                </tr></thead>
                <tbody>
                @foreach($rows as $index => $row)
                    <tr>
                        <td>
                            <code style="font-size: 0.78rem; color: var(--text-muted);">{{ $row['key'] }}</code>
                            <input type="hidden" name="translations[{{ $index }}][key]" value="{{ $row['key'] }}">
                        </td>
                        @foreach($locales as $code => $meta)
                            <td>
                                <textarea class="form-control form-control-sm"
                                          rows="2"
                                          name="translations[{{ $index }}][{{ $code }}]">{{ $row[$code] ?? '' }}</textarea>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-section-title">
        <h2><i class="fa-solid fa-plus-circle"></i> {{ __('site.add_new_translation') }}</h2>
    </div>

    <div class="admin-form-card mb-4">
        <div class="row g-2">
            <div class="col-md-3">
                <label class="form-label">{{ __('site.translation_key') }}</label>
                <input class="form-control" name="new_key" placeholder="{{ __('site.translation_key_placeholder') }}">
            </div>
            @foreach($locales as $code => $meta)
                <div class="col-md-3">
                    <label class="form-label">{{ strtoupper($code) }}</label>
                    <input class="form-control" name="new_{{ $code }}">
                </div>
            @endforeach
        </div>
    </div>

    <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>{{ __('site.save_translations') }}</button>
</form>
@endsection
