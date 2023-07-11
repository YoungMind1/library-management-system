<?php

use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use Spatie\Permission\Models\Role;

test('guests cannot visit edit page', function () {
    $user = User::factory()->create();

    get(route('admin.users.edit', $user))->assertRedirect(route('login'));
});

test('normal users cannot visit edit page', function () {
    $user = User::factory()->create();

    $to_be_edited_user = User::factory()->create();

    actingAs($user)->get(route('admin.users.edit', $to_be_edited_user))->assertForbidden();
});

test('guests cannot edit user', function () {
    $to_be_edited_user = User::factory()->create();

    patch(route('admin.users.update', $to_be_edited_user))->assertRedirect(route('login'));
});

test('normal users cannot edit user', function () {
    $user = User::factory()->create();

    $to_be_edited_user = User::factory()->create();

    actingAs($user)->patch(route('admin.users.update', $to_be_edited_user))->assertForbidden();
});

test('admins cannot visit edit page of a non-existent user', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    actingAs($user)->get(route('admin.users.edit', 404))->assertNotFound();
});

test('admins cannot edit a non-existent user', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    actingAs($user)->patch(route('admin.users.update', 404))->assertNotFound();
});

test('admins can visit edit page of a user', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    $to_be_edited_user = User::factory()->create();

    actingAs($user)->get(route('admin.users.edit', $to_be_edited_user))->assertOk();
});

test('edit user endpoint uses the appropriate form request', function () {
    $this->assertRouteUsesFormRequest('admin.users.update', UserUpdateRequest::class);
});

test('update user form reqeust valdiates inputs properly', function () {
    $form_reqeust = new UserUpdateRequest();

    $this->assertExactValidationRules($form_reqeust->rules(), [
        'name' => 'required|string|min:1|max:255',
        'email' => 'required|string|unique:users,email,|email',
        'phone' => 'required|string|unique:users,phone,|min:10|max:20',
    ]);
});

test('admins can update a user', function () {
    $user = User::factory()->hasAttached(Role::query()->where('name', 'admin')->first())->create();

    $to_be_edited_user = User::factory()->create();

    $data = [
        'name' => fake()->name(),
        'phone' => fake()->phoneNumber(),
        'email' => fake()->email(),
    ];
    while (User::query()->where('phone', $data['phone'])->whereKeyNot($to_be_edited_user->id)->exists()) {
        $data['phone'] = fake()->unique()->phoneNumber();
    }

    while (User::query()->where('email', $data['email'])->whereKeyNot($to_be_edited_user->id)->exists()) {
        $data['email'] = fake()->unique()->email();
    }

    actingAs($user)->patch(route('admin.users.update', $to_be_edited_user), $data)->assertRedirect(route('admin.users.show', $to_be_edited_user));

    $to_be_edited_user->refresh();
    expect($data['name'])->toEqual($to_be_edited_user->name);
    expect($data['email'])->toEqual($to_be_edited_user->email);
    expect($data['phone'])->toEqual($to_be_edited_user->phone);
});
