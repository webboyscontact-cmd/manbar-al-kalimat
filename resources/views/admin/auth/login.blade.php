<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | {{ config('manbar.site_name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@700&family=Noto+Kufi+Arabic:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css'])
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height:100vh; background: var(--mk-bg)">
    <div class="p-4 p-md-5 rounded" style="max-width: 420px; width: 100%; background: var(--mk-surface); border: 1px solid var(--mk-border)">
        <div class="text-center mb-4">
            <img src="{{ asset('images/favicon-48.png') }}" alt="" style="height:56px;width:auto;" class="mb-2">
            <div class="site-logo fs-3">{{ config('manbar.site_name') }}</div>
            <p class="small" style="color: var(--mk-text-muted)">تسجيل الدخول إلى لوحة التحكم</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger small">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.attempt') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" required autofocus value="{{ old('email') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small" for="remember">تذكرني</label>
            </div>
            <button type="submit" class="mk-btn w-100">تسجيل الدخول</button>
        </form>
    </div>
</body>
</html>
