<?php

namespace App\Http\Controllers;

use App\Models\Book;

class HomeController extends Controller
{
    public function __invoke()
    {
        $q = \request()->get('s');
        $books = Book::query();
        if ($q) {
            $books->where('name', 'like', '%'.$q.'%');
        }

        return view('home', ['books' => $books->paginate()]);
    }
}
