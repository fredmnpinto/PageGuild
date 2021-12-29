<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\GenreBook;
use App\Models\AuthorBook;
use App\Models\Genre;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Retorna um array com todos os livros que tenham uma relacao cujo nome contenha a substring pesquisada e aplicado o filtro(se for o caso)
     * 
     * @author Gabriel
     * 
     * @param string $substring
     * @param array $filter
     * 
     * @return $results
     * 
     */
    public static function searchBooks($substring, $filters) {
        return DB::table('author')
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
                        ->orwhere('book.title','like','%'.$substring.'%') // Procura por titulos
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
                    ->get();
    }

    /**
     * Returns array of authors of specified book
     * 
     * @param int $item_id
     * @return $author
     */
    public static function getBookAuthors($item_id) {
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
    public static function getBookGenres($item_id) {
        $genreBook = GenreBook::where('book_item_id', $item_id)->get();

        $genre = array();

        // Lista todos os generos do livro
        foreach($genreBook as $row) {
            $genre[] = Genre::find($row->genre_id);
        }

        return $genre;
    }
}
