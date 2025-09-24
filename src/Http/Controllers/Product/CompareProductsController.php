<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Mortezaa97\Shop\Http\Resources\ProductResource;
use Mortezaa97\Shop\Models\Product;
use Mortezaa97\Shop\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
class CompareProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $features = new Collection;
        $products = new Collection;
        foreach ($request->products as $product) {
            $item = Product::where('slug', $product)->first();
            $products->push($item->load('categories'));
            $features->push(Specification::where('product_id', $item->id)
                ->get());
        }

        $items = $features->flatten();

        return response()->json([
            'products' => ProductResource::collection($products),
            'data' => ProductCompareResource::collection($items)
                ->sortBy('attribute.parent.order_id')
                ->groupBy('attribute.name'),
        ]);
    }
}
