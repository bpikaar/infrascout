<?php

use App\Models\User;

it('returns a successful response when authenticated', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/');

    $response->assertStatus(200);
});
