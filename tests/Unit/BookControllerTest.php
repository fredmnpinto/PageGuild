<?php

namespace Tests\Unit;

use App\Models\Book;
use App\Models\AuthorBook;
use App\Models\GenreBook;

use App\Http\Controllers\BookController;

use Tests\TestCase;

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

        $this->assertNotEmpty(BookController::getBookGenres($book_id), "A função BookController::getBookAuthors não pode retornar null!");
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

        // Estas variaveis são usadas para filtrar na query, portanto convem serem do livro escolhido
        $book_first_author = AuthorBook::where('book_item_id','=', $book->item_id)->first()->author_id;
        $book_first_genre = GenreBook::where('book_item_id','=',$book->item_id)->first()->genre_id;

        $book_title = $book->title;

        $this->assertEquals($book_title, 
                            BookController::buildSearchBooksQuery($book_title,["title"], $book_first_author, $book_first_genre, $book->publisher_id, $book->publication_year)->first()->title,
                            "A função BookController::buildSearchBooksQuery não está a funcionar corretamente!");
    }
}
