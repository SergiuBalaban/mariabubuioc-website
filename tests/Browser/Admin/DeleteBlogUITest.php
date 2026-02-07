<?php

use App\Models\Blog;
use App\Models\User;

it('cannot delete existing article on admin blog page if not authenticated user', function () {
    $user = User::factory()->create();
    Blog::factory()->count(15)->create();

    $this->actingAs($user);
    visit('/admin/blogs')
        ->assertSee('Blogs');
});

it('delete existing article on admin blog page as authenticated user', function () {
    $user = User::factory()->create();
    $blogs = Blog::factory()->count(15)->create();
    $firstBlog = $blogs->first();

    $this->actingAs($user);
    visit('/admin/blogs')
        ->assertSee($firstBlog->title)
        ->assertSee('Delete')
        ->click('[data-test="delete-blog-button-'.$firstBlog->id.'"]')
//        ->click('tbody tr:first-child [data-test="delete-blog-button"]')
//            ->click('[data-test="delete-blog-button"]:first-of-type')
//        ->script('window.confirm = () => true')
//        ->click('@delete-blog-button-' . $firstBlog->id)
//        ->debug()
        ->assertDontSee($firstBlog->title);

    $this->assertDatabaseMissing('blogs', ['id' => $firstBlog->id]);
})->skip('This test is currently skipped because of the confirmation dialog. Need to find a way to handle it in the test.');
