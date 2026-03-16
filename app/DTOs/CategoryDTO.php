<?php

namespace App\DTOs;

class CategoryDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $description = null,
        public readonly bool $is_active = true,
    ) {}

    public static function fromRequest(array $validated): self
    {
        return new self(
            name: $validated['name'],
            slug: $validated['slug'],
            description: $validated['description'] ?? null,
            is_active: $validated['is_active'] ?? true,
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
