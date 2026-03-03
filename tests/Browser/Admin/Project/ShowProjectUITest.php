<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\User;

it('requires authentication to show admin project edit page', function () {
    $project = Project::factory()->create();
    visit("/admin/projects/{$project->id}")
        ->assertSee('Log in to your account');
});

it('access admin project edit page with authenticated user', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $project = Project::factory()->create(['category_id' => $category->id]);

    $this->actingAs($user);
    visit("/admin/projects/{$project->id}")
        ->assertSee('Edit Project')
        ->assertSee($project->title);
});
