<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post(route('books.store'), $this->data());
        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response->assertRedirect(route('books.show', ['book' => $book->id]));
    }

    /**
     * @test
     * @return void
     */
    public function a_title_is_required()
    {
        $response = $this->post(route('books.store'), array_merge($this->data(), ['title' => '']));
        $response->assertSessionHasErrors('title');
    }

    /**
     * @test
     * @return void
     */
    public function a_author_is_required()
    {
        $response = $this->post(route('books.store'), array_merge($this->data(), ['author_id' => '']));
        $response->assertSessionHasErrors('author_id');
    }

    /**
     * @test
     * @return void
     */
    public function a_book_can_be_updated()
    {
        $author = $this->storeAsAuthor();
        $this->withoutExceptionHandling();
        $this->post(route('books.store'), [
            'title' => 'cool book title',
            'author_id' => $author->id,
        ]);
        $book = Book::first();
        $newAuthor = $this->storeAsAuthor();
        $response = $this->patch(route('books.update', ['book' => $book->id]), [
            'title' => 'new Title',
            'author_id' => $newAuthor->id,
        ]);
        $this->assertEquals('new Title', $book->fresh()->title);
        $this->assertEquals($newAuthor->id, $book->fresh()->author_id);
        $response->assertRedirect(route('books.show', ['book' => $book->id]));
    }

    /**
     * @test
     * @return void
     */
    public function a_book_can_be_deleted()
    {
        $book = $this->storeAsBook();
        $this->assertCount(1, Book::all());
        $response = $this->delete(route('books.destroy', ['book' => $book->id]));
        $this->assertCount(0, Book::all());
        $response->assertRedirect(route('books.index'));
    }


    /**
     * @test
     * @return void
     */
    public function a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        $book = $this->storeAsBook();
        $author = Author::first();
        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());

    }

    /**
     * @return mixed
     */
    private function storeAsAuthor()
    {
        $this->post(route('authors.store'), [
            'name' => 'Mehdi',
        ]);
        return Author::first();
    }

    private function storeAsBook()
    {
        $this->post(route('books.store'), $this->data());
        return Book::first();
    }

    private function data()
    {
        $author = $this->storeAsAuthor();
        return [
            'title' => 'cool book title',
            'author_id' => $author->id,
        ];
    }
}
