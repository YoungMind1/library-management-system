<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
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
        $categories = Category::all();

        Book::factory(10)->has(
            Copy::factory(10)
        )->hasImage(1)->create();

        $books = Book::all();

        foreach ($books as $book) {
            $copies = $book->copies->each(function (Copy $copy) use ($users) {
                if (random_int(0, 1)) {
                    $copy->users()->attach($users->random(1), ['updated_at' => now()->subWeek(), 'created_at' => now()->subWeek(), 'due_date' => now()]);
                } elseif (random_int(0, 1)) {
                    $copy->users()->attach($users->random(1), ['due_date' => now()->addWeeks(1)]);
                } elseif (random_int(0, 1)) {
                    $copy->users()->attach($users->random(1), ['updated_at' => now()->subWeek(), 'created_at' => now()->subWeek(), 'due_date' => now(), 'returned' => true]);
                }
            });

            $book->categories()->attach($categories->random(2));
        }
    }
}
