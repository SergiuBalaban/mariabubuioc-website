<?php

use App\Models\Blog;
use App\Models\User;

it('cannot access edit blog page if not authenticated', function () {
    $blog = Blog::factory()->create();

    visit('/admin/blogs/'.$blog->id)
        ->assertPathIs('/login');
});

it('can view edit blog page as authenticated user', function () {
    $user = User::factory()->create();
    $blog = Blog::factory()->create([
        'title' => 'Test Blog Title',
    ]);

    $this->actingAs($user);
    visit('/admin/blogs/'.$blog->id)
        ->assertSee('Edit Blog')
        ->assertSee('Test Blog Title')
        ->assertSee('Save Changes');
});

it('can update blog as authenticated user', function () {
    $user = User::factory()->create();
    $blog = Blog::factory()->create([
        'title' => 'Original Title',
    ]);

    $this->actingAs($user);
    visit('/admin/blogs/'.$blog->id)
        ->assertSee('Original Title')
        ->type('#title', 'Updated Title')
        ->press('Save Changes')
        ->assertPathIs('/admin/blogs/'.$blog->id);
    //        ->assertSee('Updated Title');

    $this->assertDatabaseHas(Blog::class, [
        'id' => $blog->id,
        'title' => 'Updated Title',
    ]);
});

it('validates required title field when updating blog', function () {
    $user = User::factory()->create();
    $blog = Blog::factory()->create(['title' => 'Original Title']);

    $this->actingAs($user);
    visit('/admin/blogs/'.$blog->id)
        ->type('#title', '')
        ->press('Save Changes');

    $this->assertDatabaseHas('blogs', [
        'id' => $blog->id,
        'title' => 'Original Title',
    ]);
});

it('can navigate back to blogs list from edit page', function () {
    $user = User::factory()->create();
    $blog = Blog::factory()->create();

    $this->actingAs($user);
    visit('/admin/blogs/'.$blog->id)
        ->assertSee('Back to Blogs')
        ->press('Back to Blogs')
        ->assertPathIs('/admin/blogs');
});

it('can click on blog title in list to navigate to edit page', function () {
    $user = User::factory()->create();
    $blog = Blog::factory()->create(['title' => 'Clickable Blog Title']);

    $this->actingAs($user);
    visit('/admin/blogs')
        ->assertSee('Clickable Blog Title')
        ->press('Clickable Blog Title')
        ->assertPathIs('/admin/blogs/'.$blog->id)
        ->assertSee('Edit Blog');
});

it('can update blog content using rich text editor', function () {
    $user = User::factory()->create();
    $blog = Blog::factory()->create([
        'content' => '<p>Initial Content</p>',
    ]);

    $this->actingAs($user);
    visit('/admin/blogs/'.$blog->id)
        ->type('.ProseMirror', 'Updated Content')
        ->press('Save Changes')
        ->assertPathIs('/admin/blogs/'.$blog->id)
        ->assertSee('Updated Content');

    $updatedBlog = Blog::find($blog->id);
    expect($updatedBlog->content)->toContain('Updated Content');
});
