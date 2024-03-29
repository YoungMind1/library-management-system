<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/books/{book}', [HomeController::class, 'show'])->name('books.show');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin/')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('books/')->name('books.')->group(function () {
        Route::get('', [BookController::class, 'index'])->name('index');
        Route::get('create', [BookController::class, 'create'])->name('create');
        Route::get('{book}', [BookController::class, 'show'])->name('show');
        Route::get('{book}/edit', [BookController::class, 'edit'])->name('edit');
        Route::post('', [BookController::class, 'store'])->name('store');
        Route::patch('{book}', [BookController::class, 'update'])->name('update');
        Route::delete('{book}', [BookController::class, 'destroy'])->name('destroy');
        Route::delete('{book}/{copy}', [BookController::class, 'removeCopy'])->name('removeCopy');
        Route::post('{book}/add-copy', [BookController::class, 'addCopy'])->name('addCopy');
    });

    Route::prefix('categories/')->name('categories.')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('index');
        Route::get('create', [CategoryController::class, 'create'])->name('create');
        Route::get('{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::post('', [CategoryController::class, 'store'])->name('store');
        Route::patch('{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('users/')->name('users.')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('{user}', [UserController::class, 'show'])->name('show');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::patch('{user}', [UserController::class, 'update'])->name('update');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('lends/')->name('lends.')->group(function () {
        Route::get('', [LendController::class, 'index'])->name('index');
        Route::get('/take-back', [LendController::class, 'takeBackPage'])->name('take-back-page');
        Route::patch('/take-back', [LendController::class, 'takeBack'])->name('take-back');
        Route::get('borrow', [LendController::class, 'borrowPage'])->name('borrow-page');
        Route::post('/borrow', [LendController::class, 'borrow'])->name('borrow');
    });
});

require __DIR__.'/auth.php';
