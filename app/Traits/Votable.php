<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Vote;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Votable
{
    /**
     * @return MorphMany<Vote, $this>
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function upvotes(): MorphMany
    {
        return $this->votes()->where('vote_type', 'up');
    }

    public function downvotes(): MorphMany
    {
        return $this->votes()->where('vote_type', 'down');
    }

    public function recalculateVotes(): void
    {
        // Usa o método loadCount do Eloquent para contar os votos de cada tipo
        // de forma eficiente em uma única consulta.
        $this->loadCount([
            'votes as upvotes_count' => fn ($query) => $query->where('vote_type', 'up'),
            'votes as downvotes_count' => fn ($query) => $query->where('vote_type', 'down'),
        ]);

        // Atualiza as colunas do model com os novos valores
        $this->upvotes = $this->upvotes_count;
        $this->downvotes = $this->downvotes_count;
        $this->score = $this->upvotes - $this->downvotes;

        // Salva as alterações no banco de dados sem disparar outros eventos
        $this->saveQuietly();
    }

    protected function getVotesCountAttribute(): int
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }

    protected function getUserVoteAttribute(): ?string
    {
        if (! auth()->check()) {
            return null;
        }

        return $this->votes()
            ->where('user_id', auth()->id())
            ->value('vote_type');
    }
}
