<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')->orderBy('order')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());

        return back()->with('status', 'تمت إضافة القسم.');
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return back()->with('status', 'تم تحديث القسم.');
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return back()->withErrors(['category' => 'لا يمكن حذف قسم يحتوي على منشورات.']);
        }

        $category->delete();

        return back()->with('status', 'تم حذف القسم.');
    }
}
