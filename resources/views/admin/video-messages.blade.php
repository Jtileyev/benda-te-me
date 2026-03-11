@extends('layouts.admin')

@section('page-title', __('site.video_messages'))

@section('content')
<div class="admin-card">
    @if($videoMessages->count())
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead><tr>
                <th>ID</th>
                <th>{{ __('site.title') }}</th>
                <th>{{ __('site.status') }}</th>
                <th>{{ __('site.actions') }}</th>
            </tr></thead>
            <tbody>
            @foreach($videoMessages as $item)
                <tr>
                    <td><span class="fw-semibold text-muted">#{{ $item->id }}</span></td>
                    <td><strong>{{ $item->title }}</strong></td>
                    <td><span class="status-badge status-{{ $item->moderation_status }}">{{ __('site.' . $item->moderation_status) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.videos.update', $item) }}" class="d-flex gap-2 align-items-center">
                            @csrf @method('PUT')
                            <select name="status" class="form-select form-select-sm" style="min-width: 140px;">
                                @foreach(['new','in_review','approved','rejected'] as $status)
                                    <option value="{{ $status }}" @selected($status===$item->moderation_status)>{{ __('site.' . $status) }}</option>
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
        <i class="fa-solid fa-video-slash"></i>
        <p>{{ __('site.no_video_messages_yet') }}</p>
    </div>
    @endif
</div>
@endsection
