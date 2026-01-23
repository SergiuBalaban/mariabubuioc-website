<?php

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a successful response for a project detail page', function () {
    $project = Project::factory()->create([
        'title' => 'Rocking chair',
    ]);

    $response = $this->get("/projects/{$project->id}");

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Project')
        ->has('project')
        ->where('project.data.id', $project->id)
        ->where('project.data.title', 'Rocking chair')
    );
});

it('returns 404 for a non-existent project', function () {
    $response = $this->get('/projects/999');

    $response->assertStatus(404);
});
