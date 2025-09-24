<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Mortezaa97\Shop\Http\Resources\ProductResource;
use Mortezaa97\Shop\Models\Product;
use Illuminate\Http\Request;
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
