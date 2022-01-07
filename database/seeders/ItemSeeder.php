<?php

namespace Database\Seeders;

use App\Models\ItemType;
use App\Models\Language;
use Database\Factories\BookFactory;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ItemType::factory()->create();
        Language::factory()->create();

        // Vai chamando os seeders dos diferentes items
        $this->call([
            BookSeeder::class
        ]);
    }
}