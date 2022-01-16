<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\GenreBook;
use App\Models\AuthorBook;
use App\Models\Genre;

use App\Models\Item;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\UserItem;
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
                                                 int    $year = null, int $user_id = null): Builder
    {
        $query = DB::table('book')
            /* TODO: Trocar os leftjoins por joins */
        ->select($selectArgs) // Podemos passar um array de tamanho indefinido
        ->leftjoin('author_book', 'book.item_id','=','author_book.book_item_id')
        ->leftjoin('author', 'author.id','=','author_book.author_id')
        ->leftjoin('genre_book', 'book.item_id', '=', 'genre_book.book_item_id')
        ->leftjoin('genre', 'genre.id', '=', 'genre_book.genre_id')
        ->leftjoin('publisher','publisher.id','=','book.publisher_id')
            ->leftJoin('user_item', 'user_item.item_id', '=', 'book.item_id')
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
        $query = $query->where(function ($query) use ($user_id, $author_id, $publisher_id, $genre_id, $year) {
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
            if ($user_id != null) {
                $query->where('user_item.user_id', '=', $user_id);
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

    /**
     * Metodo para criar um novo livro
     *
     * Method = POST
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'synopsis' => 'required',
            'price' => 'required|numeric|min:1',
            'authors' => 'required|different:-1',
            'isbn' => 'required|unique:book,isbn|numeric|min:0',
            'num_pages' => 'required|numeric|min:1',
            'language_id' => 'required|exists:language,id',
        ]);

        /* Cria o item que estara associado ao livro */
        $item_id = Item::create([
            'name' => $request->get('title'),
            'price' => $request->get('price'),
            'item_type_id' => 1, /* Livro */
        ])->id;

        /* Cria o livro em si */
        $bookAttr = $request->all();
        $bookAttr['item_id'] = $item_id;

        Book::create($bookAttr);

        /* Associa o item ao usuario */
        $userItem = new UserItem;
        $userItem->item_id = $item_id;
        $userItem->user_id = $request->user()->id;
        $userItem->save();

        /* Associa cada autor ao livro */
        /*foreach($request->get('authors') as $author_id) {
            $authorBook = new AuthorBook;
            $authorBook->author_id = $author_id;
            $authorBook->book_item_id = $item_id;
            $authorBook->save();
        }*/

        /* Por motivos de input não encontrei a tempo
         maneira de fazer o input de multiplos autores então,
        por enquanto farei com um único */
        $author_id = $request->get('authors');
        $authorBook = new AuthorBook;
        $authorBook->author_id = $author_id;
        $authorBook->book_item_id = $item_id;
        $authorBook->save();

        return redirect()->to(route('user.items'))->with('message', __("Item criado com sucesso"));
    }

    public function createBook() {
        $possibleAuthors = Author::all();
        $possiblePublishers = Publisher::all();
        $possibleGenres = Genre::all();
        $possibleLanguages = Language::all();

        return view('book.create', compact(
            'possibleAuthors', 'possibleGenres',
            'possiblePublishers', 'possibleLanguages'
        ));
    }

}
