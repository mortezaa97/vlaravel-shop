<?php

namespace Mortezaa97\Shop\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Mortezaa97\Shop\Models\Product;
use Illuminate\Http\Request;

class IncreaseViewProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request,Product $product)
    {
        $product->increment('views');
        $product->refresh();

        return response()->json(['views' => $product->views]);
    }
}
