<?php

namespace Database\Factories;

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
            "flg_active" => $this->faker->boolean(90),
            "flg_delete" => false
        ];
    }
}
