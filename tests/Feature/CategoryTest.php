<?php

use App\Models\Category;

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
