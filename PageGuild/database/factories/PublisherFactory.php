<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            'registration_date' => $this->faker->dateTime('-1 month'),
            'update_date' => $this->faker->dateTimeThisMonth(),
        ];
    }
}
