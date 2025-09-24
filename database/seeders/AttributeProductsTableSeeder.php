<?php

namespace Database\Seeders;

use App\Models\AttributeProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttributeProduct::factory()->count(10)->create();

    }
}
