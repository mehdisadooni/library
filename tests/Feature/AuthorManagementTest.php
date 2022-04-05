<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @return void
     */
    public function an_author_can_be_created()
    {
        $this->post(route('authors.store'), [
            'name' => 'Author name',
            'dob' => '08/15/1998',
        ]);
        $authors = Author::all();
        $this->assertCount(1, $authors);
        $this->assertInstanceOf(Carbon::class, $authors->first()->dob);
        $this->assertEquals('1998/15/08', $authors->first()->dob->format('Y/d/m'));
    }
}
