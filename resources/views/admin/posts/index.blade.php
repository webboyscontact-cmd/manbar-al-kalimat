@extends('admin.layout')

@section('title', 'إدارة المنشورات')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1 class="mb-0">إدارة المنشورات</h1>
    <a href="{{ route('admin.posts.create') }}" class="mk-btn"><i class="bi bi-plus-lg"></i> إضافة منشور</a>
</div>

<form method="GET" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="q" class="form-control" placeholder="بحث بالعنوان..." value="{{ request('q') }}">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">جميع المنشورات</option>
            <option value="published" @selected(request('status')==='published')>منشور</option>
            <option value="draft" @selected(request('status')==='draft')>مسودة</option>
        </select>
    </div>
    <div class="col-md-3">
        <select name="category_id" class="form-select" onchange="this.form.submit()">
            <option value="">كل الأقسام</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-outline-secondary w-100" type="submit">بحث</button>
    </div>
</form>

<div class="table-responsive mk-stat-card p-0">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th>الصورة</th>
                <th>العنوان</th>
                <th>القسم</th>
                <th>الحالة</th>
                <th>المشاهدات</th>
                <th>التاريخ</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
                <tr>
                    <td>
                        @if($post->cover_image)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($post->cover_image) }}" style="width:50px;height:50px;object-fit:cover;border-radius:4px">
                        @else
                            <div style="width:50px;height:50px;background:var(--mk-border);border-radius:4px"></div>
                        @endif
                    </td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category->name ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $post->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $post->status === 'published' ? 'منشور' : 'مسودة' }}
                        </span>
                    </td>
                    <td>{{ number_format($post->views) }}</td>
                    <td class="small">{{ $post->created_at->format('Y-m-d') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('posts.show', $post) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="مشاهدة"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-primary" title="تعديل"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.posts.toggle-status', $post) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-warning" title="{{ $post->status === 'published' ? 'نقل لمسودة' : 'نشر' }}">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنشور؟');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="حذف"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">لا توجد منشورات مطابقة.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $posts->links() }}
</div>
@endsection
