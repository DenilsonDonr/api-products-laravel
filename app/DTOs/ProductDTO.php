<?php

namespace App\DTOs;

class ProductDTO
{
    public function __construct(
        public readonly int $category_id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $sku,
        public readonly float $price,
        public readonly int $stock,
        public readonly ?string $description = null,
        public readonly bool $is_active = true,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            category_id: $validated['category_id'],
            name:        $validated['name'],
            slug:        $validated['slug'],
            sku:         $validated['sku'],
            price:       $validated['price'],
            stock:       $validated['stock'],
            description: $validated['description'] ?? null,
            is_active:   $validated['is_active'] ?? true,
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
