<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostListController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->withCount('comments')
            ->onlyOpen()
            ->where('status', Post::OPEN)
            ->orderByDesc('comments_count')
            ->get();

        return view('index', compact('posts'));
    }
}
