<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => rand(1, Order::all()->count()),
            'item_id' => rand(1, Item::all()->couynt()),
            'amount' => rand(1, 4),
        ];
    }
}
