@extends('admin.layout')

@section('title', 'تعديل منشور')

@section('content')
<h1 class="mb-4">تعديل: {{ $post->title }}</h1>

<form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
    @include('admin.posts._form')
</form>
@endsection
