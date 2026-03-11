@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-gauge me-2"></i>{{ __('site.dashboard') }}
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="text-center py-4">
                        <i class="fa-regular fa-circle-check fa-3x mb-3" style="color: var(--gold);"></i>
                        <h4>{{ __('site.you_are_logged_in') }}</h4>
                        <p class="text-muted mb-0">{{ __('site.welcome') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
