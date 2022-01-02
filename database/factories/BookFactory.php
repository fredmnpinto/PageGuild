<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Item;
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
    public function definition(): array
    {
        $item = Item::factory()->create();

        return [
            "item_id" => $item['id'],
            "title" => $item['name'],
            "isbn" => $this->faker->unique()->isbn10(),
            "subtitle" => $this->faker->realText(20),
            "synopsis" => $this->faker->realText(),
            "publication_year" => $this->faker->year(),

            "num_pages" => $this->faker->numberBetween(100, 300),
            "width" => round($this->faker->randomFloat(2, 0.20, 0.40), 2),
            "length" => round($this->faker->randomFloat(2, 0.20, 0.40), 2),
            "height" => round($this->faker->randomFloat(2, 0.20, 0.40), 2),
            "bookbinding" => "hard cover",
            "language_id" => $this->faker->numberBetween(1, Language::all()->count())
        ];
    }

    public function hasPublisher(): BookFactory
    {
        return $this->state(function (array $attributes) {
            return [
                "publisher_id" => $this->faker->numberBetween(1, Publisher::all()->count()),
                "edition_year" => $this->faker->year(),
            ];
        });
    }

}