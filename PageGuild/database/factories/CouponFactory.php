<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "code" => $this->faker->text(20),
            "start_date" => $this->faker->dateTimeBetween('-2 month', '-2 week')->format("Ymd"),
            "end_date" => $this->faker->dateTimeBetween('-1 week', '+2 week')->format("Ymd"),
            "discount" => $this->faker->randomFloat(2, 0.1, 0.7),
            "flg_active" => $this->faker->boolean(70),
            "description" => $this->faker->realText("100"),
        ];
    }

    public function used() {
        return $this->state(function (array $attributes) {
            return [
                'flg_active' => false,
            ];
        });
    }
}
