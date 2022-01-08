<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use App\Models\Order;

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::factory()->count(5)->create();

        Order::factory()->count(40)->create();
    }
}