<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Subreddit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Subreddit>
 */
final class SubredditFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(15),
            'rules' => fake()->paragraphs(3, true),
            'member_count' => 0,
            'post_count' => 0,
            'created_by' => User::factory(),
            'is_active' => true,
        ];
    }
}
