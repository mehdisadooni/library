<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AuthorsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('books', BooksController::class);
Route::resource('authors', AuthorsController::class);
//Route::prefix('books')->name('books.')->group(function () {
//    Route::get('/', [BookController::class, 'index'])->name('index');
//    Route::get('/{book}', [BookController::class, 'show'])->name('show');
//    Route::post('/', [BookController::class, 'store'])->name('store');
//    Route::patch('/{book}', [BookController::class, 'update'])->name('update');
//    Route::delete('/{book}', [BookController::class, 'destroy'])->name('destroy');
//});

