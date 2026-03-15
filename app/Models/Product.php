<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'sku',
        'price',
        'stock',
        'is_active',
    ];

    /**
    * Un producto pertenece a una categoría.
    */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
