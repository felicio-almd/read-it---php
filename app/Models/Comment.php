<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Votable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

final class Comment extends Model
{
    use HasFactory;
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
     * Retorna todos os "ancestrais" (pais, avós, etc.) de um comentário.
     *
     * @return Collection
     */
    public function getAncestors()
    {
        // Pega o caminho (ex: "id1.id2.id3") e transforma em um array de IDs
        $parentIds = explode('.', (string) $this->path);

        // Remove o ID do próprio comentário do final do array
        array_pop($parentIds);

        // Se não houver IDs de pais, retorna uma coleção vazia
        if ($parentIds === []) {
            return collect();
        }

        // Busca todos os comentários cujos IDs estão na lista de pais
        // e os ordena pela profundidade (depth) para manter a hierarquia
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
        // Evento que dispara ANTES de um novo comentário ser salvo
        self::creating(function (Comment $comment): void {
            if ($comment->parent_id) {
                // Se for uma resposta, busca o pai
                $parent = Comment::query()->find($comment->parent_id);
                if ($parent) {
                    // A profundidade é a do pai + 1
                    $comment->depth = $parent->depth + 1;
                    // O caminho é o do pai, um ponto, e o ID do novo comentário
                    // Usamos um placeholder {ID} que será substituído depois
                    $comment->path = $parent->path.'.'.'{ID}';
                }
            } else {
                // Se for um comentário de nível raiz, a profundidade é 0
                $comment->depth = 0;
                $comment->path = '{ID}';
            }
        });

        // Evento que dispara DEPOIS que o comentário foi salvo e já tem um ID
        self::created(function (Comment $comment): void {
            // Substitui o placeholder {ID} pelo ID real que acabou de ser gerado
            $comment->path = str_replace('{ID}', $comment->id, $comment->path);
            $comment->save();

            $comment->post()->increment('comment_count');
        });

        self::deleted(function (Comment $comment): void {
            // Decrementa contador no Post
            $comment->post()->decrement('comment_count');
        });
    }

    protected function getScoreAttribute(): int
    {
        return $this->upvotes()->count() - $this->downvotes()->count();
    }
}
