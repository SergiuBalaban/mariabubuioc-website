<?php

use App\Models\Project;

it('check homepage sidebar', function () {
    visit('/home')
        ->assertNoSmoke()
        ->assertNoConsoleLogs()
        ->assertNoJavaScriptErrors()
        ->assertSee('Workss')
        ->assertSee('About')
        ->assertSee('Test')
        ->assertSee('Blog');
});

it('check homepage projects', function () {
    Project::factory()->create();
    visit('/home')
        ->assertNoSmoke()
        ->assertNoConsoleLogs()
        ->assertNoJavaScriptErrors()
        ->assertSee('Works')
        ->assertSee('About')
        ->assertSee('Blog');
});
