<?php

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// can use more test cases for failure

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

test('Update: Success', function () {
    $user = User::factory()->create();

    $this->assertDatabaseHas('users', $user->only('id', 'name', 'email', 'phone'));

    $response = $this->postJson('/api/user/edit', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'phone' => '012-4567890',
    ]);

    $response->assertJson(Helper::respondSuccess());

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Updated Name',
        'email' => 'updated@example.com',
        'phone' => '012-4567890',
    ]);
});

test('Delete: Success', function () {
    $user = User::factory()->create();

    $this->assertDatabaseHas('users', $user->only('id', 'name', 'email', 'phone'));

    $response = $this->postJson('/api/user/delete', [
        'id' => $user->id
    ]);

    $response->assertJson(Helper::respondSuccess());

    $this->assertDatabaseMissing('users', [
        'id' => $user->id
    ]);
});

test('Delete: Fail', function () {
    $response = $this->postJson('/api/user/delete', [
        'id' => 1
    ]);

    $response->assertJson(Helper::StandardResponse(1001, 'Delete User Failed'));
});
