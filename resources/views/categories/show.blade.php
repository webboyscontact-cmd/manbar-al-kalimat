@extends('layouts.app')

@section('title', $category->name)
@section('description', $category->description)

@section('content')
<section class="container py-5">
    <div class="text-center mb-5">
        <div class="category-tag mb-2" style="color: var(--mk-accent)">قسم</div>
        <h1>{{ $category->name }}</h1>
        <p style="color: var(--mk-text-muted)">{{ $category->description }}</p>
    </div>

    <div class="row g-4">
        @forelse($posts as $post)
            <div class="col-md-4">
                @include('partials.post-card', ['post' => $post])
            </div>
        @empty
            <p class="text-center text-muted">لا توجد منشورات في هذا القسم بعد.</p>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
</section>
@endsection
