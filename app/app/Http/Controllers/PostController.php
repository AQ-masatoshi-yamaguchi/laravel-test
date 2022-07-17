<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): Factory|View|Application
    {
        $posts = Post::with('user')
            ->withCount('comments')
            ->onlyOpen()
            ->where('status', Post::OPEN)
            ->orderByDesc('comments_count')
            ->get();

        return view('index', compact('posts'));
    }

    /**
     * @param \App\Models\Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
     */
    public function show(Post $post): Factory|View|Application
    {
        if($post->isClosed()) {
            abort(403);
        }

        return view('posts.show', compact('post'));
    }
}
