<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\JoinSubredditAction;
use App\Actions\LeaveSubredditAction;
use App\Models\Subreddit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class SubredditController extends Controller
{
    public function create(): View
    {
        return view('components.subreddit_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:21', 'unique:subreddits', 'alpha_dash'],
            'description' => ['required', 'string', 'max:500'],
        ]);

        $user = $request->user();

        $subreddit = DB::transaction(function () use ($user, $validated) {
            $subreddit = $user->createdSubreddits()->create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'description' => $validated['description'],
            ]);

            $this->join($subreddit, app(JoinSubredditAction::class));

            return $subreddit;
        });

        // Redireciona para a página da nova comunidade
        return to_route('subreddits.show', $subreddit)->with('success', 'Comunidade criada com sucesso!');
    }

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

    public function destroy(Subreddit $subreddit)
    {
        // só o criador pode excluir
        abort_if($subreddit->created_by !== auth()->id(), 403, 'Você não tem permissão para excluir esta comunidade.');

        $subreddit->delete();

        return to_route('home')->with('success', 'Comunidade excluída com sucesso!');
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
