<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'drafts' => Post::where('status', 'draft')->count(),
            'views' => Post::sum('views'),
            'categories' => Category::count(),
        ];

        // مشاهدات آخر 14 يوماً (تقديرية بالاعتماد على تاريخ آخر تعديل للمنشورات المنشورة)
        $viewsByDay = Post::selectRaw('DATE(published_at) as day, SUM(views) as total_views')
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '>=', now()->subDays(14))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $recentPosts = Post::with('category')->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'viewsByDay', 'recentPosts'));
    }
}
