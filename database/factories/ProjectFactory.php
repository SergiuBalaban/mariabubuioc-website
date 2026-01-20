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
            'category_id' => Category::factory(),
            'title' => $this->faker->unique()->sentence(),
            'cover' => $this->faker->imageUrl(),
            'details' => [
                'client' => $this->faker->company(),
                'year' => $this->faker->year(),
            ],
            'price' => (string) $this->faker->randomFloat(2, 100, 1000),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
