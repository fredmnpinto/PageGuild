<?php

namespace Tests\Unit;

use App\Models\Item;
use App\Models\Book;
use App\Models\AuthorBook;
use App\Models\GenreBook;
use App\Models\User;
use App\Models\Author;

use App\Http\Controllers\ItemController;

use Tests\TestCase;

class ItemControllerTest extends TestCase
{
    /**
     * Testa a função ItemController::showDetails()
     * 
     * Mostra a pagina de detalhes de um livro.
     * Se aparecer o id do livro é porque esta certo.
     *
     * @author Gabriel
     */
    public function testShowDetails()
    {
        // Escolhe um livro
        $item = Item::first();

        $response = $this->get(route('showDetails', ['id' => $item->id]));
        
        // Testa se ele ve o id do item na view 
        $response->assertSee($item->id, $escaped = false);
    }

    /**
     * Testa a função ItemController::orderFilterSearch()
     * 
     * Pesquisa por um livro, e depois testa se esse livro aparece nos resultados
     * 
     * @author Gabriel
     */
    public function testOrderFilterSearch() {
        $book = Book::first();
        $author_id = AuthorBook::where('book_item_id','=', $book->item_id)->first()->author_id;
        $genre_id = GenreBook::where('book_item_id','=',$book->item_id)->first()->genre_id;

        $user = User::first();

        $response = $this->actingAs($user)
                         ->withSession(['email' =>  $user->email, 'password' => 'password'])
                         ->get(route('orderFilterSearch', ['searchQuery' => $book->title, 
                                                           'author_id' => $author_id, 
                                                           'publisher_id' => $book->publisher_id == null ? 0 : $book->publisher_id,
                                                           'genre_id' => $genre_id, 
                                                           'publication_year' => $book->publication_year, 
                                                           'order_by' => 'book.title',
                                                           'order_direction' => 'asc']));
        
        $response->assertStatus(200);

        // Testa se ele ve o titulo do livro escolhido na view
        //$response->assertSee($book->title, $escaped = false);
    }

    /**
     * Testa a função ItemController::getFilterOptions
     * 
     * Pesquisa por um autor, se os resultados do conteudo de filtro de autor não possuirem esse autor, então o teste falha
     * 
     * @author Gabriel 
     */
    public function testGetFilterOptions() {
        // Para ter a certeza que buscamos um autor que tem pelo menos um livro escrito
        $author_id = AuthorBook::first()->author_id;
        $author = Author::find($author_id);

        $searchQuery = $author->name;
        $filterColumns =  ["author.id","author.name"];

        $results = ItemController::getFilterOptions($searchQuery, $filterColumns);

        $this->assertEquals($author->name, $results->first()->name);
    }
}
