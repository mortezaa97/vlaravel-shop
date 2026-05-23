<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Mortezaa97\Shop\Http\Resources\ProductResource;
use Mortezaa97\Shop\Http\Resources\ProductSimpleResource;
use Mortezaa97\Shop\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Product::class);
        $products = Product::with('categories', 'reviews', 'specifications.attribute.parent', 'specifications.value', 'children.attributeProducts', 'tags')->parent()->get();

        return ProductSimpleResource::collection($products);
    }

    public function show(Product $product)
    {
        Gate::authorize('view', $product);
        $product->load([
            'children'=>fn ($q) => $q->available(),
            'children.attributeProducts',
        ]);

        return new ProductResource($product);
    }
}
