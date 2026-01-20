<?php

use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\UniqueConstraintViolationException;

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

it('has a category relationship', function () {
    $project = Project::factory()->create();

    expect($project->category)->toBeInstanceOf(Category::class);
});

it('enforces unique title', function () {
    Project::factory()->create(['title' => 'Unique Title']);

    expect(fn () => Project::factory()->create(['title' => 'Unique Title']))
        ->toThrow(UniqueConstraintViolationException::class);
});
