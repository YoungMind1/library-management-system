<?php

use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use Spatie\Permission\Models\Role;

test('guests cannot visit edit page', function () {
    $book = Book::factory()->create();

    get(route('admin.books.edit', $book))->assertRedirect(route('login'));
});

test('normal users cannot visit edit page', function () {
    $user = User::factory()->create();

    $book = Book::factory()->create();

    actingAs($user)->get(route('admin.books.edit', $book))->assertForbidden();
});

test('guests cannot edit book', function () {
    $book = Book::factory()->create();

    patch(route('admin.books.update', $book))->assertRedirect(route('login'));
});

test('normal users cannot edit book', function () {
    $user = User::factory()->create();

    $book = Book::factory()->create();

    actingAs($user)->patch(route('admin.books.update', $book))->assertForbidden();
});

test('admins cannot visit edit page of a non-existent book', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    actingAs($user)->get(route('admin.books.edit', 404))->assertNotFound();
});

test('admins cannot edit a non-existent book', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    actingAs($user)->patch(route('admin.books.update', 404))->assertNotFound();
});

test('admins can visit page of a book', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    $book = Book::factory()->create();

    actingAs($user)->get(route('admin.books.edit', $book))->assertOk();
});

test('edit book endpoint uses the appropriate form request', function () {
    $this->assertRouteUsesFormRequest('admin.books.update', BookUpdateRequest::class);
});

test('update book form reqeust valdiates inputs properly', function () {
    $form_reqeust = new BookUpdateRequest();

    $this->assertExactValidationRules($form_reqeust->rules(), [
        'name' => 'required|string|min:1|max:255',
        'ISBN' => 'required|string|min:1|max:255',
        'image' => 'nullable|image|max:2048',
    ]);
});

test('admins can update a book', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    $book = Book::factory()->hasImage()->create();

    Storage::fake('public');
    $data = [
        'name' => fake()->name(),
        'ISBN' => fake()->isbn13(),
        'image' => UploadedFile::fake()->image('test.jpg'),
    ];

    actingAs($user)->patch(route('admin.books.update', $book), $data)->assertRedirect(route('admin.books.show', $book));

    $book->refresh();
    expect($data['name'])->toEqual($book->name);
    expect($data['ISBN'])->toEqual($book->ISBN);
    expect('storage/app/'.$data['image']->getFilename())->toEqual($book->image->path);

    Storage::disk('public')->assertExists($data['image']->getBasename());
});
