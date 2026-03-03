<?php

use App\Models\Category;
use App\Models\Project;
use App\Models\User;

it('cannot create a project without authentication', function () {
    $data = Project::factory()->make()->toArray();
    $this->postJson('/admin/projects', $data)->assertUnauthorized();

    $this->assertDatabaseMissing(Project::class, $data);
});

it('cannot create a project with failed rules', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $this->actingAs($user);

    $this->postJson('/admin/projects')->assertUnprocessable();

    $this->postJson('/admin/projects', [
        'category_id' => $category->id,
        'title' => null,
    ])->assertUnprocessable();

    $this->postJson('/admin/projects', [
        'category_id' => $category->id,
        'title' => '',
    ])->assertUnprocessable();

    $this->postJson('/admin/projects', [
        'category_id' => $category->id,
        'title' => '1',
    ])->assertUnprocessable();

    $this->postJson('/admin/projects', [
        'category_id' => $category->id,
        'title' => '2',
    ])->assertUnprocessable();

    $this->postJson('/admin/projects', [
        'category_id' => null,
        'title' => 'title',
    ])->assertUnprocessable();

    $this->assertDatabaseCount(Project::class, 0);
});

it('cannot create a project with existing title', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $this->actingAs($user);

    $this->postJson('/admin/projects', [
        'title' => $project->title,
    ])->assertUnprocessable();

    $this->assertDatabaseCount(Project::class, 1);
});

it('can create a project', function () {
    $user = User::factory()->create();
    $data = Project::factory()->make()->toArray();
    $this->actingAs($user);

    $this->postJson('/admin/projects', $data)->assertRedirect('/admin/projects/1');

    $this->assertDatabaseHas(Project::class, [
        'category_id' => $data['category_id'],
        'title' => $data['title'],
        'cover' => $data['cover'],
        'price' => $data['price'],
        'content' => $data['content'],
    ]);
});
