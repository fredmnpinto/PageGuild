<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Publisher;
use App\Models\Genre;
use App\Models\Book;
use App\Models\AuthorBook;
use App\Models\GenreBook;
use Database\Factories\BookFactory;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Author::factory()->count(10)->create();
        Publisher::factory()->count(10)->create();
        Genre::factory()->count(10)->create();

        // Popula os livros
        Book::factory()->count(40)->create();
     
        BookFactory::new()->count(5)
            ->hasPublisher()
            ->create();


        // Popula a AuthorBook
        foreach(Book::all() as $book) {    
            AuthorBook::factory()->create([
                'book_item_id' => $book->item_id,
                'author_id' => rand(1, Author::All()->count())
            ]);
        }

        // Popula a GenreBook
        foreach(Book::all() as $book) {    
            GenreBook::factory()->create([
                'book_item_id' => $book->item_id,
                'genre_id' => rand(1, Genre::All()->count())
            ]);
        }
    }
}