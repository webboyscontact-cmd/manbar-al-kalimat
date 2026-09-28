@extends('admin.layout')

@section('title', 'لوحة التحكم')

@section('content')
<h1 class="mb-4">لوحة التحكم</h1>

<div class="row g-3 mb-5">
    <div class="col-6 col-md-3">
        <div class="mk-stat-card">
            <div class="value">{{ number_format($stats['total']) }}</div>
            <div class="label">إجمالي المنشورات</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mk-stat-card">
            <div class="value">{{ number_format($stats['published']) }}</div>
            <div class="label">المنشورات المنشورة</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mk-stat-card">
            <div class="value">{{ number_format($stats['drafts']) }}</div>
            <div class="label">المسودات</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mk-stat-card">
            <div class="value">{{ number_format($stats['views']) }}</div>
            <div class="label">إجمالي المشاهدات</div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="mk-stat-card">
            <h6 class="mb-3">المشاهدات خلال آخر 14 يوماً</h6>
            <canvas id="viewsChart" height="140"></canvas>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="mk-stat-card">
            <h6 class="mb-3">أحدث المنشورات</h6>
            @foreach($recentPosts as $post)
                <div class="d-flex justify-content-between border-bottom py-2" style="border-color: var(--mk-border) !important">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="small text-truncate" style="max-width: 200px">{{ $post->title }}</a>
                    <span class="badge {{ $post->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $post->status === 'published' ? 'منشور' : 'مسودة' }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('viewsChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($viewsByDay->pluck('day')) !!},
            datasets: [{
                label: 'المشاهدات',
                data: {!! json_encode($viewsByDay->pluck('total_views')) !!},
                borderColor: '#8a5a3b',
                backgroundColor: 'rgba(138,90,59,.15)',
                tension: .3,
                fill: true,
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
</script>
@endpush
@endsection
