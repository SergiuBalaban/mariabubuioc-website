<?php

it('returns a successful response for the home page', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertInertia(fn ($page) => $page->component('Home'));
});
