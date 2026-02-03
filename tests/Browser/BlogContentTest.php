<?php

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('displays blog articles with category and description', function () {
    $blog = Blog::factory()->create([
        'title' => 'Test Blog Article',
        'author' => 'John Doe',
        'details' => [
            'description' => 'This is a test description for the blog article.',
            'category' => 'Design',
        ],
        'content' => 'content',
    ]);

    visit('/blog')
        ->assertSee($blog->title)
        ->assertSee($blog->author)
        ->assertSee('This is a test description for the blog article.')
        ->assertSee('Design');
});

it('displays multiple blog articles correctly', function () {
    Blog::factory()->create([
        'title' => 'First Article',
        'author' => 'Author One',
        'details' => [
            'description' => 'First article description',
            'category' => 'Technology',
            'content_ro' => 'First content description',
        ],
        'content' => 'content',
    ]);

    Blog::factory()->create([
        'title' => 'Second Article',
        'author' => 'Author Two',
        'details' => [
            'description' => 'Second article description',
            'category' => 'Art',
            'content_ro' => 'Second content description',
        ],
        'content' => 'content',
    ]);

    visit('/blog')
        ->assertSee('First Article')
        ->assertSee('Author One')
        ->assertSee('First article description')
        ->assertSee('Technology')
        ->assertSee('Second Article')
        ->assertSee('Author Two')
        ->assertSee('Second article description')
        ->assertSee('Art');
});
