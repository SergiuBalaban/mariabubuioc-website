<?php

use App\Models\Category;
use App\Models\User;

it('cannot view categories list without authentication', function () {
    $this->getJson('/admin/categories')->assertUnauthorized();
});

it('can view categories list', function () {
    $user = User::factory()->create();
    Category::factory()->count(3)->create();

    $this->actingAs($user)
        ->get(route('admin.categories'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Categories')
            ->has('categories.data', 3)
        );
});

it('can view create category page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(route('admin.categories.create'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('Admin/Category')
        );
});

it('can view edit category page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $this->get(route('admin.categories.edit', $category))
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
