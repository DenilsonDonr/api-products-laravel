<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(), // Asociar cada producto con una categoría creada por el factory de categorías
            'name' => fake()->unique()->word(5, true), // Generar un nombre de producto único con 5 palabras
            'slug' => fn (array $attrs) => Str::slug($attrs['name']), // generar un slug a partir del nombre del producto
            'description' => fake()->sentence(), // generar una frase aleatoria para la descripción
            'sku' => fake()->unique()->bothify("SKU-####-???"), // generar un SKU único con el formato "SKU-1234-ABC"
            'price' => fake()->randomFloat(2, 10, 1000), // generar un precio aleatorio entre 10 y 1000
            'stock' => fake()->numberBetween(0, 100), // generar una cantidad de stock aleatoria entre 0 y 100
            'is_active' => fake()->boolean(80), // generar un valor booleano con una probabilidad del 80% de ser true
        ];
    }
}
