<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\AuthorBook;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorBookFactory extends Factory
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
            'author_id' => 1
        ];
    }
}