<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class SitemapController extends Controller
{
    public function sitemap()
    {
        $posts = Post::published()->select('slug', 'updated_at')->latest('updated_at')->get();
        $categories = Category::select('slug', 'updated_at')->get();

        $xml = view('sitemap', compact('posts', 'categories'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /admin/\n";
        $content .= "\n";
        $content .= 'Sitemap: '.route('sitemap')."\n";

        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
