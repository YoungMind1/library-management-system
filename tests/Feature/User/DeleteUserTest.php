<?php

use App\Models\Book;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use Spatie\Permission\Models\Role;

test('guests cannot delete a user', function () {
    $user = Book::factory()->create();

    delete("admin/users/{$user->id}")->assertRedirect('/login');
});

test('normal users cannot delete a user', function () {
    $user = User::factory()->create();

    $to_be_deleted_user = User::factory()->create();

    actingAs($user)->delete("admin/users/{$to_be_deleted_user->id}")->assertForbidden();
});

test('admins cannot delete a non-existent user', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    actingAs($user)->delete('admin/users/404')->assertNotFound();
});

test('admins can delete a user', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $to_be_deleted_user = User::factory()->create();

    actingAs($user)->delete("admin/users/{$to_be_deleted_user->id}")->assertRedirect('admin/users');
});
