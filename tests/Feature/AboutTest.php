<?php

it('returns a successful response for about page', function () {
    $response = $this->get('/about');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('About'));
});
