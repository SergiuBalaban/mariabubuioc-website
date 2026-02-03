<?php

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('displays blog articles with category and description', function () {
    $blog = Blog::factory()->create([
        'title' => 'Test Blog Article',
        'author' => 'John Doe',
        'content' => [
            'description' => 'This is a test description for the blog article.',
            'category' => 'Design',
        ],
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
        'content' => [
            'description' => 'First article description',
            'category' => 'Technology',
        ],
    ]);

    Blog::factory()->create([
        'title' => 'Second Article',
        'author' => 'Author Two',
        'content' => [
            'description' => 'Second article description',
            'category' => 'Art',
        ],
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
