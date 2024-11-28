<?php

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('Create: Success', function () {
    $raw = User::factory()->raw();
    $response = $this->postJson('/api/user/add', $raw);

    $response->assertJson(Helper::respondSuccess());

    $adjusted = array_merge($raw, [
        'email_verified_at' => null,
        'remember_token' => null
    ]);

    $this->assertDatabaseHas('users', $adjusted);
});
