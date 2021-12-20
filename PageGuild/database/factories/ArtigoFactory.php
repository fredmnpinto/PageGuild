<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArtigoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(random_int(1, 3), true),
            'price' => $this->faker->randomFloat(2, 4.99, 49.99),
            'registration_date' => $this->faker->date(),
            'update_date' => null,
            'flg_delete' => $this->faker->boolean(80)
        ];
    }
}
