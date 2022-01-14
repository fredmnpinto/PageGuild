<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\GenreBook;
use App\Models\AuthorBook;
use App\Models\Genre;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Query de searchBooks.
     * Faz a pesquisa com filtros(se especificados)
     *
     * Ele procura por todos as referencias de livros que contenham a substring.
     * Por exemplo.: Se pesquisarmos 's', ela vai procura por livros com 's' no titulo, livros escritos por um autor que tenha 's' no nome, etc...
     *
     *
     * @param string $searchQuery - Substring a ser pesquisada
     * @param array $selectArgs - Parametros do select(Aquilo que vamos buscar a base de dados)
     * @param array $filter - Filtros
     *
     * @return Builder
     *
     */
    public static function buildSearchBooksQuery(string $searchQuery, array $selectArgs,
                                                 int    $author_id = null, int $genre_id = null, int $publisher_id = null,
                                                 int    $year = null): Builder
    {
        $query = DB::table('book')
        ->select($selectArgs) // Podemos passar um array de tamanho indefinido
        ->leftjoin('author_book', 'book.item_id','=','author_book.book_item_id')
        ->leftjoin('author', 'author.id','=','author_book.author_id')
        ->leftjoin('genre_book', 'book.item_id', '=', 'genre_book.book_item_id')
        ->leftjoin('genre', 'genre.id', '=', 'genre_book.genre_id')
        ->leftjoin('publisher','publisher.id','=','book.publisher_id')
            ->join('item', 'item.id', '=', 'book.item_id');

        /**
        * Para agrupar todos os orwhere num so where. Isto e importante para os filtros.
        * O equivalente em sql seria colocar estes wheres todos dentro de um parenteses
        * @author Gabriel
        */
        $query = $query->where( function ($query) use ($searchQuery) {
           $query
           /**
           * Procura por todos os livros que tenham uma referencia(coluna) que contenha a substring.
           * Ex.: Titulos, isbn, autores do livro com um nome que contenha a substring, editores, etc...
           */
           ->orWhere('book.title','ilike',"%{$searchQuery}%") // Procura por titulos
           ->orWhere('book.isbn','ilike',"%{$searchQuery}%") // Procura por isbn

           /**
           * Procura por todos os autores que o nome contenha a substring.
           */
           ->orWhere('author.name', 'ilike', "%{$searchQuery}%");
       });

        /**
        * Parte onde são aplicados os filtros
        */
        $query = $query->where(function ($query) use ($author_id, $publisher_id, $genre_id, $year) {
            if ($author_id != null) {
                $query->where('author.id', '=', $author_id);
            }
            if ($publisher_id != null) {
                $query->where('publisher.id', '=', $publisher_id);
            }
            if ($genre_id != null) {
                $query->where('genre.id', '=', $genre_id);
            }
            if ($year != null) {
                $query->where('book.publication_year', '=', $year);
            }
        });

        $query->where('item.flag_delete', '=', false);

        return $query;
    }

    /**
     * Returns array of authors of specified book
     *
     * @param int $item_id
     * @return array $authors
     */
    public static function getBookAuthors($item_id) {
        $authorBook = AuthorBook::where('book_item_id', $item_id)->get();

        $authors = array();

        //Lista todos os autores do livro
        foreach($authorBook as $row) {
            $authors[] = Author::find($row->author_id);
        }

        return $authors;
    }

    /**
     * Returns array of genres of specified book
     *
     * @param int $item_id
     * @return array $genres
     */
    public static function getBookGenres($item_id): array
    {
        $genreBook = GenreBook::where('book_item_id', $item_id)->get();

        $genres = array();

        // Lista todos os generos do livro
        foreach($genreBook as $row) {
            $genres[] = Genre::find($row->genre_id);
        }

        return $genres;
    }

    public static function getBooks($numberOfBooks) {
        $books = Book::join('item', 'item.id', '=', 'book.item_id')
                    ->where('item.flag_delete', '=', false)
                    ->paginate($numberOfBooks);

        return $books;
    }
}
