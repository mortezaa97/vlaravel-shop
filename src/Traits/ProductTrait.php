<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Traits;

use Mortezaa97\Shop\Models\Product;

trait ProductTrait
{
    /**
     * Get all products for this model.
     */
    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            related: Product::class,
            table: 'model_has_categories',
            foreignPivotKey: 'category_id',
            relatedPivotKey: 'model_id'
        );
    }
}
