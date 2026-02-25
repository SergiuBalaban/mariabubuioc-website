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
            'cover' => 'https://picsum.photos/800/600?random='.$this->faker->numberBetween(1, 1000),
            'title' => $this->faker->unique()->sentence(),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
