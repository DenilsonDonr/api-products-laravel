<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreProductTest extends TestCase
{
    use RefreshDatabase;

    private array $payload;

    protected function setUp(): void
    {
        parent::setUp();

        $category = Category::factory()->create();

        $this->payload = [
            'category_id' => $category->id,
            'name'        => 'Laptop Gamer',
            'slug'        => 'laptop-gamer',
            'description' => 'Laptop de alto rendimiento para gaming',
            'sku'         => 'SKU-0001-LAP',
            'price'       => 1299.99,
            'stock'       => 10,
            'is_active'   => true,
        ];
    }

    /**
     * Verifica que un producto se crea correctamente con todos los campos válidos.
     * Se espera un 201 Created y que el registro exista en la base de datos.
     */
    #[Test]
    public function it_creates_a_product_successfully(): void
    {
        $response = $this->postJson('/api/v1/products', $this->payload);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'name' => 'Laptop Gamer',
            'slug' => 'laptop-gamer',
            'sku'  => 'SKU-0001-LAP',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Laptop Gamer',
            'slug' => 'laptop-gamer',
            'sku'  => 'SKU-0001-LAP',
        ]);
    }

    /**
     * Verifica que la respuesta tiene la estructura correcta del recurso.
     */
    #[Test]
    public function it_returns_correct_resource_structure(): void
    {
        $response = $this->postJson('/api/v1/products', $this->payload);

        $response->assertStatus(201);
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
     * Verifica que el campo 'name' es obligatorio.
     */
    #[Test]
    public function it_requires_name(): void
    {
        $response = $this->postJson('/api/v1/products', array_merge($this->payload, ['name' => '']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * Verifica que el campo 'slug' es obligatorio.
     */
    #[Test]
    public function it_requires_slug(): void
    {
        $response = $this->postJson('/api/v1/products', array_merge($this->payload, ['slug' => '']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['slug']);
    }

    /**
     * Verifica que el campo 'slug' debe ser único en la tabla products.
     */
    #[Test]
    public function it_requires_unique_slug(): void
    {
        $this->postJson('/api/v1/products', $this->payload);

        $response = $this->postJson('/api/v1/products', array_merge($this->payload, ['sku' => 'SKU-0002-LAP']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['slug']);
    }

    /**
     * Verifica que el campo 'sku' es obligatorio.
     */
    #[Test]
    public function it_requires_sku(): void
    {
        $response = $this->postJson('/api/v1/products', array_merge($this->payload, ['sku' => '']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['sku']);
    }

    /**
     * Verifica que el campo 'sku' debe ser único en la tabla products.
     */
    #[Test]
    public function it_requires_unique_sku(): void
    {
        $this->postJson('/api/v1/products', $this->payload);

        $response = $this->postJson('/api/v1/products', array_merge($this->payload, ['slug' => 'laptop-gamer-2']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['sku']);
    }

    /**
     * Verifica que el campo 'price' es obligatorio.
     */
    #[Test]
    public function it_requires_price(): void
    {
        $response = $this->postJson('/api/v1/products', array_merge($this->payload, ['price' => '']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['price']);
    }

    /**
     * Verifica que el campo 'price' no puede ser negativo.
     */
    #[Test]
    public function it_requires_price_to_be_non_negative(): void
    {
        $response = $this->postJson('/api/v1/products', array_merge($this->payload, ['price' => -1]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['price']);
    }

    /**
     * Verifica que el campo 'stock' es obligatorio.
     */
    #[Test]
    public function it_requires_stock(): void
    {
        $response = $this->postJson('/api/v1/products', array_merge($this->payload, ['stock' => '']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['stock']);
    }

    /**
     * Verifica que el campo 'category_id' debe existir en la tabla categories.
     */
    #[Test]
    public function it_requires_existing_category_id(): void
    {
        $response = $this->postJson('/api/v1/products', array_merge($this->payload, ['category_id' => 9999]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['category_id']);
    }

    /**
     * Verifica que el campo 'description' es opcional y que is_active es true por defecto.
     */
    #[Test]
    public function it_creates_product_without_optional_fields(): void
    {
        $payload = $this->payload;
        unset($payload['description'], $payload['is_active']);

        $response = $this->postJson('/api/v1/products', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'slug'      => 'laptop-gamer',
            'is_active' => true,
        ]);
    }
}
