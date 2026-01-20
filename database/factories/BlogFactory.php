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
            'cover' => $this->faker->imageUrl(),
            'title' => $this->faker->unique()->sentence(),
            'author' => $this->faker->name(),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
