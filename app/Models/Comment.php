<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Comment extends Model
{
    use HasFactory;
    use HasUuids;

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

    protected function casts(): array
    {
        return [];
    }
}
