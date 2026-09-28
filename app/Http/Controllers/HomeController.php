<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $latestPosts = Post::published()
            ->with('category')
            ->latest('published_at')
            ->take(9)
            ->get();

        $popularPosts = Post::published()
            ->with('category')
            ->mostViewed()
            ->take(5)
            ->get();

        $categories = Category::withCount('publishedPosts')->orderBy('order')->get();

        return view('home.index', compact('latestPosts', 'popularPosts', 'categories'));
    }
}
