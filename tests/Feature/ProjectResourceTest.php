<?php

use App\Models\Category;
use App\Models\Project;

it('returns projects on home page', function () {
    $category = Category::factory()->create(['name' => 'Furniture']);
    Project::factory()->count(3)->create(['category_id' => $category->id]);

    $response = $this->get('/home');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Home')
        ->has('projects.data', 3)
    );
});

it('returns a specific project with model binding', function () {
    $category = Category::factory()->create(['name' => 'Furniture']);
    $project = Project::factory()->create([
        'category_id' => $category->id,
        'title' => 'Specific Project',
    ]);

    $response = $this->get("/projects/{$project->id}");

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Project')
        ->where('project.data.id', $project->id)
        ->where('project.data.title', 'Specific Project')
    );
});

it('returns 404 for non-existent project id', function () {
    $response = $this->get('/projects/999');

    $response->assertStatus(404);
});
