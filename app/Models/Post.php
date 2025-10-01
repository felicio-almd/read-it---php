<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Votable;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

final class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    use HasUuids;
    use Votable;

    protected $fillable = [
        'title',
        'content',
        'content_type',
        'url',
        'image_path',
        'user_id',
        'subreddit_id',
        'upvotes',
        'downvotes',
        'score',
        'is_pinned',
        'is_locked',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo<Subreddit, $this>
     */
    public function subreddit(): BelongsTo
    {
        return $this->belongsTo(Subreddit::class);
    }

    /**
     * @return HasMany<Comment, $this>
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return MorphMany<Vote, $this>
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    public function getCurrentUserVote(): ?string
    {
        if (! auth()->check()) {
            return null;
        }

        return $this->votes()
            ->where('user_id', auth()->id())
            ->value('vote_type');
    }

    protected function getScoreAttribute(): int
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }

    protected function getCommentCountAttribute(): int
    {
        return $this->comments()->count();
    }
}
