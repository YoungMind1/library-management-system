<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Copy;
use App\Models\User;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Book::factory(10)->has(
            Copy::factory(10)
                ->hasAttached(
                    $users->random(1),
                    [
                        'due_date' => now()->addWeeks(2),
                        'created_at' => now(),
                    ]
                )
        )->create();
    }
}
