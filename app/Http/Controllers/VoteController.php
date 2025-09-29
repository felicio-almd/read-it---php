<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\VoteOnPostAction;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

final class VoteController extends Controller
{
    public function __construct(private readonly VoteOnPostAction $voteAction) {}

    /**
     * Upvote em um post
     */
    public function postUpvote(string $id): RedirectResponse
    {
        return $this->handleVote(Post::class, $id, 'up');
    }

    /**
     * Downvote em um post
     */
    public function postDownvote(string $id): RedirectResponse
    {
        return $this->handleVote(Post::class, $id, 'down');
    }

    /**
     * Upvote em um comentário
     */
    public function commentUpvote(string $id): RedirectResponse
    {
        return $this->handleVote(Comment::class, $id, 'up');
    }

    /**
     * Downvote em um comentário
     */
    public function commentDownvote(string $id): RedirectResponse
    {
        return $this->handleVote(Comment::class, $id, 'down');
    }

    /**
     * Lógica centralizada de votação
     */
    private function handleVote(string $modelClass, string $id, string $voteType): RedirectResponse
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->back()->with('error', 'Faça login para votar');
        }

        $votable = $modelClass::findOrFail($id);

        $currentVote = $votable->votes()
            ->where('user_id', $user->id)
            ->first();

        // Se já votou no mesmo tipo, remove o voto; senão, registra o voto
        $newVote = $currentVote?->vote_type === $voteType ? null : $voteType;

        $this->voteAction->execute($votable, $user, $newVote);

        $message = $this->getVoteMessage($newVote, $voteType);

        return redirect()->back()->with('success', $message);
    }

    /**
     * Retorna mensagem apropriada baseada na ação
     */
    private function getVoteMessage(?string $newVote, string $voteType): string
    {
        if ($newVote === null) {
            return 'Voto removido com sucesso';
        }

        return $voteType === 'up' ? 'Like registrado!' : 'Deslike registrado!';
    }
}
