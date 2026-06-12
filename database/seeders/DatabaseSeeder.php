<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $catalog = json_decode(File::get(database_path('seeders/products.json')), true);

        foreach ($catalog['products'] as $product) {
            Product::updateOrCreate(['id' => $product['id']], $product);
        }
    }
}
