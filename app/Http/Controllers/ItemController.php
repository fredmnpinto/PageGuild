<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Item;
use App\Models\AuthorBook;
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
                //$genres = BookGenre::where('item_id', $id);    

                // Vai buscar o editor
                $publisher = Publisher::find($book->publisher_id);

                // Vai buscar o idioma
                $language = Language::find($book->language_id);

                return view('bookDetails', ['item' => $item,
                                            'itemType' => $itemType,  
                                            'book' => $book,
                                            'authors' => $authors,
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

        foreach($authorBook as $row) {
            $author[] = Author::find($row->author_id);
        }

        return $author;
    }
}
