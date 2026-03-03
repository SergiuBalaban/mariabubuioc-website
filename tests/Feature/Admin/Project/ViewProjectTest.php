<?php

use App\Models\Project;
use App\Models\User;

it('cannot view categories list without authentication', function () {
    $this->getJson('/admin/projects')->assertUnauthorized();
});

it('can view project list', function () {
    $user = User::factory()->create();
    Project::factory()->count(3)->create();

    $this->actingAs($user)
        ->get(route('admin.projects'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Projects')
            ->has('projects.data', 3)
        );
});

it('can view create project page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(route('admin.projects.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Project')
        );
});

it('can view edit project page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $project = Project::factory()->create();

    $this->get(route('admin.projects.edit', $project))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Project')
            ->has('project', fn ($page) => $page
                ->where('id', $project->id)
                ->where('title', $project->title)
                ->etc()
            )
        );
});

it('returns 404 for non-existent project id', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $this->get('/projects/999')->assertNotFound();
});
