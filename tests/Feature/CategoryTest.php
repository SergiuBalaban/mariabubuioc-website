<?php

use App\Models\Category;
use App\Models\Project;

it('can create a category', function () {
    $category = Category::factory()->create([
        'name' => 'Test Category',
    ]);

    expect($category->name)->toBe('Test Category');
    $this->assertDatabaseHas(Category::class, [
        'id' => $category->id,
        'name' => 'Test Category',
    ]);
});

it('can soft delete a category', function () {
    $category = Category::factory()->create();

    $category->delete();

    expect($category->deleted_at)->not->toBeNull();
    $this->assertSoftDeleted(Category::class, [
        'id' => $category->id,
    ]);
});

it('can restore a soft deleted category', function () {
    $category = Category::factory()->create();
    $category->delete();

    $category->restore();

    expect($category->deleted_at)->toBeNull();
    $this->assertDatabaseHas(Category::class, [
        'id' => $category->id,
        'deleted_at' => null,
    ]);
});

it('can deleted category along with his projects', function () {
    $category = Category::factory()->create();
    Project::factory()->count(3)->create(['category_id' => $category->id]);

    $category->delete();

    expect($category->deleted_at)->not->toBeNull();
    $this->assertSoftDeleted($category);
    $this->assertSoftDeleted(Project::class, [
        'category_id' => $category->id,
    ]);
});
