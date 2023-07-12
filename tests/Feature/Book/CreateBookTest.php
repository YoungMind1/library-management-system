<?php

use App\Http\Requests\Book\BookStoreRequest;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use Spatie\Permission\Models\Role;

test('create book page cannot be rendered by normal users', function () {
    $user = User::factory()->create();

    actingAs($user)->get('admin/books/create')->assertForbidden();
});

test('create book page cannot be rendered by guests', function () {
    get('admin/books/create')->assertRedirect('/login');
});

test('create book page can be rendered by admin', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $response = actingAs($user)->get('admin/books/create');

    $response->assertStatus(200);
});

test('normal user cannot create book', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->post('admin/books', [
        'date' => 'data',
    ])->assertForbidden();
});

test('guets cannot create book', function () {

    post('admin/books', [
        'date' => 'data',
    ])->assertRedirect('/login');
});

test('create book endpoint uses the appropriate form request', function () {
    $this->assertRouteUsesFormRequest('admin.books.store', BookStoreRequest::class);
});

test('create book form reqeust valdiates inputs properly', function () {
    $form_reqeust = new BookStoreRequest();

    $this->assertExactValidationRules($form_reqeust->rules(), [
        'name' => 'required|string|min:1|max:255',
        'ISBN' => 'required|string|min:1|max:255',
        'image' => 'nullable|image|max:2048',
        'category' => 'nullable',
    ]);
});

test('admin can create book', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    Storage::fake('public');
    $data = [
        'name' => fake()->name(),
        'ISBN' => fake()->isbn13(),
        'image' => UploadedFile::fake()->image('test.jpg'),
    ];

    actingAs($user)->post('admin/books', $data)->assertStatus(201);

    $book = Book::query()->where('ISBN', $data['ISBN'])->first();
    expect($data['name'])->toEqual($book->name);
    expect($data['ISBN'])->toEqual($book->ISBN);
    expect('storage/'.$data['image']->getFilename())->toEqual($book->image->path);

    Storage::disk('public')->assertExists($data['image']->getBasename());
});
