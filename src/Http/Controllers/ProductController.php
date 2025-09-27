<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Mortezaa97\Shop\Http\Resources\ProductResource;
use Mortezaa97\Shop\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Product::class);
        $products = Product::with('categories', 'reviews', 'specifications', 'children', 'tags')->get();
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        Gate::authorize('view', $product);

        return new ProductResource($product);
    }
}
