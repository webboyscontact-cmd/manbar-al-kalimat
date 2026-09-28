<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function show(Request $request, Post $post)
    {
        abort_unless(
            $post->status === 'published' || auth('admin')->check(),
            404
        );

        // عدّاد مشاهدات بسيط: مرة واحدة لكل جلسة زائر لكل منشور
        $viewedKey = 'viewed_post_'.$post->id;
        if (! $request->session()->has($viewedKey)) {
            $post->incrementViews();
            $request->session()->put($viewedKey, true);
        }

        $post->load(['category', 'approvedComments']);

        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        $commentsEnabled = (bool) config('manbar.comments_enabled', true);

        return view('posts.show', compact('post', 'relatedPosts', 'commentsEnabled'));
    }

    public function storeComment(Request $request, Post $post)
    {
        abort_unless(config('manbar.comments_enabled', true), 404);

        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:100'],
                'content' => ['required', 'string', 'max:2000'],
            ], [
                'name.required' => 'الاسم مطلوب.',
                'content.required' => 'الرجاء كتابة تعليقك.',
            ]);
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }

        Comment::create([
            'post_id' => $post->id,
            'name' => strip_tags($validated['name']),
            'content' => strip_tags($validated['content']),
            'status' => 'pending', // بانتظار موافقة المدير
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'تم إرسال تعليقك وسيظهر بعد مراجعته.');
    }
}
