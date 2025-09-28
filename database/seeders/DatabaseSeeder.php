<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Subreddit;
use App\Models\User;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->isLocal()) {
            User::factory()->admin()->create();
        }

        $users = User::factory(10)->create();
        $subreddits = Subreddit::factory(10)->recycle($users)->create();
        Post::factory(10)->recycle($users)->recycle($subreddits)->create();
        User::factory()->has(Post::factory()->count(5))->create();
    }
}
