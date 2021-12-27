<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Book;
use App\Models\GenreBook;

use Illuminate\Database\Eloquent\Factories\Factory;

class GenreBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() : array
    {
        return [
            'book_item_id' => 1,
            'genre_id' => 1
        ];
    }
}
