<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     * @test
     * @return void
     */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post(route('books.store'), [
            'title' => 'cool book title',
            'author' => 'victor'
        ]);
        $response->assertOk();
        $this->assertCount(1, Book::all());
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
        $book = Book::first();
        $this->assertEquals('new Title', $book->title);
        $this->assertEquals('new Title', $book->author);
        $response->assertOk();
        $this->assertCount(1, Book::all());
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
        $book = Book::first();
    }
}
