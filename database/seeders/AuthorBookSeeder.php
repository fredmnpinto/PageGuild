<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\AuthorBook;
use Database\Factories\BookFactory;
use Illuminate\Database\Seeder;

class AuthorBookSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Author::factory()->count(10)->create();
        Book::factory()->count(10)->create();
     
        BookFactory::new()->count(5)
            ->hasPublisher()
            ->create();

        foreach(Book::all() as $book) {    
            AuthorBook::factory()->create([
                'book_item_id' => $book->item_id,
                'author_id' => rand(1, Author::All()->count())
            ]);
        }
    }
}
