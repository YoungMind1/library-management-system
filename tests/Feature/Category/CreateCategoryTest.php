<?php

use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use Spatie\Permission\Models\Role;

test('create category page cannot be rendered by normal users', function () {
    $user = User::factory()->create();

    actingAs($user)->get('admin/categories/create')->assertForbidden();
});

test('create category page cannot be rendered by guests', function () {
    get('admin/categories/create')->assertRedirect('/login');
});

test('create category page can be rendered by admin', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $response = actingAs($user)->get('admin/categories/create');

    $response->assertStatus(200);
});

test('normal user cannot create category', function () {
    $user = User::factory()->create();

    $response = actingAs($user)->post('admin/categories', [
        'date' => 'data',
    ])->assertForbidden();
});

test('guets cannot create category', function () {

    post('admin/categories', [
        'date' => 'data',
    ])->assertRedirect('/login');
});

test('create category endpoint uses the appropriate form request', function () {
    $this->assertRouteUsesFormRequest('admin.categories.store', CategoryStoreRequest::class);
});

test('create category form reqeust valdiates inputs properly', function () {
    $form_reqeust = new CategoryStoreRequest();

    $this->assertExactValidationRules($form_reqeust->rules(), [
        'name' => 'required|string|unique:categories|max:255',
    ]);
});

test('admin can create category', function () {
    $user = User::factory()->create();
    $user->roles()->attach(Role::findByName('admin'));

    $data = [
        'name' => fake()->name(),
    ];
    while (Category::query()->where('name', $data['name'])->exists()) {
        $data['name'] = fake()->unique()->name();
    }

    actingAs($user)->post('admin/categories', $data)->assertStatus(201);

    $category = Category::query()->latest()->first();
    expect($data['name'])->toEqual($category->name);

});
