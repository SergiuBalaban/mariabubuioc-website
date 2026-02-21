<?php

use App\Models\Project;
use App\Models\User;

it('requires authentication to show admin projects', function () {
    visit('/admin/projects')
        ->assertSee('Log in to your account');
});

it('access admin projects page with authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    visit('/admin/projects')
        ->assertSee('Projects');
});

it('show admin projects page with paginated items', function () {
    $user = User::factory()->create();
    Project::factory()->count(15)->create();

    $this->actingAs($user);
    visit('/admin/projects')
        ->assertSee('Projects');
});
