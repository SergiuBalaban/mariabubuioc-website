<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\User;

it('cannot delete a project without authentication', function () {
    $project = Project::factory()->create();
    $this->deleteJson('/admin/projects/'.$project->id)->assertUnauthorized();

    $this->assertNotSoftDeleted($project);
});

it('can delete a category with project', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $project = Project::factory()->create([
        'category_id' => $category->id,
    ]);
    $this->actingAs($user);

    $this->deleteJson('/admin/projects/'.$project->id)
        ->assertRedirect('/admin/projects');

    $this->assertNotSoftDeleted($category);
    $this->assertSoftDeleted($project);
});
