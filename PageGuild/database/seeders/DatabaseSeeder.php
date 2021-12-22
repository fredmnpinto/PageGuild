<?php

namespace Database\Seeders;


use App\Models\Address;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ItemType::factory()->create();
        Language::factory()->create();

        User::factory()->count(10)->create();
        Address::factory()->count(User::all()->count());

        Author::factory()->count(10)->create();
        Publisher::factory()->count(10)->create();
        Genre::factory()->count(10)->create();

//        Book::factory()->count(10)
//            ->has(Item::factory())
//            ->hasAttached(Author::factory())
//            ->create();
    }
}
