<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('publishedPosts')->orderBy('order')->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $posts = $category->publishedPosts()
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('categories.show', compact('category', 'posts'));
    }
}
