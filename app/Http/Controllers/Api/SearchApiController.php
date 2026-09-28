<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchApiController extends Controller
{
    public function index(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        if ($term === '') {
            return response()->json(['data' => []]);
        }

        return response()->json(
            Post::published()->with('category')->search($term)->latest('published_at')->paginate(9)
        );
    }
}
