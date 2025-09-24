<?php

namespace Mortezaa97\Shop\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use Mortezaa97\Shop\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mortezaa97\Reviews\Http\Resources\ReviewResource;
use Mortezaa97\Reviews\Models\Review;

class ProductReviewsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Product $product)
    {
        $reviews = Cache::remember('product_reviews_'.$product->id, 60 * 24, function () use ($product) {
            return ReviewResource::collection(
                Review::where('model_id', $product->id)
                    ->where('model_type', Product::class)
                    ->with('createdBy')
                    ->currentStatus('تایید شده')
                    ->get()
                    ->paginate(10)
            );
        });

        return response()->json($reviews);
    }
}
