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
        return ItemController::searchItems($request->search, ['null','null']);
    }

    public function filterSearch($substring, $author_id, $publisher_id) {
        return ItemController::searchItems($substring, [$author_id, $publisher_id]);
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
        $results = BookController::searchBooks($substring, $filters);

        $authorFilterContent = ItemController::getFilterContent($substring, ['author.id','author.name'], $filters);
        $publisherFilterContent = ItemController::getFilterContent($substring, ['publisher.id','publisher.name'], $filters);

        return view('search/results', ['substring' => $substring, 'results' => $results, 'authorsFilterContent' => $authorFilterContent, 'publisherFilterContent' => $publisherFilterContent]);
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
        return DB::table('author')
                    ->select($selectArgs[0], $selectArgs[1], DB::raw('count('.$selectArgs[0].')'))
                    ->leftjoin('author_book', 'author.id','=','author_book.author_id')
                    ->leftjoin('book', 'book.item_id','=','author_book.book_item_id')
                    ->leftjoin('publisher','publisher.id','=','book.publisher_id')

                    /**
                     * Para agrupar todos os orwhere num so where. Isto e importante para os filtros.
                     * O equivalente em sql seria colocar estes wheres todos dentro de um parenteses
                     * @author Gabriel
                     */
                    ->where( function ($query) use ($substring) {
                        $query
                        /**
                        * Procura por todos os livros que tenham uma referencia(coluna) que contenha a substring.
                        * Ex.: Titulos, isbn, autores do livro com um nome que contenha a substring, editores, etc...  
                        * 
                        * 
                        * Obs.: Não sei o que significa as percentagens. So sei que precisa delas e do like para funcionar.
                        * 
                        * @author Gabriel
                        */
                        ->where('book.title','like','%'.$substring.'%') // Procura por titulos
                        ->orWhere('book.isbn','like','%'.$substring.'%') // Procura por isbn

                        /**
                        * Procura por todos os autores que o nome contenha a substring.
                        * 
                        * Obs.: Não sei o que significa as percentagens. So sei que precisa delas e do like para funcionar.
                        * 
                        * @author Gabriel
                        */
                        ->orWhereIn('item_id', AuthorBook::whereIn('author_id', Author::where('name','like','%'.$substring.'%')
                                                                                    ->get('id'))
                                                        ->get('book_item_id'));
                    })
                    /**
                     * Parte onde são aplicados os filtros
                     */
                    ->where( function ($query) use ($filters) {
                        if($filters[0] != 'null') {
                            $query->where('author.id', '=', $filters[0]); 
                        }
                        if($filters[1] != 'null') {
                            $query->where('publisher.id', '=', $filters[1]);
                        }
                    })
                    /**
                     * Agrupa por id's
                     */
                    ->groupBy($selectArgs[0])
                    ->get();
    }
}