<?php

use App\Models\Category;
use App\Models\User;

it('cannot create a category without authentication', function () {
    $this->postJson('/admin/categories', [
        'name' => 'New Category',
    ])->assertUnauthorized();

    $this->assertDatabaseCount(Category::class, 0);
});

it('cannot create a category without name rules', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->postJson('/admin/categories')->assertUnprocessable();

    $this->postJson('/admin/categories', [
        'name' => null,
    ])->assertUnprocessable();

    $this->postJson('/admin/categories', [
        'name' => '',
    ])->assertUnprocessable();

    $this->postJson('/admin/categories', [
        'name' => '1',
    ])->assertUnprocessable();

    $this->postJson('/admin/categories', [
        'name' => '12',
    ])->assertUnprocessable();

    $this->postJson('/admin/categories', [
        'name' => str_repeat('a', 256),
    ])->assertUnprocessable();

    $this->assertDatabaseCount(Category::class, 0);
});

it('cannot create a category with existing name', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $this->actingAs($user);

    $this->postJson('/admin/categories', [
        'name' => $category->name,
    ])->assertUnprocessable();

    $this->assertDatabaseCount(Category::class, 1);
});

it('can create a category with max name rule', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $data = [
        'name' => str_repeat('a', 255),
    ];
    $this->post('/admin/categories', $data)->assertRedirect('/admin/categories/1');

    $this->assertDatabaseCount(Category::class, 1);
    $this->assertDatabaseHas(Category::class, $data);
});
