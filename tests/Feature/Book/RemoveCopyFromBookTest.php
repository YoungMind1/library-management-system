<?php

use App\Models\Book;
use App\Models\Copy;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\delete;
use function PHPUnit\Framework\assertSame;
use Spatie\Permission\Models\Role;

test('Book\'s copy count can be decremented when there is no one currently holding the book and there is not copies available', function () {
    $book = Book::factory()->create();

    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    actingAs($user);
    $response = delete("admin/books/{$book->id}/{404}");

    $response->assertStatus(404);
    assertSame($book->copies()->getQuery()->count(), 0);
});

test('Book\'s copy count can be decremented when there is no one currently holding the book and there are some copies available', function () {
    $book = Book::factory()->create();
    $book->copies()->create();
    $book->copies()->create();

    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    actingAs($user)->from("admin/books/{$book->id}")->delete("admin/books/{$book->id}/{$book->copies[0]->id}")->assertRedirect("/admin/books/{$book->id}")->assertSessionHasNoErrors();
    assertSame($book->copies()->getQuery()->count(), 1);
});

test('Book\'s copy count can\'t be decremented when there is currently someone holding the book', function () {
    $book = Book::factory()->has(Copy::factory())->create();
    $book->copies()->create();

    $book_borrower = User::factory()->create();
    $book_borrower->copies()->attach($book->copies[0], ['due_date' => now()->addWeeks(2)]);

    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    actingAs($user)->from("admin/books/{$book->id}")->delete("admin/books/{$book->id}/{$book->copies[0]->id}")->assertRedirect("/admin/books/{$book->id}")->assertSessionHasErrors();
});
