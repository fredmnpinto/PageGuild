<?php

namespace Database\Seeders;


use App\Models\Address;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Item;
use App\Models\ItemType;
use App\Models\Language;
use App\Models\OrderStatus;
use App\Models\Publisher;
use App\Models\User;
use App\Models\UserType;
<<<<<<< HEAD:database/seeders/DatabaseSeeder.php
=======
use App\Models\AuthorBook;
>>>>>>> 5fe2d113a860b19c2b01e4fb75d9f55754bf64b1:PageGuild/database/seeders/DatabaseSeeder.php
use Database\Factories\BookFactory;
use Database\Factories\OrderFactory;
use Database\Factories\AuthorBookFactory;
use Database\Factories\GenreBookFactory;
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
        OrderStatus::factory()->count(5)->create();

        UserType::factory()->create();
        UserType::factory()->admin()->create();

        User::factory()->count(7)->create();
        User::factory()->count(3)->admin()->create();

        Address::factory()->count(User::all()->count());

        Author::factory()->count(10)->create();
        Publisher::factory()->count(10)->create();
        Genre::factory()->count(10)->create();

        Book::factory()->count(10)->create();
     
        BookFactory::new()->count(5)
            ->hasPublisher()
            ->create();

        $this->call([
            AuthorBookSeeder::class,
            GenreBookSeeder::class
        ]);
    }
}
