<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subreddit;
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
    public function create(): View
    {
        // Busca todos os subreddits dos quais o usuário autenticado é membro
        // para popular o <select> no formulário.
        $subreddits = auth()->user()->subreddits()->get();

        // Retorna a view do formulário, passando a lista de subreddits.
        return view('components.post_create', [
            'subreddits' => $subreddits,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida os dados recebidos do formulário.
        $validated = $request->validate([
            'subreddit_id' => ['required', 'exists:subreddits,id'],
            'title' => ['required', 'string', 'max:300'],
            'content' => ['required', 'string'],
            'content_type' => ['required'],
            'url' => ['required'],
            'image_path' => ['required'],
        ]);

        $subreddit = Subreddit::query()->findOrFail($validated['subreddit_id']);

        // Cria o post associado ao subreddit e ao usuário logado.
        // O slug será gerado automaticamente pelo model event.
        $post = $subreddit->posts()->create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'content_type' => 'text', // Define um tipo padrão
        ]);

        // Redireciona o usuário para a página do post recém-criado com uma mensagem de sucesso.
        return to_route('posts.show', $post)->with('success', 'Post criado com sucesso!');
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
