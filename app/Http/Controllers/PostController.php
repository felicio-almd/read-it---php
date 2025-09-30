<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View|Factory
    {
        $post = Post::with(['user', 'subreddit', 'comments.user'])
            ->where('id', $id)
            ->firstOrFail();

        if (! $post->subreddit) {
            $post->subreddit = (object) ['name' => 'subreddit-deletado'];
        }

        return view('components.post', ['post' => $post]);
    }

    /**
     * Armazena um novo comentário no banco de dados.
     */
    public function addComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:5000'],
            'parent_id' => ['nullable', 'exists:comments,id'],
        ]);

        $post->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
            'parent_id' => $validated['parent_id'] ?? null,
        ]);

        // ja incrementa no banco pela função feita na model

        return back()->with('success', 'Seu comentário foi publicado!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        //
    }
}
