@extends('layouts.app')

@section('title', $post->title)
@section('description', $post->seo_description ?? $post->excerpt)
@if($post->cover_image)
@section('og_image', asset(\Illuminate\Support\Facades\Storage::url($post->cover_image)))
@endif

@section('content')
<section class="container py-5">
    <div class="mk-reading">
        <div class="text-center mb-4">
            <div class="category-tag mb-2">
                <a href="{{ route('categories.show', $post->category) }}" style="color: var(--mk-accent)">{{ $post->category->name }}</a>
            </div>
            <h1>{{ $post->title }}</h1>
            <div class="d-flex justify-content-center gap-3 small mt-2" style="color: var(--mk-text-muted)">
                <span><i class="bi bi-calendar3"></i> {{ optional($post->published_at)->translatedFormat('d F Y') }}</span>
                <span><i class="bi bi-eye"></i> {{ number_format($post->views) }} مشاهدة</span>
            </div>
        </div>

        @if($post->cover_image)
            <img src="{{ \Illuminate\Support\Facades\Storage::url($post->cover_image) }}" alt="{{ $post->title }}" class="cover">
        @endif

        <div class="content">
            {!! $post->content !!}
        </div>

        <div class="d-flex justify-content-between align-items-center border-top pt-4 mt-5" style="border-color: var(--mk-border) !important">
            <button class="mk-btn-outline" onclick="navigator.share ? navigator.share({title: document.title, url: window.location.href}) : window.print()">
                <i class="bi bi-share"></i> مشاركة
            </button>
            <a href="{{ route('categories.show', $post->category) }}" class="small">المزيد من {{ $post->category->name }} ←</a>
        </div>

        @if($commentsEnabled)
        <div class="mt-5">
            <h5 class="mb-3">التعليقات ({{ $post->approvedComments->count() }})</h5>

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @forelse($post->approvedComments as $comment)
                <div class="border-bottom py-3" style="border-color: var(--mk-border) !important">
                    <strong>{{ $comment->name }}</strong>
                    <p class="mb-0 small">{{ $comment->content }}</p>
                </div>
            @empty
                <p class="text-muted small">لا توجد تعليقات بعد. كن أول من يعلّق.</p>
            @endforelse

            <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="mt-4">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="الاسم" value="{{ old('name') }}" required>
                    @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="3" placeholder="اكتب تعليقك هنا..." required>{{ old('content') }}</textarea>
                    @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="mk-btn">إرسال التعليق</button>
            </form>
        </div>
        @endif
    </div>
</section>

@if($relatedPosts->isNotEmpty())
<section class="container py-5 border-top" style="border-color: var(--mk-border) !important">
    <h3 class="mb-4 text-center">منشورات مشابهة</h3>
    <div class="row g-4">
        @foreach($relatedPosts as $related)
            <div class="col-md-3">
                @include('partials.post-card', ['post' => $related])
            </div>
        @endforeach
    </div>
</section>
@endif
@endsection
