<?php

use App\Models\Blog;
use Illuminate\Database\UniqueConstraintViolationException;

it('can create a blog post', function () {
    $blog = Blog::factory()->create([
        'title' => 'Sample Blog Title',
        'author' => 'John Doe',
        'content' => 'This is the content of the blog post.',
    ]);

    expect($blog->title)->toBe('Sample Blog Title');
    $this->assertDatabaseHas(Blog::class, [
        'id' => $blog->id,
        'title' => 'Sample Blog Title',
        'author' => 'John Doe',
    ]);
});

it('requires a unique title', function () {
    Blog::factory()->create(['title' => 'Unique Title']);

    expect(fn () => Blog::factory()->create(['title' => 'Unique Title']))
        ->toThrow(UniqueConstraintViolationException::class);
});

it('allows nullable cover and author', function () {
    $blog = Blog::create([
        'title' => 'Minimal Blog',
        'content' => 'Some content',
        'cover' => null,
        'author' => null,
    ]);

    expect($blog->cover)->toBeNull()
        ->and($blog->author)->toBeNull();

    $this->assertDatabaseHas(Blog::class, [
        'title' => 'Minimal Blog',
        'cover' => null,
        'author' => null,
    ]);
});
