<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShowProductTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $category = Category::factory()->create();

        $this->product = Product::factory()->create([
            'category_id' => $category->id,
            'is_active'   => true,
        ]);
    }

    /**
     * Verifica que se retorna un producto activo correctamente.
     */
    #[Test]
    public function it_returns_a_product_successfully(): void
    {
        $response = $this->getJson("/api/v1/products/{$this->product->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id'   => $this->product->id,
            'name' => $this->product->name,
            'slug' => $this->product->slug,
            'sku'  => $this->product->sku,
        ]);
    }

    /**
     * Verifica que la respuesta tiene la estructura correcta del recurso.
     */
    #[Test]
    public function it_returns_correct_resource_structure(): void
    {
        $response = $this->getJson("/api/v1/products/{$this->product->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
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
        ]);
    }

    /**
     * Verifica que retorna 404 si el producto no existe.
     */
    #[Test]
    public function it_returns_404_when_product_not_found(): void
    {
        $response = $this->getJson('/api/v1/products/99999');

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Product not found.']);
    }

    /**
     * Verifica que retorna 404 si el producto existe pero está inactivo.
     */
    #[Test]
    public function it_returns_404_when_product_is_inactive(): void
    {
        $this->product->update(['is_active' => false]);

        $response = $this->getJson("/api/v1/products/{$this->product->id}");

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Product not found.']);
    }
}
