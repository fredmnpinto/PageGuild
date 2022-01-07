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
use App\Models\City;
use App\Models\Country;
use App\Models\UserType;
use App\Models\AuthorBook;
use Database\Factories\BookFactory;
use Database\Factories\OrderFactory;
use Database\Factories\AuthorBookFactory;
use Database\Factories\GenreBookFactory;
use Database\Factories\CountryFactory;
use Database\Factories\CityFactory;
use Database\Factories\AddressFactory;

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
        $this->call([
            ItemSeeder::class,
            UserSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
