@extends('layouts.app')

@section('title', 'الأقسام')

@section('content')
<section class="container py-5">
    <h1 class="mb-5 text-center">الأقسام</h1>

    <div class="row g-4">
        @foreach($categories as $category)
            <div class="col-md-4 col-6">
                <a href="{{ route('categories.show', $category) }}" class="mk-category-card">
                    <div class="fs-4 mb-2">{{ $category->name }}</div>
                    <p class="small mb-2" style="color: var(--mk-text-muted)">{{ $category->description }}</p>
                    <div class="count">{{ $category->published_posts_count }} منشور</div>
                </a>
            </div>
        @endforeach
    </div>
</section>
@endsection
