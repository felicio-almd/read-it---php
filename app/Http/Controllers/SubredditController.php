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
            // Regra 'alpha_dash' permite apenas letras, números, traços e underscores.
            'name' => ['required', 'string', 'max:21', 'unique:subreddits', 'alpha_dash'],
            'description' => ['required', 'string', 'max:500'],
        ]);

        $user = $request->user();

        // Usa uma transação para garantir que ambas as operações (criar subreddit e adicionar membro)
        // aconteçam com sucesso ou falhem juntas.
        $subreddit = DB::transaction(function () use ($user, $validated) {
            // Cria o subreddit
            $subreddit = $user->createdSubreddits()->create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']), // Gera o slug a partir do nome
                'description' => $validated['description'],
            ]);

            // Adiciona o criador como o primeiro membro e o define como moderador.
            $subreddit->members()->attach($user->id, ['role' => 'moderator']);
            $subreddit->increment('member_count');

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
