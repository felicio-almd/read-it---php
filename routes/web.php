<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubredditController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // posts
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{id}', [PostController::class, 'show'])->name('post.show');
    Route::post('/posts/', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/{post}/comments', [PostController::class, 'addComment'])->name('post.comments.add');

    Route::post('/posts/{post}/upvote', [VoteController::class, 'postUpvote'])->name('post.like');
    Route::post('/posts/{post}/downvote', [VoteController::class, 'postDownvote'])->name('post.deslike');
    Route::post('/comments/{comment}/upvote', [VoteController::class, 'commentUpvote'])->name('comment.like');
    Route::post('/comments/{comment}/downvote', [VoteController::class, 'commentDownvote'])->name('comment.deslike');

    Route::get('/subreddits/create', [SubredditController::class, 'create'])->name('subreddits.create');
    Route::post('/r/', [SubredditController::class, 'store'])->name('subreddits.store');
    Route::get('/r/{subreddit:slug}', [SubredditController::class, 'show'])->name('subreddits.show');
    Route::post('/r/{subreddit:slug}/join', [SubredditController::class, 'join'])->name('subreddits.join');
    Route::post('/r/{subreddit:slug}/leave', [SubredditController::class, 'leave'])->name('subreddits.leave');
});

require __DIR__.'/auth.php';
