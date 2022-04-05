<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    /**
     * @return void
     */
    public function store()
    {
        Book::create($this->validateRequest());
    }

    /**
     * @param Book $book
     * @return void
     */
    public function update(Book $book)
    {
        $book->update($this->validateRequest());
    }

    /**
     * validate a book
     * @return array
     */
    private function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author' => 'required',
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();
    }
}
