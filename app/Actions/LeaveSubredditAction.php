<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Membership;
use App\Models\Subreddit;
use App\Models\User;

final class LeaveSubredditAction
{
    public function execute(Subreddit $subreddit, User $user): void
    {
        if (! $subreddit->isMember($user)) {
            return;
        }

        $membership = Membership::query()
            ->where('subreddit_id', $subreddit->id)
            ->where('user_id', $user->id)
            ->first();

        if ($membership) {
            $membership->delete();
            $subreddit->decrement('member_count');
        }
    }
}
