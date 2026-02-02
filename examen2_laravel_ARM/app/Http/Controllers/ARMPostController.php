<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ARMPostController extends Controller
{
    /**
     * Display a listing of posts with their comments and authors using eager loading.
     */
    public function index()
    {
        // Eager load user (author) and comments with their users (comment authors)
        $posts = Post::with(['user', 'comments.user'])
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Display the specified post with comments and authors using eager loading.
     */
    public function show(Post $post)
    {
        // Eager load user and comments with their users
        $post->load(['user', 'comments.user']);

        return view('posts.show', compact('post'));
    }
}
