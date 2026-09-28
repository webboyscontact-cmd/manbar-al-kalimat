@csrf
@if($post ?? false)
    @method('PUT')
@endif

<div class="row g-4">
    <div class="col-lg-8">
        <div class="mk-stat-card mb-4">
            <label class="form-label">العنوان</label>
            <input type="text" name="title" class="form-control mb-3" value="{{ old('title', $post->title ?? '') }}" required>

            <label class="form-label">المحتوى</label>
            <div id="editor" style="min-height:320px; background:#fff; color:#111; border-radius:6px;">{!! old('content', $post->content ?? '') !!}</div>
            <textarea name="content" id="content-input" class="d-none">{{ old('content', $post->content ?? '') }}</textarea>
            @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mk-stat-card">
            <label class="form-label">مقتطف (اختياري - يُنشأ تلقائياً إن تُرك فارغاً)</label>
            <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="mk-stat-card mb-4">
            <label class="form-label">القسم</label>
            <select name="category_id" class="form-select mb-3" required>
                <option value="">اختر القسم</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? '') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')<div class="text-danger small mt-1 mb-2">{{ $message }}</div>@enderror

            <label class="form-label">صورة الغلاف</label>
            <input type="file" name="cover_image" class="form-control mb-2" accept="image/jpeg,image/png,image/webp">
            @error('cover_image')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
            @if(($post->cover_image ?? null))
                <img src="{{ \Illuminate\Support\Facades\Storage::url($post->cover_image) }}" class="img-fluid rounded mb-2">
            @endif

            <label class="form-label">الحالة</label>
            <select name="status" class="form-select">
                <option value="draft" @selected(old('status', $post->status ?? 'draft') === 'draft')>مسودة</option>
                <option value="published" @selected(old('status', $post->status ?? '') === 'published')>منشور</option>
            </select>
        </div>

        <div class="mk-stat-card mb-4">
            <label class="form-label">عنوان SEO (اختياري)</label>
            <input type="text" name="seo_title" class="form-control mb-3" value="{{ old('seo_title', $post->seo_title ?? '') }}">
            <label class="form-label">وصف SEO (اختياري)</label>
            <textarea name="seo_description" class="form-control" rows="2">{{ old('seo_description', $post->seo_description ?? '') }}</textarea>
        </div>

        <button type="submit" class="mk-btn w-100">{{ ($post ?? false) ? 'حفظ التعديلات' : 'حفظ المنشور' }}</button>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ header: [1, 2, 3, false] }],
                ['blockquote'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link'],
                ['clean']
            ]
        }
    });

    const contentInput = document.getElementById('content-input');
    document.querySelector('form').addEventListener('submit', () => {
        contentInput.value = quill.root.innerHTML;
    });
</script>
@endpush
