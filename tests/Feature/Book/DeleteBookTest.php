<?php

use App\Models\Book;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use Spatie\Permission\Models\Role;

test('guests cannot delete a book', function () {
    $book = Book::factory()->create();

    delete("admin/books/{$book->id}")->assertRedirect('/login');
});

test('normal users cannot delete a book', function () {
    $user = User::factory()->create();

    $book = Book::factory()->create();

    actingAs($user)->delete("admin/books/{$book->id}")->assertForbidden();
});

test('admins cannot delete a non-existent book', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    actingAs($user)->delete('admin/books/404')->assertNotFound();
});

test('admins can delete a book', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $book = Book::factory()->create();

    actingAs($user)->delete("admin/books/{$book->id}")->assertRedirect('admin/books');
});
