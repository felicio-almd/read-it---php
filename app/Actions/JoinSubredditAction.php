<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Membership;
use App\Models\Subreddit;
use App\Models\User;

final class JoinSubredditAction
{
    public function execute(Subreddit $subreddit, User $user): void
    {
        if ($subreddit->isMember($user)) {
            return;
        }

        Membership::query()->create([
            'subreddit_id' => $subreddit->id,
            'user_id' => $user->id,
            'role' => 'member',
        ]);

        $subreddit->increment('member_count');
    }
}
