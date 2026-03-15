<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Toma las categorías existentes y crea productos asociados a cada categoría
        $categories = Category::all();

        $categories->each(function (Category $category) {
            Product::factory()
                ->count(rand(3, 8))
                ->create([ 'category_id' => $category->id ]);
        });
    }
}
