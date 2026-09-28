@extends('layouts.app')

@section('title', 'الرئيسية')

@section('content')

    <section class="mk-hero">
        <div class="container">
            <h1>{{ config('manbar.site_tagline') }}</h1>
            <p>اقرأ، اكتشف، وتأمل في أجمل النصوص العربية</p>
            <a href="{{ route('categories.index') }}" class="mk-btn">اكتشف الكتابات</a>
        </div>
    </section>

    <section class="container py-5">
        <h2 class="mb-4 text-center">الأقسام</h2>
        <div class="row g-3">
            @foreach($categories as $category)
                <div class="col-6 col-md-3">
                    <a href="{{ route('categories.show', $category) }}" class="mk-category-card">
                        <div class="fs-5 mb-1">{{ $category->name }}</div>
                        <div class="count">{{ $category->published_posts_count ?? 0 }} منشور</div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container py-5" id="latest">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">أحدث المنشورات</h2>
        </div>
        <div class="row g-4">
            @forelse($latestPosts as $post)
                <div class="col-md-4">
                    @include('partials.post-card', ['post' => $post])
                </div>
            @empty
                <p class="text-muted">لا توجد منشورات بعد.</p>
            @endforelse
        </div>
    </section>

    @if($popularPosts->isNotEmpty())
    <section class="container py-5" id="popular">
        <h2 class="mb-4">الأكثر قراءة</h2>
        <div class="row g-4">
            @foreach($popularPosts as $post)
                <div class="col-md-4">
                    @include('partials.post-card', ['post' => $post])
                </div>
            @endforeach
        </div>
    </section>
    @endif

@endsection
