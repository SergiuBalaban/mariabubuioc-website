<?php

use App\Models\Category;
use App\Models\Project;

it('can create a project', function () {
    $category = Category::factory()->create();

    $project = Project::factory()->create([
        'category_id' => $category->id,
        'title' => 'Test Project',
        'details' => ['key' => 'value'],
        'price' => '100.00',
        'content' => 'Long content here',
    ]);

    expect($project->title)->toBe('Test Project')
        ->and($project->category_id)->toBe($category->id)
        ->and($project->details)->toBe(['key' => 'value']);

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'title' => 'Test Project',
    ]);
});
