<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Post::with('category')->latest()->paginate(15)
        );
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = $request->user()->id;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->storeAs('covers', Str::uuid().'.'.$request->file('cover_image')->getClientOriginalExtension(), 'public');
        }

        $post = Post::create($data);

        return response()->json($post, 201);
    }

    public function show(Post $post)
    {
        return response()->json($post->load('category'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')
                ->storeAs('covers', Str::uuid().'.'.$request->file('cover_image')->getClientOriginalExtension(), 'public');
        }

        $post->update($data);

        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }
        $post->delete();

        return response()->json(['message' => 'تم حذف المنشور.']);
    }
}
