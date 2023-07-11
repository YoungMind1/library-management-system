<?php

use App\Models\Book;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use Spatie\Permission\Models\Role;

test('guests cannot see lends list', function () {
    get(route('admin.lends.index'))->assertRedirect(route('login'));
});

test('normal users cannot see the lends list', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('admin.lends.index'))->assertForbidden();
});

test('admins can see lends list', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    actingAs($user)->get(route('admin.lends.index'))->assertOk();
});

test('guests cannot see lend page', function () {
    get(route('admin.lends.borrow-page'))->assertRedirect(route('login'));
});

test('normal users cannot see the lend page', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('admin.lends.borrow-page'))->assertForbidden();
});

test('admins can see lend page', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    actingAs($user)->get(route('admin.lends.borrow-page'))->assertOk();
});

test('guests cannot see return page', function () {
    get(route('admin.lends.take-back-page'))->assertRedirect(route('login'));
});

test('normal users cannot see the return page', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('admin.lends.take-back-page'))->assertForbidden();
});

test('admins can see the return page', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    actingAs($user)->get(route('admin.lends.take-back-page'))->assertOk();
});

test('guests cannot lend book', function () {
    post(route('admin.lends.borrow'), [
        'data' => 'data',
    ])->assertRedirect(route('login'));
});

test('normal users cannot lend book', function () {
    $user = User::factory()->create();

    actingAs($user)->post(route('admin.lends.borrow'), [
        'data' => 'data',
    ])->assertForbidden();
});

test('admins can\'t lend books which don\'t exist', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $borrower = User::factory()->create();

    $data = [
        'user_id' => $borrower->id,
        'copy_id' => 404,
    ];

    actingAs($user)->from(route('admin.lends.borrow-page'))->post(route('admin.lends.borrow'), $data)->assertRedirect(route('admin.lends.borrow-page'))->assertSessionHasErrors();
});

test('admins can\'t lend books to users which don\'t exist', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $book = Book::factory()->create();
    $book->copies()->create();

    $data = [
        'copy_id' => $book->copies[0]->id,
        'user_id' => 404,
    ];

    actingAs($user)->from(route('admin.lends.borrow-page'))->post(route('admin.lends.borrow'), $data)->assertRedirect(route('admin.lends.borrow-page'))->assertSessionHasErrors();
});

test('admins cannot lend books to those who already hold 3 books', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $borrower = User::factory()->create();

    $book1 = Book::factory()->create();
    $book1->copies()->create();
    $borrower->copies()->attach($book1->copies[0], ['due_date' => now()->addWeeks(2)]);

    $book2 = Book::factory()->create();
    $book2->copies()->create();
    $borrower->copies()->attach($book2->copies[0], ['due_date' => now()->addWeeks(2)]);

    $book3 = Book::factory()->create();
    $book3->copies()->create();
    $borrower->copies()->attach($book3->copies[0], ['due_date' => now()->addWeeks(2)]);

    $book4 = Book::factory()->create();
    $book4->copies()->create();

    $data = [
        'user_id' => $borrower->id,
        'copy_id' => $book4->copies[0]->id,
    ];

    actingAs($user)->from(route('admin.lends.borrow-page'))->post(route('admin.lends.borrow'), $data)->assertRedirect(route('admin.lends.borrow-page'))->assertSessionHasErrors();
});

test('admins cannot lend books which are already in use', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $first_borrower = User::factory()->create();

    $book = Book::factory()->create();
    $book->copies()->create();
    $first_borrower->copies()->attach($book->copies[0], ['due_date' => now()->addWeeks(2)]);

    $borrower = User::factory()->create();

    $data = [
        'user_id' => $borrower->id,
        'copy_id' => $book->copies[0]->id,
    ];

    actingAs($user)->from(route('admin.lends.borrow-page'))->post(route('admin.lends.borrow'), $data)->assertRedirect(route('admin.lends.borrow-page'))->assertSessionHasErrors();
});

test('admins can lend books', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $book = Book::factory()->create();
    $book->copies()->create();

    $borrower = User::factory()->create();

    $data = [
        'user_id' => $borrower->id,
        'copy_id' => $book->copies[0]->id,
    ];

    actingAs($user)->post(route('admin.lends.borrow'), $data)->assertRedirect(route('admin.lends.index'))->assertSessionHasNoErrors();
});

test('admins cannot take back books which don\'t exist', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $borrower = User::factory()->create();

    $data = [
        'user_id' => $borrower->id,
        'copy_id' => 404,
    ];

    actingAs($user)->from(route('admin.lends.take-back-page'))->patch(route('admin.lends.take-back'), $data)->assertRedirect(route('admin.lends.take-back-page'))->assertSessionHasErrors();
});

test('admins cannot take back books from users which don\'t exist', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $book = Book::factory()->create();
    $book->copies()->create();

    $data = [
        'user_id' => 404,
        'copy_id' => $book->copies[0]->id,
    ];

    actingAs($user)->from(route('admin.lends.take-back-page'))->patch(route('admin.lends.take-back'), $data)->assertRedirect(route('admin.lends.take-back-page'))->assertSessionHasErrors();
});

test('admins cannot take back books from users which the books don\'t belong to', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $book = Book::factory()->create();
    $book->copies()->create();

    $borrower = User::factory()->create();

    $data = [
        'user_id' => $borrower->id,
        'copy_id' => $book->copies[0]->id,
    ];

    actingAs($user)->from(route('admin.lends.take-back-page'))->patch(route('admin.lends.take-back'), $data)->assertRedirect(route('admin.lends.take-back-page'))->assertSessionHasErrors();
});

test('admins can take back books from users', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $book = Book::factory()->create();
    $book->copies()->create();

    $borrower = User::factory()->create();
    $borrower->copies()->attach($book->copies[0]->id, ['due_date' => now()->addWeeks(2)]);

    $data = [
        'user_id' => $borrower->id,
        'copy_id' => $book->copies[0]->id,
    ];

    actingAs($user)->patch(route('admin.lends.take-back'), $data)->assertRedirect(route('admin.lends.index'))->assertSessionHasNoErrors();
});
