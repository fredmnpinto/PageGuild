<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Http\Controllers\BookController;

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookControllerTest extends TestCase
{
    /**
     * Testa a função BookController::getBookAuthors()
     * 
     * Se a função retonar null o teste falha, pois todos os livros deveriam ter pelo menos um autor. Ou seja, algo falhou.
     * 
     * @author Gabriel
     */
    public function testGetBookAuthors() {
        $book_id = Book::first()->item_id;

        $this->assertNotEmpty(BookController::getBookAuthors($book_id), "A função BookController::getBookAuthors não pode retornar null!");
    }

    /**
     * Testa a função BookController::getBookGenres()
     * 
     * Se a função retornar null o teste falha, pois todos os livros deveriam ter pelo menos um genre. Ou seja, algo falhou.
     * 
     * @author Gabriel
     */
    public function testGetBookGenres() {
        $book_id = Book::first()->item_id;

        $this->assertNotEmpty(BookController::getBookAuthors($book_id), "A função BookController::getBookAuthors não pode retornar null!");
    }

    /**
     * Testa a função BookController::buildSearchBookQuery()
     * 
     * Se o titulo de um livro escolhido for diferente do livro pesquisado na query e porque deu algum erro
     * 
     * @author Gabriel
     * 
     */
    public function testBuildSearchBooksQuery() {
        $book = Book::first();
        $book_title = $book->title;

        $this->assertEquals($book_title, 
                            BookController::buildSearchBooksQuery($book_title,["title"], 0, 0, $book->publisher_id, $book->publication_year)->first()->title,
                            "A função BookController::buildSearchBooksQuery não está a funcionar corretamente!");
    }
}
