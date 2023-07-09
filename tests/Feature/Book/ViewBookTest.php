<?php

use App\Models\Book;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use Spatie\Permission\Models\Role;

test('guests can view the book list', function () {
    get(route('home'))->assertOk();
});

test('guests can view the books', function () {
    $book = Book::factory()->create();

    get(route('books.show', $book))->assertOk();
});

test('guests cannot view the admin book list', function () {
    get(route('admin.books.index'))->assertRedirect(route('login'));
});

test('normal users cannot view the admin book list', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('admin.books.index'))->assertForbidden();
});

test('guests cannot view the admin book pages', function () {
    $book = Book::factory()->create();

    get(route('admin.books.show', $book))->assertRedirect(route('login'));
});

test('normal users cannot view the admin book pages', function () {
    $user = User::factory()->create();
    $book = Book::factory()->create();

    actingAs($user)->get(route('admin.books.show', $book))->assertForbidden();
});

test('admins can view the admin book list', function () {
    $user = User::factory()->hasAttached(Role::findByName('admin'))->create();

    actingAs($user)->get(route('admin.books.index'))->assertOk();
});

test('admins can view the admin book pages', function () {
    $user = User::factory()->hasAttached(Role::findByName('admin'))->create();
    $book = Book::factory()->create();

    actingAs($user)->get(route('admin.books.show', $book))->assertOk();
});
