@extends('admin.layout')

@section('title', 'التعليقات')

@section('content')
<h1 class="mb-4">إدارة التعليقات</h1>

<div class="table-responsive mk-stat-card p-0">
    <table class="table align-middle mb-0">
        <thead>
            <tr>
                <th>الاسم</th>
                <th>التعليق</th>
                <th>المنشور</th>
                <th>الحالة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $comment)
                <tr>
                    <td>{{ $comment->name }}</td>
                    <td class="small" style="max-width:280px">{{ \Illuminate\Support\Str::limit($comment->content, 80) }}</td>
                    <td class="small">{{ $comment->post->title ?? '-' }}</td>
                    <td>
                        <span class="badge {{ ['pending'=>'bg-warning text-dark','approved'=>'bg-success','rejected'=>'bg-danger'][$comment->status] }}">
                            {{ ['pending'=>'قيد المراجعة','approved'=>'مقبول','rejected'=>'مرفوض'][$comment->status] }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if($comment->status !== 'approved')
                                <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-success"><i class="bi bi-check-lg"></i></button>
                                </form>
                            @endif
                            @if($comment->status !== 'rejected')
                                <form method="POST" action="{{ route('admin.comments.reject', $comment) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-warning"><i class="bi bi-x-lg"></i></button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" onsubmit="return confirm('حذف هذا التعليق؟');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">لا توجد تعليقات.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $comments->links() }}
</div>
@endsection
