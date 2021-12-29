<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address_id' => rand(1, Address::all()->count()),
            'expected_date' => $this->faker->dateTimeThisMonth('+1 month')->format('Ymd'),
            'shipping_state_id' => 1,
            'order_id' => rand(1, Order::all()->count()),
        ];
    }
}
