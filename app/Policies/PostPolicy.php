<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Post;
use App\Models\Subreddit;
use App\Models\User;

final class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Subreddit $subreddit): bool
    {
        return $subreddit->isMember($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post, Subreddit $subreddit): bool
    {
        return $user->id === $post->user_id || $subreddit->isModerator($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post, Subreddit $subreddit): bool
    {
        return $this->update($user, $post, $subreddit);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(): bool
    {
        return false;
    }
}
