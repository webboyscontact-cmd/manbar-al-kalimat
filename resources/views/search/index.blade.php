@extends('layouts.app')

@section('title', 'بحث')

@section('content')
<section class="container py-5">
    <div class="text-center mb-5">
        <h1 class="mb-4">البحث</h1>
        <form method="GET" action="{{ route('search') }}" class="mx-auto" style="max-width: 560px">
            <div class="input-group input-group-lg">
                <input type="text" name="q" class="form-control" placeholder="ابحث عن قصيدة، خاطرة، قصة..." value="{{ $term }}" autofocus>
                <button class="btn mk-btn" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>

    @if($results !== null)
        <p class="text-center mb-4" style="color: var(--mk-text-muted)">
            {{ $results->total() }} نتيجة عن "{{ $term }}"
        </p>

        <div class="row g-4">
            @forelse($results as $post)
                <div class="col-md-4">
                    @include('partials.post-card', ['post' => $post])
                </div>
            @empty
                <p class="text-center text-muted">لم يتم العثور على نتائج مطابقة.</p>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $results->links() }}
        </div>
    @endif
</section>
@endsection
