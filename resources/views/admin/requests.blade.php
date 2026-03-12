@extends('layouts.admin')

@section('page-title', __('site.requests'))

@section('content')
<div class="admin-section-title" style="margin-top: 0;">
    <h2><i class="fa-solid fa-user-slash"></i> {{ __('site.missing_person_requests') }}</h2>
</div>

<div class="admin-card mb-4">
    @if($missing->count())
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead><tr>
                <th>ID</th>
                <th>{{ __('site.name') }}</th>
                <th>{{ __('site.image') }}</th>
                <th>{{ __('site.last_seen_place') }}</th>
                <th>{{ __('site.status') }}</th>
                <th>{{ __('site.actions') }}</th>
            </tr></thead>
            <tbody>
            @foreach($missing as $item)
                <tr>
                    <td><span class="fw-semibold text-muted">#{{ $item->id }}</span></td>
                    <td><strong>{{ $item->full_name }}</strong></td>
                    <td>
                        @if($item->image_path)
                            <a target="_blank" rel="noopener" href="{{ asset('storage/' . $item->image_path) }}">{{ __('site.open_image') }}</a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="text-muted">{{ Str::limit($item->last_seen_place ?? '—', 30) }}</td>
                    <td><span class="status-badge status-{{ $item->status }}">{{ __('site.' . $item->status) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.requests.missing.update', $item) }}" class="d-flex gap-2 align-items-center">
                            @csrf @method('PUT')
                            <select name="status" class="form-select form-select-sm" style="min-width: 140px;">
                                @foreach(['new','in_review','approved','rejected'] as $status)
                                    <option value="{{ $status }}" @selected($status===$item->status)>{{ __('site.' . $status) }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-primary">{{ __('site.save') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="admin-empty">
        <i class="fa-solid fa-inbox"></i>
        <p>{{ __('site.no_requests_yet') }}</p>
    </div>
    @endif
</div>

<div class="admin-section-title">
    <h2><i class="fa-solid fa-circle-info"></i> {{ __('site.person_info_reports') }}</h2>
</div>

<div class="admin-card">
    @if($reports->count())
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead><tr>
                <th>ID</th>
                <th>{{ __('site.name') }}</th>
                <th>{{ __('site.image') }}</th>
                <th>{{ __('site.status') }}</th>
                <th>{{ __('site.actions') }}</th>
            </tr></thead>
            <tbody>
            @foreach($reports as $item)
                <tr>
                    <td><span class="fw-semibold text-muted">#{{ $item->id }}</span></td>
                    <td><strong>{{ $item->target_person_name }}</strong></td>
                    <td>
                        @if($item->image_path)
                            <a target="_blank" rel="noopener" href="{{ asset('storage/' . $item->image_path) }}">{{ __('site.open_image') }}</a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td><span class="status-badge status-{{ $item->status }}">{{ __('site.' . $item->status) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.requests.report.update', $item) }}" class="d-flex gap-2 align-items-center">
                            @csrf @method('PUT')
                            <select name="status" class="form-select form-select-sm" style="min-width: 140px;">
                                @foreach(['new','in_review','approved','rejected'] as $status)
                                    <option value="{{ $status }}" @selected($status===$item->status)>{{ __('site.' . $status) }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-primary">{{ __('site.save') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="admin-empty">
        <i class="fa-solid fa-inbox"></i>
        <p>{{ __('site.no_requests_yet') }}</p>
    </div>
    @endif
</div>
@endsection
