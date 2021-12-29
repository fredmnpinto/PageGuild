<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemShoppingCartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1, User::all()->count()),
            'item_id' => rand(1, Item::all()->count()),
            'flg_delete' => $this->faker->boolean(20),
            'registration_date' => $this->faker->dateTimeThisYear()->format('Ymd'),
        ];
    }
}
