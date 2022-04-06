<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BooksController extends Controller
{

    public function index()
    {

    }


    public function show(Book $book)
    {

    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $book = Book::create($this->validateRequest());
        return redirect()->route('books.show', ['book' => $book->id]);
    }

    /**
     * @param Book $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Book $book)
    {
        $book->update($this->validateRequest());
        return redirect()->route('books.show', ['book' => $book->id]);
    }

    /**
     * validate a book
     * @return array
     */
    private function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author_id' => 'required',
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index');
    }
}
