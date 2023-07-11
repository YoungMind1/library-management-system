<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /* public function index() */
    public function index()
    {
        $categories = Category::query()->paginate();

        return view('categories.index', ['categories' => $categories]);
    }

    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();
        try {
            $category = Category::query()->create([
                'name' => $data['name'],
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect('/admin/categories', 500);
        }

        return redirect('admin.categories.index', 201);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect('/admin/category', 500);
        }

        return redirect(route('admin.categories.index'));
    }

    public function edit(Category $category)
    {
        return view('categories.edit', ['category' => $category]);
    }

    public function update(Category $category, CategoryUpdateRequest $request)
    {
        $data = $request->validated();
        try {
            $category = Category::query()->update([
                'name' => $data['name'],
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage(), $th->getTrace());

            return redirect('/admin/categories', 500);
        }

        return redirect(route('admin.categories.index'));
    }
}
