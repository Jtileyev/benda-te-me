@extends('layouts.admin')

@section('page-title', __('site.users'))

@section('content')
<div class="admin-card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead><tr>
                <th>ID</th>
                <th>{{ __('site.name') }}</th>
                <th>{{ __('site.email') }}</th>
                <th>{{ __('site.role') }}</th>
                <th>{{ __('site.status') }}</th>
                <th>{{ __('site.actions') }}</th>
            </tr></thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td><span class="fw-semibold text-muted">#{{ $user->id }}</span></td>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td class="text-muted">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="status-badge" style="background: #eff6ff; color: #2563eb;"><i class="fa-solid fa-shield-halved me-1" style="font-size: 0.65rem;"></i>{{ __('site.role_admin') }}</span>
                        @else
                            <span class="text-muted" style="font-size: 0.85rem;">{{ __('site.role_user') }}</span>
                        @endif
                    </td>
                    <td><span class="status-badge status-{{ $user->status }}">{{ __('site.' . $user->status) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="d-flex gap-2 align-items-center">
                            @csrf @method('PUT')
                            <select name="role" class="form-select form-select-sm" style="min-width: 110px;">
                                <option value="user" @selected($user->role==='user')>{{ __('site.role_user') }}</option>
                                <option value="admin" @selected($user->role==='admin')>{{ __('site.role_admin') }}</option>
                            </select>
                            <select name="status" class="form-select form-select-sm" style="min-width: 110px;">
                                <option value="active" @selected($user->status==='active')>{{ __('site.active') }}</option>
                                <option value="blocked" @selected($user->status==='blocked')>{{ __('site.blocked') }}</option>
                            </select>
                            <button class="btn btn-sm btn-primary">{{ __('site.save') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
