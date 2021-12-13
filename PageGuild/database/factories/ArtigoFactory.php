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
            'nome' => $this->faker->words(random_int(1, 3), true),
            'preco' => $this->faker->randomFloat(2, 4.99, 49.99),
            'data_registo' => $this->faker->date(),
            'data_update' => null,
            'flg_delete' => $this->faker->boolean(80)
        ];
    }
}
