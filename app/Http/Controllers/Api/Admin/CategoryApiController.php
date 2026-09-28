<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        return response()->json(Category::withCount('posts')->orderBy('order')->get());
    }

    public function store(StoreCategoryRequest $request)
    {
        return response()->json(Category::create($request->validated()), 201);
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        if ($category->posts()->exists()) {
            return response()->json(['message' => 'لا يمكن حذف قسم يحتوي على منشورات.'], 422);
        }

        $category->delete();

        return response()->json(['message' => 'تم حذف القسم.']);
    }
}
