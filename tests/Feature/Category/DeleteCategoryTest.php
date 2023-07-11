<?php

use App\Models\Category;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use Spatie\Permission\Models\Role;

test('guests cannot delete a category', function () {
    $category = Category::factory()->create();

    delete("admin/categories/{$category->id}")->assertRedirect('/login');
});

test('normal users cannot delete a category', function () {
    $user = User::factory()->create();

    $category = Category::factory()->create();

    actingAs($user)->delete("admin/categories/{$category->id}")->assertForbidden();
});

test('admins cannot delete a non-existent category', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    actingAs($user)->delete('admin/categories/404')->assertNotFound();
});

test('admins can delete a category', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $category = Category::factory()->create();

    actingAs($user)->delete("admin/categories/{$category->id}")->assertRedirect('admin/categories');
});
