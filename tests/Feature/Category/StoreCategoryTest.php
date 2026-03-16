<?php

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StoreCategoryTest extends TestCase
{
    // Resetea la base de datos antes de cada test para que no haya datos residuales
    use RefreshDatabase;

    // Datos válidos reutilizables en los tests
    private array $payload = [
        'name'        => 'Electrónica',
        'slug'        => 'electronica',
        'description' => 'Productos electrónicos y tecnología',
        'is_active'   => true,
    ];

    /**
     * Verifica que una categoría se crea correctamente con todos los campos válidos.
     * Se espera un 201 Created y que el registro exista en la base de datos.
     */
    #[Test]
    public function it_creates_a_category_successfully(): void
    {
        // Hace POST al endpoint con datos válidos
        $response = $this->postJson('/api/v1/categories', $this->payload);

        // Verifica que la respuesta sea 201 Created
        $response->assertStatus(201);

        // Verifica que la respuesta contenga los datos enviados
        $response->assertJsonFragment([
            'name' => 'Electrónica',
            'slug' => 'electronica',
        ]);

        // Verifica que el registro exista en la base de datos
        $this->assertDatabaseHas('categories', [
            'name' => 'Electrónica',
            'slug' => 'electronica',
        ]);
    }

    /**
     * Verifica que el campo 'name' es obligatorio.
     * Se espera un 422 con error de validación en el campo 'name'.
     */
    #[Test]
    public function it_requires_name(): void
    {
        // Envía el payload sin el campo 'name'
        $response = $this->postJson('/api/v1/categories', array_merge($this->payload, ['name' => '']));

        // Verifica que la validación falle con 422 Unprocessable Entity
        $response->assertStatus(422);

        // Verifica que el error sea específicamente en el campo 'name'
        $response->assertJsonValidationErrors(['name']);
    }

    /**
     * Verifica que el campo 'slug' es obligatorio.
     * Se espera un 422 con error de validación en el campo 'slug'.
     */
    #[Test]
    public function it_requires_slug(): void
    {
        // Envía el payload sin el campo 'slug'
        $response = $this->postJson('/api/v1/categories', array_merge($this->payload, ['slug' => '']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['slug']);
    }

    /**
     * Verifica que el campo 'slug' es único en la tabla categories.
     * Se espera un 422 al intentar registrar un slug ya existente.
     */
    #[Test]
    public function it_requires_unique_slug(): void
    {
        // Crea la categoría por primera vez
        $this->postJson('/api/v1/categories', $this->payload);

        // Intenta crear otra categoría con el mismo slug
        $response = $this->postJson('/api/v1/categories', $this->payload);

        // El slug debe ser único, por lo tanto debe fallar
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['slug']);
    }

    /**
     * Verifica que los campos 'description' e 'is_active' son opcionales.
     * Se espera un 201 y que 'is_active' sea true por defecto.
     */
    #[Test]
    public function it_creates_category_without_optional_fields(): void
    {
        // Envía solo los campos requeridos, sin 'description' ni 'is_active'
        $response = $this->postJson('/api/v1/categories', [
            'name' => 'Electrónica',
            'slug' => 'electronica',
        ]);

        $response->assertStatus(201);

        // Verifica que is_active sea true por defecto
        $this->assertDatabaseHas('categories', [
            'slug'      => 'electronica',
            'is_active' => true,
        ]);
    }
}
