<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 10 users
        $users = User::factory(10)->create();

        // Create 20 posts with random users
        $posts = Post::factory(20)->create([
            'user_id' => fn() => $users->random()->id,
        ]);

        // Create 50 comments with random users and posts
        Comment::factory(50)->create([
            'user_id' => fn() => $users->random()->id,
            'post_id' => fn() => $posts->random()->id,
        ]);
    }
}
