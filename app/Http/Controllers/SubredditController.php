<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use App\Actions\JoinSubredditAction;
use App\Actions\LeaveSubredditAction;
use App\Models\Subreddit;

final class SubredditController extends Controller
{
    public function show(Subreddit $subreddit): View|Factory
    {
        $posts = $subreddit->posts()
            ->with(['user', 'subreddit'])
            ->latest()
            ->paginate(15);

        return view('components.subreddit', [
            'subreddit' => $subreddit,
            'posts' => $posts,
        ]);
    }

    public function join(Subreddit $subreddit, JoinSubredditAction $joinAction)
    {
        $joinAction->execute($subreddit, auth()->user());

        return back()->with('success', 'Você agora é membro da comunidade r/'.$subreddit->name);
    }

    public function leave(Subreddit $subreddit, LeaveSubredditAction $leaveAction)
    {
        $leaveAction->execute($subreddit, auth()->user());

        return back()->with('success', 'Você saiu da comunidade r/'.$subreddit->name);
    }
}
