<?php

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('displays blog articles with category and description', function () {
    $blog = Blog::factory()->create([
        'title' => 'Test Blog Article',
        'content' => 'This is a test description for the blog article.',
    ]);

    visit('/blog')
        ->assertSee($blog->title)
        ->assertSee('This is a test description for the blog article.');
});

it('displays multiple blog articles correctly', function () {
    Blog::factory()->create([
        'title' => 'First Article',
        'content' => 'First article description',
    ]);

    Blog::factory()->create([
        'title' => 'Second Article',
        'content' => 'Second article description',
    ]);

    visit('/blog')
        ->assertSee('Second Article')
        ->assertSee('First article description')
        ->assertSee('First Article')
        ->assertSee('First article description');
});
