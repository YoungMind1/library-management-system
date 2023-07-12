<?php

namespace App\Http\Controllers;

use App\Models\Book;

class HomeController extends Controller
{
    public function home()
    {
        $q = \request()->get('query');
        $books = Book::query();
        if ($q) {
            $books->where('name', 'like', '%'.$q.'%');
        }

        return view('home', ['books' => $books->paginate(10)]);
    }

    public function show(Book $book)
    {
        $book = $book->with('copies')->get()[0];

        return view('books.show', ['book' => $book]);
    }
}
