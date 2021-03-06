<?php

namespace Database\Factories;

use App\Models\Country;

use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "city" => $this->faker->unique()->city(),
            "country_id" => $this->faker->numberBetween(1, Country::all()->count()),
        ];
    }
}
