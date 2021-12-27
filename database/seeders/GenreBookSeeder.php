<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Book;
use App\Models\GenreBook;
use Database\Factories\BookFactory;
use Illuminate\Database\Seeder;

class GenreBookSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach(Book::all() as $book) {    
            GenreBook::factory()->create([
                'book_item_id' => $book->item_id,
                'genre_id' => rand(1, Genre::All()->count())
            ]);
        }
    }
}
