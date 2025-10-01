<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Votable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

final class Comment extends Model
{
    use HasUuids;
    use Votable;

    protected $fillable = [
        'content',
        'user_id',
        'post_id',
        'parent_id',
        'upvotes',
        'downvotes',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany<Vote, $this>
     */
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    /**
     * @return BelongsTo<Post, $this>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * @return BelongsTo<Comment, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany<Comment, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return Collection<int, static>
     */
    public function getAncestors(): Collection
    {
        $parentIds = explode('.', (string) $this->path);

        array_pop($parentIds);

        if ($parentIds === []) {
            return collect();
        }

        return self::query()
            ->whereIn('id', $parentIds)
            ->orderBy('depth')
            ->get();
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

    // Threading
    protected static function booted(): void
    {
        // função para lógica de threading do comentarios
        self::creating(static function (Comment $comment): void {
            if ($comment->parent_id) {
                $parent = Comment::query()->find($comment->parent_id);
                if ($parent) {
                    $comment->depth = $parent->depth + 1;
                    $comment->path = $parent->path.'.'.'{ID}';
                }
            } else {
                $comment->depth = 0;
                $comment->path = '{ID}';
            }
        });

        self::created(static function (Comment $comment): void {
            $comment->path = str_replace('{ID}', (string) $comment->id, $comment->path);
            $comment->save();

            $comment->post()->increment('comment_count');
        });

        self::deleted(static function (Comment $comment): void {
            $comment->post()->decrement('comment_count');
        });
    }

    protected function getScoreAttribute(): int
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }
}
