<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Language;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->unique()->name(),
            "isbn" => $this->faker->unique()->isbn10(),
            "subtitle" => $this->faker->words(rand(1, 3)),
            "synopsis" => $this->faker->realText(),
            "publication_year" => $this->faker->year(),
            "edition_year" => 2021,
            "num_pages" => $this->faker->numberBetween(100, 300),
            "width" => round($this->faker->randomFloat(2, 0.20, 0.40), 2),
            "length" => round($this->faker->randomFloat(2, 0.20, 0.40), 2),
            "height" => round($this->faker->randomFloat(2, 0.20, 0.40), 2),
            "bookbinding" => "hard cover",

            "publisher_id" => $this->faker->numberBetween(1, Publisher::all()->count()),
            "language_id" => $this->faker->numberBetween(1, Language::all()->count())
        ];
    }
}
