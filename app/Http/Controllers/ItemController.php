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
                $authors = ItemController::getBookAuthors($id);
                $genres = ItemController::getBookGenres($id);    

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
     * Returns array of authors of specified book
     * 
     * @param int $item_id
     * @return $author
     */
    private function getBookAuthors($item_id) {
        $authorBook = AuthorBook::where('book_item_id', $item_id)->get();

        $author = array();

        //Lista todos os autores do livro
        foreach($authorBook as $row) {
            $author[] = Author::find($row->author_id);
        }

        return $author;
    }

    /**
     * Returns array of genres of specified book
     * 
     * @param int $item_id
     * @return $genre
     */
    private function getBookGenres($item_id) {
        $genreBook = GenreBook::where('book_item_id', $item_id)->get();

        $genre = array();

        // Lista todos os generos do livro
        foreach($genreBook as $row) {
            $genre[] = Genre::find($row->genre_id);
        }

        return $genre;
    }

    /**
     * Search items by item type
     */
    public function searchItems(Request $request) {
        //Procura por todas as referencias relacionadas aos livros
        $bookResults =  ItemController::searchBooks($request->search);

        return view('search/results', ['bookResults' => $bookResults]);
    }

    /**
     * Search books that contains the substring searched.
     * Search books by title, by authors, by idiom, etc... 
     * 
     * @param string $substring
     * 
     * @return $books 
     */
    private function searchBooks($substring) {
            /**
             * Procura por todos os livros que tenham uma referencia(coluna) que contenha a substring.
             * Ex.: Titulos, isbn, autores do livro com um nome que contenha a substring, editores, etc...  
             * 
             * 
             * Obs.: Não sei o que significa as percentagens. So sei que precisa delas e do like para funcionar.
             * 
             * @author Gabriel
             */
            $books = Book::where('title','like','%'.$substring.'%') // Procura por titulos
                        ->orWhere('isbn','like','%'.$substring.'%') // Procura por isbn
                        ->get();

           

            return $books;
    }


}
