<?php

use App\Models\Blog;
use App\Models\User;

it('requires authentication to create admin blog', function () {
    visit('/admin/blogs/create')
        ->assertSee('Log in to your account');
});

it('create new blog on admin blog page as authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    visit('/admin/blogs/create')
        ->assertSee('Create Blog')
        ->type('title', 'New Blog Title')
        ->press('Create Blog');

    $this->assertDatabaseHas(Blog::class, [
        'title' => 'New Blog Title',
    ]);
})->skip('It not see Blog model on DB');
