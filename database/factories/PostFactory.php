<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use App\Models\Subreddit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
final class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'title' => fake()->sentence(6),
            'content' => fake()->paragraphs(4, true),
            'content_type' => 'text',
            'user_id' => User::factory(),
            'subreddit_id' => Subreddit::factory(),
            'upvotes' => 0,
            'downvotes' => 0,
            'score' => 0,
            'comment_count' => 0,
            'is_pinned' => false,
            'is_locked' => false,
        ];
    }
}
