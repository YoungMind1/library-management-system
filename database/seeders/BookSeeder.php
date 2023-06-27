<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Copy;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::factory(10)->has(
            Copy::factory()
                ->count(10)
                ->state(function (array $attributes, Book $book) {
                    return ['book_id', $book->id];
                })
        )->create();
    }
}
