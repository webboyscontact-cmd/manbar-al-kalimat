<?php

use App\Http\Controllers\Api\Admin\CategoryApiController as AdminCategoryApi;
use App\Http\Controllers\Api\Admin\PostApiController as AdminPostApi;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\SearchApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API عامة (بدون مصادقة) - يمكن استخدامها من واجهة React منفصلة
|--------------------------------------------------------------------------
*/

Route::get('/posts', [PostApiController::class, 'index']);
Route::get('/posts/{slug}', [PostApiController::class, 'show']);

Route::get('/categories', [CategoryApiController::class, 'index']);
Route::get('/categories/{slug}', [CategoryApiController::class, 'show']);

Route::get('/search', [SearchApiController::class, 'index']);

Route::post('/admin/login', [AuthApiController::class, 'login']);

/*
|--------------------------------------------------------------------------
| API الإدارة (محمية بـ Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/me', [AuthApiController::class, 'me']);

    Route::apiResource('posts', AdminPostApi::class)->except(['show'])->names('api.admin.posts');
    Route::get('/posts/{post}', [AdminPostApi::class, 'show']);

    Route::apiResource('categories', AdminCategoryApi::class)->only(['index', 'store', 'update', 'destroy'])->names('api.admin.categories');
});
