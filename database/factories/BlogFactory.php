<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Blog>
 */
class BlogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cover' => 'https://picsum.photos/800/600?random='.fake()->numberBetween(1, 1000),
            'title' => fake()->unique()->sentence(),
            'content' => fake()->paragraphs(3, true),
        ];
    }
}
