<?php

use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use Spatie\Permission\Models\Role;

test('guests cannot visit edit page', function () {
    $category = Category::factory()->create();

    get(route('admin.categories.edit', $category))->assertRedirect(route('login'));
});

test('normal users cannot visit edit page', function () {
    $user = User::factory()->create();

    $category = Category::factory()->create();

    actingAs($user)->get(route('admin.categories.edit', $category))->assertForbidden();
});

test('guests cannot edit category', function () {
    $category = Category::factory()->create();

    patch(route('admin.categories.update', $category))->assertRedirect(route('login'));
});

test('normal users cannot edit category', function () {
    $user = User::factory()->create();

    $category = Category::factory()->create();

    actingAs($user)->patch(route('admin.categories.update', $category))->assertForbidden();
});

test('admins cannot visit edit page of a non-existent category', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    actingAs($user)->get(route('admin.categories.edit', 404))->assertNotFound();
});

test('admins cannot edit a non-existent category', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    actingAs($user)->patch(route('admin.categories.update', 404))->assertNotFound();
});

test('admins can visit page of a category', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    $category = Category::factory()->create();

    actingAs($user)->get(route('admin.categories.edit', $category))->assertOk();
});

test('edit cateogyr endpoint uses the appropriate form request', function () {
    $this->assertRouteUsesFormRequest('admin.categories.update', CategoryUpdateRequest::class);
});

test('update category form reqeust valdiates inputs properly', function () {
    $form_reqeust = new CategoryUpdateRequest();

    $this->assertExactValidationRules($form_reqeust->rules(), [
        'name' => 'required|string|unique:categories,name,|max:255',
    ]);
});

test('admins can update a category', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    $category = Category::factory()->create();

    $data = [
        'name' => fake()->name(),
    ];

    actingAs($user)->patch(route('admin.categories.update', $category), $data)->assertRedirect(route('admin.categories.index'));

    $category->refresh();
    expect($data['name'])->toEqual($category->name);
});
