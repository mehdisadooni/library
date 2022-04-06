<?php

namespace Tests\Unit;


use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_id_is_recorded()
    {
        $author = $this->storeAsAuthor();
        Book::create([
            'title' => 'Cool title',
            'author_id' => $author->id,
        ]);
        $this->assertCount(1, Book::all());
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

}
