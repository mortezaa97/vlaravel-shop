<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Mortezaa97\Shop\Http\Resources\ProductResource;
use Mortezaa97\Shop\Models\Product;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Product::class);

        return ProductResource::collection(Product::all());
    }

    public function show(Product $product)
    {
        Gate::authorize('view', $product);

        return new ProductResource($product);
    }
}
