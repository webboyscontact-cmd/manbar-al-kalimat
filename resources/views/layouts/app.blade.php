<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('manbar.site_name')) | {{ config('manbar.site_name') }}</title>
    <meta name="description" content="@yield('description', config('manbar.site_tagline'))">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:site_name" content="{{ config('manbar.site_name') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('manbar.site_name'))">
    <meta property="og:description" content="@yield('description', config('manbar.site_tagline'))">
    <meta property="og:image" content="@yield('og_image', asset('images/favicon-512.png'))">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Noto+Kufi+Arabic:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicon-180.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @vite(['resources/css/app.css'])
    @stack('styles')

    <script>
        // تطبيق الوضع الليلي المحفوظ قبل عرض الصفحة لتفادي الوميض
        if (localStorage.getItem('mk-theme') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    </script>
</head>
<body>

<header class="mk-header">
    <div class="container d-flex align-items-center justify-content-between flex-wrap gap-2">
        <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center gap-2">
            <img src="{{ asset('images/favicon-48.png') }}" alt="{{ config('manbar.site_name') }}" style="height:42px; width:auto;">
            <span class="site-logo">{{ config('manbar.site_name') }}
                <small>{{ config('manbar.site_tagline') }}</small>
            </span>
        </a>

        <nav class="mk-nav d-none d-lg-flex align-items-center">
            <a href="{{ route('home') }}">الرئيسية</a>
            <a href="{{ route('categories.index') }}">الأقسام</a>
            <a href="{{ route('home') }}#latest">أحدث المنشورات</a>
            <a href="{{ route('home') }}#popular">الأكثر قراءة</a>
        </nav>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('search') }}" class="mk-icon-btn" title="بحث">
                <i class="bi bi-search"></i>
            </a>
            <button type="button" class="mk-icon-btn" id="theme-toggle" title="الوضع الليلي">
                <i class="bi bi-moon-stars"></i>
            </button>
            <button class="btn d-lg-none border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <i class="bi bi-list fs-3"></i>
            </button>
        </div>
    </div>
</header>

<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
        <h5 class="site-logo">{{ config('manbar.site_name') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <a href="{{ route('home') }}" class="d-block mb-3">الرئيسية</a>
        <a href="{{ route('categories.index') }}" class="d-block mb-3">الأقسام</a>
        <a href="{{ route('search') }}" class="d-block mb-3">بحث</a>
    </div>
</div>

<main>
    @yield('content')
</main>

<footer class="mk-footer">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5 class="site-logo mb-2">{{ config('manbar.site_name') }}</h5>
                <p class="small">{{ config('manbar.site_tagline') }}</p>
            </div>
            <div class="col-md-4">
                <h6 class="mb-3">الأقسام</h6>
                @foreach(\App\Models\Category::orderBy('order')->take(6)->get() as $footerCategory)
                    <a href="{{ route('categories.show', $footerCategory) }}" class="d-block small mb-1">{{ $footerCategory->name }}</a>
                @endforeach
            </div>
            <div class="col-md-4">
                <h6 class="mb-3">روابط</h6>
                <a href="{{ route('home') }}" class="d-block small mb-1">الرئيسية</a>
                <a href="{{ route('search') }}" class="d-block small mb-1">البحث</a>
                <a href="{{ route('admin.login') }}" class="d-block small mb-1">لوحة التحكم</a>
            </div>
        </div>
        <hr class="my-4" style="border-color: var(--mk-border)">
        <p class="small text-center mb-0">© {{ date('Y') }} {{ config('manbar.site_name') }} - جميع الحقوق محفوظة.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const themeBtn = document.getElementById('theme-toggle');
    const root = document.documentElement;

    function updateIcon() {
        const isDark = root.getAttribute('data-theme') === 'dark';
        themeBtn.innerHTML = isDark ? '<i class="bi bi-sun"></i>' : '<i class="bi bi-moon-stars"></i>';
    }

    themeBtn?.addEventListener('click', () => {
        const isDark = root.getAttribute('data-theme') === 'dark';
        root.setAttribute('data-theme', isDark ? 'light' : 'dark');
        localStorage.setItem('mk-theme', isDark ? 'light' : 'dark');
        updateIcon();
    });

    updateIcon();
</script>
@stack('scripts')
</body>
</html>
