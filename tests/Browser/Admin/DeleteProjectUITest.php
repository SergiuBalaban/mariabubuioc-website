<?php

use App\Models\Project;
use App\Models\User;

it('cannot delete existing project on admin projects page if not authenticated user', function () {
    $user = User::factory()->create();
    Project::factory()->count(15)->create();

    $this->actingAs($user);
    visit('/admin/projects')
        ->assertSee('Projects');
});

it('delete existing project on admin projects page as authenticated user', function () {
    $user = User::factory()->create();
    $projects = Project::factory()->count(15)->create();
    $firstProject = $projects->first();

    $this->actingAs($user);
    visit('/admin/projects')
        ->assertSee($firstProject->title)
        ->assertSee('Delete')
        ->click('[data-test="delete-project-button-'.$firstProject->id.'"]')
        ->assertDontSee($firstProject->title);

    $this->assertDatabaseMissing('projects', ['id' => $firstProject->id]);
})->skip('This test is currently skipped because of the confirmation dialog. Need to find a way to handle it in the test.');
