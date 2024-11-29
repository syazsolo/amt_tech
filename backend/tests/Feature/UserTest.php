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

test('All: No user', function () {
    $response = $this->postJson('/api/user/all');

    $response->assertJson([]);
});

test('All: 1 user', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/user/all');

    $data = [$user->only('id', 'name', 'email', 'phone', 'password')];

    $response->assertJson($data);
});

test('All: 3 users', function () {
    $users = User::factory(2)->create();

    $response = $this->postJson('/api/user/all');

    $data = $users->map(function (User $user) {
        return $user->only('id', 'name', 'email', 'phone', 'password');
    })->toArray();

    $response->assertJson($data);
});
