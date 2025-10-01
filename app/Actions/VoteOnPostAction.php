<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

final class VoteOnPostAction
{
    public function execute(Post|Comment $votable, User $user, string $voteType): void
    {
        $existingVote = $votable->votes()
            ->where('user_id', $user->id)
            ->first();

        if ($existingVote) {
            if ($existingVote->vote_type === $voteType) {
                $existingVote->delete();
            } else {
                $existingVote->update(['vote_type' => $voteType]);
            }
        } else {
            $votable->votes()->create([
                'user_id' => $user->id,
                'vote_type' => $voteType,
            ]);
        }

        // Se o model (Post/Comment) tiver o método da Trait, recalcula os scores
        $votable->recalculateVotes();
    }
}
