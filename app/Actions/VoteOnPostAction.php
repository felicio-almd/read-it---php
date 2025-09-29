<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Model;

final class VoteOnPostAction
{
    public function execute(Model $votable, User $user, ?string $voteType): void
    {
        $vote = Vote::query()->where([
            'user_id' => $user->id,
            'votable_type' => $votable::class,
            'votable_id' => $votable->id,
        ]);

        if ($voteType === null) {
            $vote->delete();

            return;
        }

        $vote->vote_type = $voteType;
        $vote->save();
    }
}
