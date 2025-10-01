<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subreddit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

final class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View|Factory
    {
        if (Auth::check()) {
            $user = Auth::user();

            $followedSubredditIds = $user->subreddits()->pluck('subreddits.id');
            $otherPosts = collect();

            if ($followedSubredditIds->isEmpty()) {
                $posts = collect();
                $totalStats = [
                    'members' => 0,
                    'posts' => 0,
                    'comments' => 0,
                ];
                $otherPosts = Post::query()
                    ->with(['subreddit', 'user'])
                    ->latest()
                    ->take(10)
                    ->get();

            } else {
                $posts = Post::query()
                    ->whereIn('subreddit_id', $followedSubredditIds)
                    ->with(['subreddit', 'user'])
                    ->latest()
                    ->paginate(15);

                $otherPosts = Post::query()
                    ->whereNotIn('subreddit_id', $followedSubredditIds)
                    ->with(['subreddit', 'user'])
                    ->latest()
                    ->take(10)
                    ->get();

                $totalStats = [
                    'members' => (int) Subreddit::query()->whereIn('id', $followedSubredditIds)->sum('member_count'),
                    'posts' => (int) Post::query()->whereIn('subreddit_id', $followedSubredditIds)->count(),
                    'comments' => (int) Post::query()->whereIn('subreddit_id', $followedSubredditIds)->sum('comment_count'),
                ];
            }

            return view('welcome', [
                'posts' => $posts,
                'totalStats' => $totalStats,
                'otherPosts' => $otherPosts,
            ]);
        }

        $posts = Post::query()
            ->with(['subreddit', 'user'])
            ->latest()
            ->paginate(15);

        return view('welcome', [
            'posts' => $posts,
        ]);
    }
}
