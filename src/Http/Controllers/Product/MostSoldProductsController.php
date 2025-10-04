<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mortezaa97\Shop\Http\Resources\ProductResource;
use Mortezaa97\Shop\Models\Product;

class MostSoldProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $products = Product::with('children')->active()->limit(5)->get();

        return response()->json(ProductResource::collection($products));
    }
}
