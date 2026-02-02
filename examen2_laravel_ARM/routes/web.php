<?php

use App\Http\Controllers\ARMPostController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $posts = Post::with(['user', 'comments.user'])->latest()->get();
    return view('posts.all', compact('posts'));
})->name('home');

// Blog ARM routes with eager loading
Route::get('/posts', [ARMPostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [ARMPostController::class, 'show'])->name('posts.show');
