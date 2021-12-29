<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Item;
use App\Models\AuthorBook;
use App\Models\GenreBook;
use App\Models\Genre;
use App\Models\ItemType;
use App\Models\Publisher;
use App\Models\Language;
use App\Models\Author;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;

class ItemController extends Controller
{
    /**
     * Returns item type detail page of specific item
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showDetails($id)
    {
        // Vai buscar o item e o tipo do item
        $item = Item::find($id);
        $itemType = ItemType::find($item->item_type_id);

        // Procura por tipo de artigo
        switch($item->item_type_id) {
            case 1: { // Livro
                $book = Book::find($id);

                // No caso do livro vai buscar ainda os authors e os genres
                $authors = BookController::getBookAuthors($id);
                $genres = BookController::getBookGenres($id);    

                // Vai buscar o editor
                $publisher = Publisher::find($book->publisher_id);

                // Vai buscar o idioma
                $language = Language::find($book->language_id);

                return view('bookDetails', ['item' => $item,
                                            'itemType' => $itemType,  
                                            'book' => $book,
                                            'authors' => $authors,
                                            'genres' => $genres,
                                            // Verifica se o publisher existe. Se sim, envia o nome
                                            'publisher' => $publisher == null ? "Não tem" : $publisher->name,
                                            'language' => $language
                                            ]);
            }
            case 2: {
                //
            }
        }
    }

    /**
     * Funcao chamada quando efetuamos uma pesquisa sem filtros
     * Funcao chamada pela rota /search/results
     */
    public function unfilteredSearch(Request $request) {
        return ItemController::searchItems($request->search, [0,0,0,0]);
    }

    /**
     * Funcao chamada quando efetuamos uma pesquisa com filtros
     * Funcao chamada pela rota /search/results/filter/
     */
    public function filterSearch($substring, $author_id, $publisher_id, $genre_id, $publication_year) {
        return ItemController::searchItems($substring, [$author_id, $publisher_id, $genre_id, $publication_year]);
    }

    /**
     * Procura por todos os tipos de item
     * Procura tambem resultados por filtro
     * 
     * @param $substring
     * @param $filter - Array com o tipo de filtro, e id do filtro(id do autor, id do editor, etc...) que esta a ser aplicado aos resultados. Por default e null para ignorar a filtragem
     * 
     * @author Gabriel
     */
    private function searchItems($substring, $filters) {
        /** 
         * Procura por todas as referencias relacionadas aos livros
         */
        $results = BookController::searchBooks($substring, ['book.item_id', 'book.title'], $filters)->get();

        /**
         * Vai buscar todos os filtros que sao possiveis aplicar aos resultados
         */
        $authorFilterContent = ItemController::getFilterContent($substring, ['author.id','author.name'], $filters);
        $publisherFilterContent = ItemController::getFilterContent($substring, ['publisher.id','publisher.name'], $filters);
        $genreFilterContent = ItemController::getFilterContent($substring, ['genre.id','genre.name'], $filters);
        $yearFilterContent = ItemController::getFilterContent($substring, ['book.publication_year', 'book.publication_year'], $filters);
        //$priceFilterContent = ItemController::getFilterContent($substring, ['book.publication_year'], $filters);
        //$availableFilterContent = ItemController::getFilterContent($substring, ['book.publication_year'], $filters);

        /**
         * Aqui são guardadados todos os dados do url atual
         * E utilizado para manter filtros.
         * Por exemplo.: search/results/filter/{substring}/1/0, ele vai filtrar os resultados de substring pelos livros escritos por o autor.id = 1
         *               sarch/results/filter/{substring}/1/1, aos resultados anteriores ele vai aplicar um novo filtro pelos livros publicados pela publisher.id = 1
         * 
         * Quando o valor e 0 significa que nenhum filtro foi aplicado
         * 
         * @author Gabriel
         */
        $url = array($substring, $filters[0], $filters[1], $filters[2], $filters[3]);

        return view('search/results', ['url' => $url, 'results' => $results, 'authorsFilterContent' => $authorFilterContent, 'publisherFilterContent' => $publisherFilterContent, 'genreFilterContent' => $genreFilterContent, 'yearFilterContent' => $yearFilterContent]);
    }

    /**
     * Faz exatamente a mesma pesquisa de resultados de livros (BookController::searchBooks())
     * Porem, busca o id, nome e numero de resultados escritos por x autor/editor/etc..
     * Em termos de SQL e adicionado o select() e um groupBy().
     * 
     * Esta função serve para popular o accordion dos diversos filtros (autores, editores, etc...)
     * 
     * @author Gabriel
     */
    private function getFilterContent($substring, $selectArgs, $filters) {
        return BookController::searchBooks($substring, $selectArgs, $filters)
                /**
                * Agrupa por id's
                */
                ->groupBy($selectArgs[0])
                /**
                * Adiciona um count
                */
                ->addSelect(DB::raw('count('.$selectArgs[0].')'))
                ->get();
    }
}