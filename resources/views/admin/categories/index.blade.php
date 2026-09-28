@extends('admin.layout')

@section('title', 'إدارة الأقسام')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">إدارة الأقسام</h1>
    <button class="mk-btn" data-bs-toggle="modal" data-bs-target="#addCategoryModal"><i class="bi bi-plus-lg"></i> إضافة قسم</button>
</div>

<div class="table-responsive mk-stat-card p-0">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>الرابط (slug)</th>
                <th>عدد المنشورات</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td class="small text-muted">{{ $category->slug }}</td>
                    <td>{{ $category->posts_count }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCategoryModal{{ $category->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('حذف هذا القسم؟');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>

                <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="modal-content">
                            @csrf @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">تعديل القسم</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <label class="form-label">الاسم</label>
                                <input type="text" name="name" class="form-control mb-3" value="{{ $category->name }}" required>
                                <label class="form-label">الوصف</label>
                                <textarea name="description" class="form-control" rows="2">{{ $category->description }}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="mk-btn">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">إضافة قسم جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">الاسم</label>
                <input type="text" name="name" class="form-control mb-3" required>
                <label class="form-label">الوصف</label>
                <textarea name="description" class="form-control" rows="2"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="mk-btn">إضافة</button>
            </div>
        </form>
    </div>
</div>
@endsection
