<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(
                [
                    'Electronics',
                    'Books',
                    'Clothing',
                    'Home & Kitchen',
                    'Sports & Outdoors',
                    'Toys & Games',
                    'Health & Personal Care',
                    'Automotive',
                    'Beauty & Grooming',
                    'Office Supplies'
                ]
            ),
            'slug' => fn (array $attrs) => Str::slug($attrs['name']), // generar un slug a partir del nombre de la categoría
            'description' => fake()->sentence(), // generar una frase aleatoria para la descripción
        ];
    }
}
