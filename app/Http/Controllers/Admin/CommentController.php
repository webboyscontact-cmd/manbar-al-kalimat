<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('post')->latest()->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return back()->with('status', 'تمت الموافقة على التعليق.');
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return back()->with('status', 'تم رفض التعليق.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('status', 'تم حذف التعليق.');
    }
}
