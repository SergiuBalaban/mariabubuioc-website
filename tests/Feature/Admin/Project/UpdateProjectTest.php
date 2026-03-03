<?php

use App\Models\Project;
use App\Models\User;

it('cannot update a category without authentication', function () {
    $project = Project::factory()->create();
    $this->putJson('/admin/projects/'.$project->id, [
        'title' => 'New Title',
    ])->assertUnauthorized();

    $this->assertDatabaseHas(Project::class, [
        'title' => $project->title,
    ]);

    $this->assertDatabaseMissing(Project::class, [
        'title' => 'New Title',
    ]);
});

it('cannot update a project with failed rules', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $this->actingAs($user);

    $this->putJson('/admin/projects/'.$project->id, [
        'title' => null,
    ])->assertUnprocessable();

    $this->putJson('/admin/projects/'.$project->id, [
        'title' => '',
    ])->assertUnprocessable();

    $this->putJson('/admin/projects/'.$project->id, [
        'title' => '1',
    ])->assertUnprocessable();

    $this->putJson('/admin/projects/'.$project->id, [
        'title' => '2',
    ])->assertUnprocessable();

    $this->putJson('/admin/projects/'.$project->id, [
        'category_id' => null,
    ])->assertUnprocessable();

    $this->assertDatabaseHas(Project::class, [
        'title' => $project->title,
    ]);
});

it('cannot update a project with existing title', function () {
    $user = User::factory()->create();
    $firstProject = Project::factory()->create();
    $currentProject = Project::factory()->create([
        'title' => 'Current Title',
    ]);
    $this->actingAs($user);

    $this->putJson('/admin/projects/'.$currentProject->id, [
        'title' => $firstProject->title,
    ])->assertUnprocessable();

    $this->assertDatabaseHas(Project::class, [
        'title' => $firstProject->title,
    ]);

    $this->assertDatabaseHas(Project::class, [
        'id' => $currentProject->id,
        'title' => 'Current Title',
    ]);
});

it('can update a project', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $payload = [
        'title' => 'New Title',
    ];
    $this->actingAs($user);

    $this->putJson('/admin/projects/'.$project->id, $payload)
        ->assertRedirect('/admin/projects/'.$project->id);

    $this->assertDatabaseHas(Project::class, [
        'id' => $project->id,
        'category_id' => $project->category_id,
        'title' => $payload['title'],
    ]);

    $this->assertDatabaseMissing(Project::class, [
        'title' => $project->title,
    ]);
});
