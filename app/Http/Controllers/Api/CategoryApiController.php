<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Category::withCount('publishedPosts')->orderBy('order')->get()
        );
    }

    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->publishedPosts()->latest('published_at')->paginate(9);

        return response()->json([
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}
