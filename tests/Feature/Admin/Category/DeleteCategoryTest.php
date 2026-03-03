<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\User;

it('cannot delete a category without authentication', function () {
    $category = Category::factory()->create();
    $this->deleteJson('/admin/categories/'.$category->id)->assertUnauthorized();

    $this->assertNotSoftDeleted($category);
});

it('can delete a category without project', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $this->actingAs($user);

    $this->deleteJson('/admin/categories/'.$category->id)
        ->assertRedirect('/admin/categories');

    $this->assertDatabaseCount(Category::class, 1);
    $this->assertSoftDeleted($category);
});

it('can delete a category with project', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $project = Project::factory()->create([
        'category_id' => $category->id,
    ]);
    $this->assertDatabaseHas(Project::class, [
        'category_id' => $category->id,
    ]);
    $this->actingAs($user);

    $this->deleteJson('/admin/categories/'.$category->id)
        ->assertRedirect('/admin/categories');

    $this->assertDatabaseCount(Category::class, 1);
    $this->assertSoftDeleted($category);
    $this->assertSoftDeleted($project);
});
