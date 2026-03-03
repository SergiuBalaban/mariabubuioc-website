<?php

use App\Models\Category;
use App\Models\User;

it('cannot update a category without authentication', function () {
    $category = Category::factory()->create();
    $this->putJson('/admin/categories/'.$category->id, [
        'name' => 'New Category',
    ])->assertUnauthorized();

    $this->assertDatabaseCount(Category::class, 1);
    $this->assertDatabaseMissing(Category::class, [
        'name' => 'New Category',
    ]);
});

it('cannot update a category without name rules', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $this->actingAs($user);

    $this->putJson('/admin/categories/'.$category->id)->assertUnprocessable();

    $this->putJson('/admin/categories/'.$category->id, [
        'name' => null,
    ])->assertUnprocessable();

    $this->putJson('/admin/categories/'.$category->id, [
        'name' => '',
    ])->assertUnprocessable();

    $this->putJson('/admin/categories/'.$category->id, [
        'name' => '1',
    ])->assertUnprocessable();

    $this->putJson('/admin/categories/'.$category->id, [
        'name' => '12',
    ])->assertUnprocessable();

    $this->assertDatabaseCount(Category::class, 1);
    $this->assertDatabaseHas(Category::class, [
        'name' => $category->name,
    ]);
});

it('cannot update a category with existing name', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $this->actingAs($user);

    $this->putJson('/admin/categories/'.$category->id, [
        'name' => $category->name,
    ])->assertUnprocessable();

    $this->assertDatabaseCount(Category::class, 1);
});

it('can update a category with max name rule', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $payload = [
        'name' => str_repeat('a', 255),
    ];
    $this->actingAs($user);

    $this->putJson('/admin/categories/'.$category->id, $payload)
        ->assertRedirect('/admin/categories/'.$category->id);

    $this->assertDatabaseHas(Category::class, [
        'id' => $category->id,
        'name' => $payload['name'],
    ]);
    $this->assertDatabaseMissing(Category::class, [
        'name' => $category->name,
    ]);
});
