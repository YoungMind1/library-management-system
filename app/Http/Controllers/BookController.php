<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Models\Book;
use App\Models\Category;
use App\Models\Copy;
use App\Models\Image;
use Illuminate\Http\RedirectResponse;
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

        return view('books.index', ['books' => $books->paginate(10)]);
    }

    public function show(Book $book)
    {
        return view('books.show', ['book' => $book]);
    }

    public function edit(Book $book)
    {
        return view('books.edit', ['book' => $book]);
    }

    public function update(Book $book, BookUpdateRequest $request)
    {
        try {
            $old_path = $book->image->path;

            $book->update([
                'name' => $request->get('name'),
                'ISBN' => $request->get('ISBN'),
            ]);

            if ($request->hasFile('image')) {
                $file = Storage::disk('public')->put($request->file('image')->getFilename(), $request->file('image')->get());

                $book->image()->getQuery()->update([
                    'storage' => 'public',
                    'path' => "storage/{$request->file('image')->getFilename()}",
                    'mime_type' => $request->file('image')->getMimeType(),
                    'size' => $request->file('image')->getSize(),
                    'imagable_id' => $book->id,
                    'imagable_type' => $book::class,
                ]);
            } else {
                $book->image()->getQuery()->delete();
            }

            //remove the old one
            Storage::disk('public')->delete($old_path);
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect('/admin/books/create')->withErrors($th->getMessage());
        }

        return redirect(route('admin.books.show', $book), 201);
    }

    public function destroy(Book $book): RedirectResponse
    {
        try {
            $book->delete();
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect('/admin/books', 500);
        }

        return redirect(route('admin.books.index'));
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

            if ($request->hasFile('image')) {
                $file = Storage::disk('public')->put($request->file('image')->getFilename(), $request->file('image')->get());

                $image = Image::query()->create([
                    'storage' => 'public',
                    'path' => "storage/{$request->file('image')->getFilename()}",
                    'mime_type' => $request->file('image')->getMimeType(),
                    'size' => $request->file('image')->getSize(),
                    'imagable_id' => $book->id,
                    'imagable_type' => $book::class,
                ]);
            }

        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect('/admin/books/create')->withErrors($th->getMessage());
        }

        return redirect('/admin/books', 201);
    }

    public function addCopy(Book $book)
    {
        $book->copies()->create();

        return redirect()->back();
    }

    public function removeCopy(Book $book, Copy $copy)
    {
        if ($copy->users()->getQuery()->where('returned', false)->exists()) {
            return redirect()->back()->withErrors('Someone is holding this copy, we cannot delete it');
        }

        $copy->delete();

        return redirect()->back();
    }
}
