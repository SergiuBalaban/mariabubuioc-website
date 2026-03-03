<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\User;

it('requires authentication to update admin project', function () {
    $project = Project::factory()->create();
    visit("/admin/projects/{$project->id}")
        ->assertSee('Log in to your account');
});

it('update existing project on admin project page as authenticated user', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $newCategory = Category::factory()->create();
    $project = Project::factory()->create(['category_id' => $category->id]);

    $this->actingAs($user);
    visit("/admin/projects/{$project->id}")
        ->assertSee('Edit Project')
        ->type('title', 'Updated Project Title')
        ->select('category', (string) $newCategory->id)
        ->press('Save Changes');

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => 'Updated Project Title',
        'category_id' => $newCategory->id,
    ]);
});
