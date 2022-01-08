<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
             'registration_date' => $this->faker->dateTime('-1 month')->format("Ymd"),
             'update_date' => $this->faker->dateTime('-1 month')->format("Ymd"),
             'order_status_id' => rand(1, OrderStatus::all()->count()),
             'user_id' => rand(1, User::all()->count()),
        ];
    }

    public function hasCoupon(): OrderFactory
    {
        return $this->state(function (array $attributes) {
            return [
                "coupon_id" => CouponFactory::new()->used()->create()[0]['id'],
            ];
        });
    }
}
