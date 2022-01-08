<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "address" => $this->faker->streetAddress(),
            "user_id" => $this->faker->numberBetween(1, User::all()->count()),
            "city_id" => $this->faker->numberBetween(1, City::all()->count()),
            "flg_active" => $this->faker->boolean(90),
            "flg_delete" => false
        ];
    }
}
