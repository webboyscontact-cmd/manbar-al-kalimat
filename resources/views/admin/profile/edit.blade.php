@extends('admin.layout')

@section('title', 'الملف الشخصي')

@section('content')
<h1 class="mb-4">الملف الشخصي وكلمة المرور</h1>

<div class="mk-stat-card" style="max-width: 520px">
    <form method="POST" action="{{ route('admin.profile.update') }}">
        @csrf
        @method('PUT')

        <label class="form-label">الاسم</label>
        <input type="text" name="name" class="form-control mb-3" value="{{ old('name', auth('admin')->user()->name) }}" required>

        <label class="form-label">البريد الإلكتروني</label>
        <input type="email" name="email" class="form-control mb-4" value="{{ old('email', auth('admin')->user()->email) }}" required>

        <hr style="border-color: var(--mk-border)">
        <p class="small mb-3" style="color: var(--mk-text-muted)">اترك حقول كلمة المرور فارغة إذا كنت لا تريد تغييرها.</p>

        <label class="form-label">كلمة المرور الحالية</label>
        <input type="password" name="current_password" class="form-control mb-3" autocomplete="current-password">
        @error('current_password')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

        <label class="form-label">كلمة المرور الجديدة</label>
        <input type="password" name="password" class="form-control mb-3" autocomplete="new-password">
        @error('password')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

        <label class="form-label">تأكيد كلمة المرور الجديدة</label>
        <input type="password" name="password_confirmation" class="form-control mb-4" autocomplete="new-password">

        <button type="submit" class="mk-btn w-100">حفظ التغييرات</button>
    </form>
</div>
@endsection
