<?php

namespace Database\Seeders;

use App\Models\UserType;
use App\Models\User;
use App\Models\Address;
use App\Models\Country;
use App\Models\City;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserType::factory()->create();
        UserType::factory()->admin()->create();

        User::factory()->count(7)->create();
        User::factory()->count(3)->admin()->create();

        Address::factory()->count(User::all()->count());

        Country::factory()->count(5)->create();

        City::factory()->count(15)->create();

        Address::factory()->count(20)->create();
    }
}