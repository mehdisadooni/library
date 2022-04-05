<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post(route('books.store'), [
            'title' => 'cool book title',
            'author' => 'victor'
        ]);
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
        $response = $this->post(route('books.store'), [
            'title' => '',
            'author' => 'victor'
        ]);
        $response->assertSessionHasErrors('title');
    }

    /**
     * @test
     * @return void
     */
    public function a_author_is_required()
    {
        $response = $this->post(route('books.store'), [
            'title' => 'cool book title',
            'author' => ''
        ]);
        $response->assertSessionHasErrors('author');
    }

    /**
     * @test
     * @return void
     */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->post(route('books.store'), [
            'title' => 'cool book title',
            'author' => 'victor'
        ]);
        $book = Book::first();
        $response = $this->patch(route('books.update', ['book' => $book->id]), [
            'title' => 'new Title',
            'author' => 'new Title'
        ]);
        $this->assertEquals('new Title', $book->fresh()->title);
        $this->assertEquals('new Title', $book->fresh()->author);
        $response->assertRedirect(route('books.show', ['book' => $book->id]));
    }

    /**
     * @test
     * @return void
     */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post(route('books.store'), [
            'title' => 'cool book title',
            'author' => 'victor'
        ]);
        $this->assertCount(1, Book::all());
        $book = Book::first();
        $response = $this->delete(route('books.destroy', ['book' => $book->id]));
        $this->assertCount(0, Book::all());
        $response->assertRedirect(route('books.index'));
    }
}
