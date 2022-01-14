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
            "address" => $this->faker->address(),
            // Vai buscar o id de um utilizador EXISTENTE aleatorio
            "user_id" => User::inRandomOrder()->first()->id,
            // Vai buscar o id de uma cidade EXISTENTE aleatoria
            "city_id" => City::inRandomOrder()->first()->id,
            "flag_active" => $this->faker->boolean(90),
            "flag_delete" => false
        ];
    }
}
