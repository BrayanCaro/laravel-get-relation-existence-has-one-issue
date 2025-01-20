<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $firstUser = User::factory()->create([
            'name' => 'Alpha',
        ]);

        Post::create([
            'id' => 10,
            'user_id' => $firstUser->id,
        ]);
        Post::create([
            'id' => 888,
            'user_id' => $firstUser->id,
        ]);

        $secondUser = User::factory()->create([
            'name' => 'Beta',
        ]);

        Post::create([
            'id' => 999,
            'user_id' => $secondUser->id,
        ]);
    }
}
