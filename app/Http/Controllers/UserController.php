<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index', ['users' => User::query()->paginate(10)]);
    }

    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    public function update(User $user, UserUpdateRequest $request)
    {
        try {
            $user->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
            ]);

        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect(route('admin.users.edit', $user))->withErrors($th->getMessage());
        }

        return redirect(route('admin.users.show', $user), 201);
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect('/admin/usres', 500);
        }

        return redirect(route('admin.users.index'));
    }
}
