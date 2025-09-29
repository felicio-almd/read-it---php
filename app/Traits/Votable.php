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
