<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use Spatie\Permission\Models\Role;

test('guests cannot view the category list', function () {
    get(route('admin.categories.index'))->assertRedirect(route('login'));
});

test('normal users cannot view the category list', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('admin.categories.index'))->assertForbidden();
});

test('admins can view the category list', function () {
    $user = User::factory()->hasAttached(Role::findByName('admin'))->create();

    actingAs($user)->get(route('admin.categories.index'))->assertOk();
});
