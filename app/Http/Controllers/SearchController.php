<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $term = trim((string) $request->query('q', ''));

        $results = $term !== ''
            ? Post::published()->with('category')->search($term)->latest('published_at')->paginate(9)->withQueryString()
            : null;

        return view('search.index', compact('term', 'results'));
    }
}
