<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookStoreRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $q = \request()->get('query');
        $books = Book::query();
        if ($q) {
            $books->where('name', 'like', '%'.$q.'%');
        }

        return view('books.index', ['books' => $books->paginate()]);
    }

    public function show(Book $book)
    {
        $book = $book->with('copies')->get()[0];

        return view('books.show', ['book' => $book]);
    }

    public function edit(Book $book)
    {
        return view('books.edit', $book);
    }

    public function update(Book $book, Request $request)
    {

    }

    public function destroy(Book $book): RedirectResponse
    {
        try {
            $book->delete();
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect('/admin/books', 500);
        }

        return redirect('admin.books.index');
    }

    public function create()
    {
        $categories = Category::all();

        return view('books.create', ['categories' => $categories]);
    }

    public function store(BookStoreRequest $request): RedirectResponse
    {
        try {
            $book = Book::query()->create([
                'name' => $request->get('name'),
                'ISBN' => $request->get('ISBN'),
            ]);

            $file = Storage::disk('public')->put($request->file('image')->getFilename(), $request->file('image')->get());

            $image = Image::query()->create([
                'storage' => 'public',
                'path' => "storage/app/{$request->file('image')->getFilename()}",
                'mime_type' => $request->file('image')->getMimeType(),
                'size' => $request->file('image')->getSize(),
                'imagable_id' => $book->id,
                'imagable_type' => $book::class,
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect('/admin/books', 500);
        }

        return redirect('/admin/books', 201);
    }
}
