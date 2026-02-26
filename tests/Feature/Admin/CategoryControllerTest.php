<?php

use App\Models\Category;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('admin can view categories list', function () {
    Category::factory()->count(3)->create();

    actingAs($this->user)
        ->get(route('admin.categories'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Categories')
            ->has('categories.data', 3)
        );
});

test('admin can view create category page', function () {
    actingAs($this->user)
        ->get(route('admin.categories.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Category')
        );
});

test('admin can store a new category', function () {
    $data = ['name' => 'New Category'];

    actingAs($this->user)
        ->post(route('admin.categories.store'), $data)
        ->assertRedirect();

    $this->assertDatabaseHas('categories', $data);
});

test('admin can view edit category page', function () {
    $category = Category::factory()->create();

    actingAs($this->user)
        ->get(route('admin.categories.edit', $category))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Category')
            ->has('category', fn ($page) => $page
                ->where('id', $category->id)
                ->where('name', $category->name)
                ->etc()
            )
        );
});

test('admin can update a category', function () {
    $category = Category::factory()->create(['name' => 'Old Name']);
    $data = ['name' => 'Updated Name'];

    actingAs($this->user)
        ->put(route('admin.categories.update', $category), $data)
        ->assertRedirect();

    $this->assertDatabaseHas('categories', array_merge(['id' => $category->id], $data));
});

test('admin can delete a category', function () {
    $category = Category::factory()->create();

    actingAs($this->user)
        ->delete(route('admin.categories.destroy', $category))
        ->assertRedirect();

    $this->assertSoftDeleted('categories', ['id' => $category->id]);
});
