<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category')->latest();

        if ($status = $request->query('status')) {
            if (in_array($status, ['draft', 'published'], true)) {
                $query->where('status', $status);
            }
        }

        if ($categoryId = $request->query('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($term = trim((string) $request->query('q', ''))) {
            $query->where('title', 'like', "%{$term}%");
        }

        $posts = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('order')->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('order')->get();

        return view('admin.posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['content'] = $this->sanitizeHtml($data['content']);
        $data['admin_id'] = auth('admin')->id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->storeCoverImage($request->file('cover_image'));
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('status', 'تم حفظ المنشور بنجاح.');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('order')->get();

        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['content'] = $this->sanitizeHtml($data['content']);

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $data['cover_image'] = $this->storeCoverImage($request->file('cover_image'));
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('status', 'تم تحديث المنشور بنجاح.');
    }

    public function destroy(Post $post)
    {
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }
        $post->delete();

        return back()->with('status', 'تم حذف المنشور.');
    }

    /**
     * تبديل سريع بين "منشور" و"مسودة" من جدول الإدارة.
     */
    public function toggleStatus(Post $post)
    {
        $post->status = $post->status === 'published' ? 'draft' : 'published';
        $post->save();

        return back()->with('status', 'تم تحديث حالة المنشور.');
    }

    private function storeCoverImage($file): string
    {
        $filename = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();

        return $file->storeAs('covers', $filename, 'public');
    }

    /**
     * ينظّف محتوى HTML القادم من المحرر الغني، ويسمح فقط بوسوم آمنة
     * (فقرات، عناوين، تشديد، مائل، اقتباسات، قوائم، روابط)، حماية من XSS.
     */
    private function sanitizeHtml(string $html): string
    {
        $allowedTags = '<p><br><strong><b><em><i><u><h1><h2><h3><h4><blockquote><ul><ol><li><a>';
        $clean = strip_tags($html, $allowedTags);

        // إزالة أي خاصية غير href من وسوم <a>، ومنع أي بروتوكول غير http(s)
        $clean = preg_replace_callback('/<a\s+[^>]*href="([^"]*)"[^>]*>/i', function ($m) {
            $href = $m[1];
            if (! preg_match('/^https?:\/\//i', $href)) {
                return '<a>';
            }

            return '<a href="'.e($href).'" target="_blank" rel="noopener noreferrer">';
        }, $clean);

        // إزالة أي معالجات أحداث JS متبقية (onclick=, onerror=...)
        $clean = preg_replace('/\son\w+="[^"]*"/i', '', $clean);

        return $clean;
    }
}
