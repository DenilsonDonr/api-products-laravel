<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IndexProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Verifica que el endpoint devuelve una lista paginada de productos activos.
     */
    #[Test]
    public function it_returns_a_paginated_list_of_active_products(): void
    {
        Product::factory()->count(3)->create(['is_active' => 1]);

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    /**
     * Verifica que los productos inactivos no se incluyen en el listado por defecto.
     */
    #[Test]
    public function it_excludes_inactive_products_by_default(): void
    {
        Product::factory()->count(2)->create(['is_active' => 1]);
        Product::factory()->count(2)->create(['is_active' => 0]);

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /**
     * Verifica que el parámetro is_active=false devuelve sólo productos inactivos.
     */
    #[Test]
    public function it_returns_inactive_products_when_requested(): void
    {
        Product::factory()->count(1)->create(['is_active' => 1]);
        Product::factory()->count(3)->create(['is_active' => 0]);

        $response = $this->getJson('/api/v1/products?is_active=0');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    /**
     * Verifica que la respuesta tiene la estructura de paginación correcta.
     */
    #[Test]
    public function it_returns_correct_pagination_structure(): void
    {
        Product::factory()->count(2)->create(['is_active' => 1]);

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'category_id',
                    'name',
                    'slug',
                    'description',
                    'sku',
                    'price',
                    'stock',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
            ],
            'links',
            'meta',
        ]);
    }

    /**
     * Verifica que el parámetro per_page controla el número de resultados por página.
     */
    #[Test]
    public function it_respects_per_page_parameter(): void
    {
        Product::factory()->count(5)->create(['is_active' => 1]);

        $response = $this->getJson('/api/v1/products?per_page=2');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }

    /**
     * Verifica que devuelve una lista vacía cuando no hay productos.
     */
    #[Test]
    public function it_returns_empty_list_when_no_products(): void
    {
        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }
}
