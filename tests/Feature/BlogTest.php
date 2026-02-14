<?php

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a successful response for blog page', function () {
    Blog::factory()->count(3)->create();

    $response = $this->get('/blog');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Blog')
        ->has('articles.data', 3)
    );
});

it('returns a successful response for a single article page', function () {
    $blog = Blog::factory()->create([
        'title' => 'Hempcrete house - our experience',
        'content' => 'Test description',
    ]);

    $response = $this->get("/blogs/{$blog->id}");

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page
        ->component('Article')
        ->where('article.data.id', $blog->id)
        ->where('article.data.title', 'Hempcrete house - our experience')
    );
});

it('returns 404 for a non-existent article', function () {
    $response = $this->get('/blogs/999');

    $response->assertStatus(404);
});
