<?php

use App\Models\Blog;
use App\Models\User;

it('requires authentication to show admin blogs', function () {
    visit('/admin/blogs')
        ->assertSee('Log in to your account');
});

it('access admin blogs page with authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);
    visit('/admin/blogs')
        ->assertSee('Blogs');
});

it('show admin blogs page with paginated items', function () {
    $user = User::factory()->create();
    Blog::factory()->count(15)->create();

    $this->actingAs($user);
    visit('/admin/blogs')
        ->assertSee('Blogs');
});
