<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->unique()->name(),
            'registration_date' => $this->faker->dateTime(),
            'update_date' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
