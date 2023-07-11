<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use Spatie\Permission\Models\Role;

test('guests can\'t view the users list', function () {
    get('admin/users')->assertRedirect(route('login'));
});

test('guests can\'t view a user', function () {
    $to_be_viewed_user = User::factory()->create();

    get(route('admin.users.show', $to_be_viewed_user))->assertRedirect(route('login'));
});

test('normal users cannot view the user list', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('admin.users.index'))->assertForbidden();
});

test('normal users cannot view a user', function () {
    $user = User::factory()->create();
    $to_be_viewed_user = User::factory()->create();

    actingAs($user)->get(route('admin.users.show', $to_be_viewed_user))->assertForbidden();
});

test('admins can view the user list', function () {
    $user = User::factory()->hasAttached(Role::findByName('admin'))->create();

    actingAs($user)->get(route('admin.users.index'))->assertOk();
});

test('admins can view a user', function () {
    $user = User::factory()->hasAttached(Role::findByName('admin'))->create();
    $to_be_viewed_user = User::factory()->create();

    actingAs($user)->get(route('admin.users.show', $to_be_viewed_user))->assertOk();
});
