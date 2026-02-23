<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->delete();
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => 'test',
        ]);
        //        $this->call(ProjectSeeder::class);
        //        $this->call(BlogSeeder::class);

        Blog::query()->delete();
        Category::query()->delete();
        Project::query()->delete();

        Blog::factory(20)->create();
        Category::factory(5)->create();
        Project::factory(20)->create();
    }
}
