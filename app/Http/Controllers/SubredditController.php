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
        return view('components.subreddit-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:21', 'unique:subreddits', 'alpha_dash'],
            'slug' => ['required', 'string', 'max:50', 'unique:subreddits,slug', 'alpha_dash'],
            'description' => ['required', 'string', 'max:500'],
            'rules' => ['nullable', 'string', 'max:1000'],
            'banner_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'icon_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:1024'],
        ]);

        $user = $request->user();

        $subreddit = DB::transaction(function () use ($user, $validated, $request) {
            $subreddit = $user->createdSubreddits()->create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['slug']),
                'description' => $validated['description'],
                'rules' => $validated['rules'] ?? null,
            ]);

            // Upload das imagens (armazenando em storage/app/public/subreddits)
            if ($request->hasFile('banner_image')) {
                $path = $request->file('banner_image')->store('subreddits/banners', 'public');
                $subreddit->update(['banner_image' => $path]);
            }

            if ($request->hasFile('icon_image')) {
                $path = $request->file('icon_image')->store('subreddits/icons', 'public');
                $subreddit->update(['icon_image' => $path]);
            }

            $this->join($subreddit, app(JoinSubredditAction::class));

            return $subreddit;
        });

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
