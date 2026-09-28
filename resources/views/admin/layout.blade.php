<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم') | {{ config('manbar.site_name') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body>

<div class="d-flex">
    <aside class="mk-admin-sidebar d-none d-lg-block" style="width: 260px; flex-shrink: 0;">
        <div class="site-logo fs-5 mb-4 px-2 d-flex align-items-center gap-2">
            <img src="{{ asset('images/favicon-32.png') }}" alt="" style="height:28px;width:auto;">
            {{ config('manbar.site_name') }}
        </div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2 ms-2"></i> لوحة التحكم
            </a>
            <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                <i class="bi bi-file-text ms-2"></i> إدارة المنشورات
            </a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags ms-2"></i> إدارة الأقسام
            </a>
            <a href="{{ route('admin.comments.index') }}" class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots ms-2"></i> التعليقات
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear ms-2"></i> الملف الشخصي
            </a>
            <hr style="border-color: var(--mk-border)">
            <a href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-left ms-2"></i> عرض الموقع</a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-link text-decoration-none w-100 text-start" style="color: var(--mk-text)">
                    <i class="bi bi-box-arrow-right ms-2"></i> تسجيل الخروج
                </button>
            </form>
        </nav>
    </aside>

    <main class="flex-grow-1 p-4">
        <div class="d-flex d-lg-none justify-content-between align-items-center mb-4">
            <span class="site-logo">{{ config('manbar.site_name') }}</span>
            <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#adminMobileMenu"><i class="bi bi-list fs-3"></i></button>
        </div>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="adminMobileMenu">
    <div class="offcanvas-body">
        <a href="{{ route('admin.dashboard') }}" class="d-block mb-3">لوحة التحكم</a>
        <a href="{{ route('admin.posts.index') }}" class="d-block mb-3">إدارة المنشورات</a>
        <a href="{{ route('admin.categories.index') }}" class="d-block mb-3">إدارة الأقسام</a>
        <a href="{{ route('admin.comments.index') }}" class="d-block mb-3">التعليقات</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
