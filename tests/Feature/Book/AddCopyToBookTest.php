<?php

use App\Models\Book;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertSame;
use Spatie\Permission\Models\Role;

test('Book\'s copy count can be incremented', function () {
    $book = Book::factory()->create();

    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    actingAs($user)->from("admin/books/{$book->id}")->post("admin/books/{$book->id}/add-copy")->assertRedirect("/admin/books/{$book->id}")->assertSessionHasNoErrors();
    assertSame($book->copies()->getQuery()->count(), 1);
});
