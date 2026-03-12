<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Benda Te Me') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="/css/site.css" rel="stylesheet">
</head>
<body class="app-page">
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top app-navbar">
        <div class="container app-navbar-shell">
            <a class="navbar-brand app-brand d-inline-flex align-items-center gap-2" href="{{ route('home') }}">
                <span class="brand-mark"><i class="fa-solid fa-compass"></i></span>
                <span>{{ __('site.brand') }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse app-navbar-collapse" id="navMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 app-nav-links">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('about')) active @endif" href="{{ route('about') }}">
                            <i class="fa-regular fa-address-card"></i><span>{{ __('site.about') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('search*','missing-person.*','provide-info.*')) active @endif" href="{{ route('search') }}">
                            <i class="fa-solid fa-magnifying-glass"></i><span>{{ __('site.search_missing') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('video-messages.*')) active @endif" href="{{ route('video-messages.index') }}">
                            <i class="fa-solid fa-video"></i><span>{{ __('site.video_messages') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('live')) active @endif" href="{{ route('live') }}">
                            <i class="fa-solid fa-tower-broadcast"></i><span>{{ __('site.live_stream') }}</span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto align-items-lg-center app-navbar-tools">
                    @php $locales = config('app.available_locales', []); @endphp
                    <li class="nav-item">
                        <div class="nav-lang-dropdown">
                            <button class="nav-lang-toggle" type="button" onclick="this.parentElement.classList.toggle('open')">
                                <span>{{ $locales[app()->getLocale()]['flag'] ?? '' }}</span>
                                <span>{{ strtoupper(app()->getLocale()) }}</span>
                                <i class="fa-solid fa-chevron-down fa-xs"></i>
                            </button>
                            <div class="nav-lang-menu">
                                @foreach($locales as $code => $meta)
                                    <a href="{{ route('locale.set', $code) }}"
                                       class="nav-lang-option @if(app()->getLocale() === $code) active @endif">
                                        <span>{{ $meta['flag'] }}</span>
                                        <span>{{ $meta['name'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item"><a class="nav-link app-admin-link" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-1"></i>{{ __('site.admin_panel') }}</a></li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle app-user-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-regular fa-circle-user"></i>
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('cabinet') }}">{{ __('site.personal_cabinet') }}</a></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('site.logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="btn app-btn app-btn-ghost btn-sm" href="{{ route('login') }}">{{ __('site.authorization') }}</a></li>
                        <li class="nav-item"><a class="btn app-btn app-btn-solid btn-sm" href="{{ route('register') }}">{{ __('site.register') }}</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="app-main py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        @yield('content')
    </main>

    @include('partials.footer')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>document.addEventListener('click',function(e){document.querySelectorAll('.nav-lang-dropdown.open').forEach(function(d){if(!d.contains(e.target))d.classList.remove('open')})});</script>
</body>
</html>
