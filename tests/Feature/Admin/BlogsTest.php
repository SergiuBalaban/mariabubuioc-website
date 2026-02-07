<?php

namespace Tests\Feature\Admin;

use App\Models\Blog;
use App\Models\User;

// SHOW BLOG
it('requires authentication to check admin blogs', function () {
    $response = $this->get('/admin/blogs');

    $response->assertRedirect('/login');
});

it('can see admin blogs page as authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin/blogs')
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Blogs'));
});

it('can see admin blogs page with paginated articles', function () {
    $user = User::factory()->create();
    Blog::factory()->count(15)->create();

    $this->actingAs($user)
        ->get('/admin/blogs')
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('Admin/Blogs')
            ->has('blogs.data', 10)
            ->has('blogs.meta.current_page')
            ->has('blogs.meta.last_page')
        );
});

// DELETE BLOG
it('cannot delete blog without authenticated user', function () {
    $blog = Blog::factory()->create();

    $response = $this->delete("/admin/blogs/{$blog->id}");

    $response->assertRedirect('/login');
    $this->assertDatabaseHas('blogs', ['id' => $blog->id]);
});

it('can delete blog with authenticated user', function () {
    $user = User::factory()->create();
    $blog = Blog::factory()->create();

    $response = $this->actingAs($user)->delete("/admin/blogs/{$blog->id}");

    $response->assertRedirect('/admin/blogs');
    $this->assertSoftDeleted($blog);
});
