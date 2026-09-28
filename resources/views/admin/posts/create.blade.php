@extends('admin.layout')

@section('title', 'إضافة منشور جديد')

@section('content')
<h1 class="mb-4">إضافة منشور جديد</h1>

<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
    @php($post = null)
    @include('admin.posts._form')
</form>
@endsection
