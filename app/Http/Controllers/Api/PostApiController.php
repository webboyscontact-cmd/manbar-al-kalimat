<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::published()->with('category');

        if ($categorySlug = $request->query('category')) {
            $query->whereHas('category', fn ($c) => $c->where('slug', $categorySlug));
        }

        if ($request->query('popular') === '1') {
            $query->mostViewed();
        } else {
            $query->latest('published_at');
        }

        return response()->json(
            $query->paginate($request->integer('per_page', 9))
        );
    }

    public function show(string $slug)
    {
        $post = Post::published()->with(['category', 'approvedComments'])
            ->where('slug', $slug)
            ->firstOrFail();

        $post->incrementViews();

        return response()->json($post);
    }
}
