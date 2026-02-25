<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::query()->count() ? Category::inRandomOrder()->first()->id : Category::factory(),
            'title' => fake()->unique()->sentence(),
            'cover' => 'https://picsum.photos/800/600?random='.fake()->numberBetween(1, 1000),
            'details' => [
                'client' => fake()->company(),
                'year' => fake()->year(),
            ],
            'price' => (string) fake()->randomFloat(2, 100, 1000),
            'content' => fake()->paragraphs(3, true),
        ];
    }
}
