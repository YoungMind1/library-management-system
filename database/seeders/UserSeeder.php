<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $user = User::factory(state: ['email' => 'admin@admin.com'])->create();

        $user->roles()->attach(Role::query()->where('name', 'admin')->first());
    }
}
