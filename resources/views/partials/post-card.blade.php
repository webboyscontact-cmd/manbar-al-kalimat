<div class="mk-post-card">
    @if($post->cover_image)
        <img src="{{ \Illuminate\Support\Facades\Storage::url($post->cover_image) }}" alt="{{ $post->title }}">
    @else
        <img src="https://placehold.co/600x400/eee8de/8a5a3b?text={{ urlencode($post->category->name ?? '') }}" alt="{{ $post->title }}">
    @endif
    <div class="body">
        <div class="category-tag">{{ $post->category->name ?? '' }}</div>
        <h3><a href="{{ route('posts.show', $post) }}" class="text-decoration-none" style="color: inherit">{{ $post->title }}</a></h3>
        <p class="excerpt">{{ $post->excerpt }}</p>
        <div class="meta">
            <span><i class="bi bi-calendar3"></i> {{ optional($post->published_at)->translatedFormat('d F Y') }}</span>
            <span><i class="bi bi-eye"></i> {{ number_format($post->views) }}</span>
        </div>
        <a href="{{ route('posts.show', $post) }}" class="mk-btn-outline mt-3 text-center">اقرأ المزيد</a>
    </div>
</div>
