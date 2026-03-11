<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('site.admin_panel') }} — {{ config('app.name', 'Benda Te Me') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="/css/site.css" rel="stylesheet">
</head>
<body class="admin-body">
<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar-header">
            <a href="{{ route('home') }}" class="admin-sidebar-brand">
                <span class="brand-mark"><i class="fa-solid fa-compass"></i></span>
                <span>{{ __('site.brand') }}</span>
            </a>
            <button class="admin-sidebar-close d-lg-none" onclick="document.getElementById('adminSidebar').classList.remove('open')">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav class="admin-sidebar-nav">
            <div class="admin-sidebar-label">{{ __('site.admin_panel') }}</div>

            <a href="{{ route('admin.dashboard') }}"
               class="admin-sidebar-link @if(request()->routeIs('admin.dashboard')) active @endif">
                <i class="fa-solid fa-gauge"></i>
                <span>{{ __('site.dashboard') }}</span>
            </a>
            <a href="{{ route('admin.requests.index') }}"
               class="admin-sidebar-link @if(request()->routeIs('admin.requests.*')) active @endif">
                <i class="fa-solid fa-inbox"></i>
                <span>{{ __('site.requests') }}</span>
            </a>
            <a href="{{ route('admin.videos.index') }}"
               class="admin-sidebar-link @if(request()->routeIs('admin.videos.*')) active @endif">
                <i class="fa-solid fa-video"></i>
                <span>{{ __('site.video_messages') }}</span>
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="admin-sidebar-link @if(request()->routeIs('admin.users.*')) active @endif">
                <i class="fa-solid fa-users"></i>
                <span>{{ __('site.users') }}</span>
            </a>

            <div class="admin-sidebar-label">{{ __('site.content') }}</div>

            <a href="{{ route('admin.content.index') }}"
               class="admin-sidebar-link @if(request()->routeIs('admin.content.*')) active @endif">
                <i class="fa-solid fa-file-lines"></i>
                <span>{{ __('site.text_content') }}</span>
            </a>
            <a href="{{ route('admin.translations.index') }}"
               class="admin-sidebar-link @if(request()->routeIs('admin.translations.*')) active @endif">
                <i class="fa-solid fa-language"></i>
                <span>{{ __('site.translations') }}</span>
            </a>
        </nav>

        <div class="admin-sidebar-footer">
            <div class="admin-sidebar-user">
                <i class="fa-regular fa-circle-user"></i>
                <div>
                    <div class="admin-sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="admin-sidebar-user-role">{{ __('site.role_' . auth()->user()->role) }}</div>
                </div>
            </div>
            <a href="{{ route('logout') }}" class="admin-sidebar-link"
               onclick="event.preventDefault();document.getElementById('admin-logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>{{ __('site.logout') }}</span>
            </a>
            <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </div>
    </aside>

    <!-- Main area -->
    <div class="admin-main-wrap">
        <header class="admin-topbar">
            <button class="admin-topbar-burger d-lg-none" onclick="document.getElementById('adminSidebar').classList.toggle('open')">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h1 class="admin-topbar-title">@yield('page-title')</h1>
            <div class="admin-topbar-right">
                <a href="{{ route('home') }}" class="admin-topbar-link">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> {{ __('site.home') }}
                </a>
            </div>
        </header>

        <main class="admin-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<!-- Mobile overlay -->
<div class="admin-sidebar-overlay d-lg-none" onclick="document.getElementById('adminSidebar').classList.remove('open')"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
