<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoteController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/dashboard', fn (): View|Factory => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // posts
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.show');
    Route::post('/posts/{post}/comments', [PostController::class, 'addComment'])->name('post.comments.add');

    Route::post('/posts/{post}/upvote', [VoteController::class, 'postUpvote'])->name('post.like');
    Route::post('/posts/{post}/downvote', [VoteController::class, 'postDownvote'])->name('post.deslike');
    Route::post('/comments/{comment}/upvote', [VoteController::class, 'commentUpvote'])->name('comment.like');
    Route::post('/comments/{comment}/downvote', [VoteController::class, 'commentDownvote'])->name('comment.deslike');
});

require __DIR__.'/auth.php';
