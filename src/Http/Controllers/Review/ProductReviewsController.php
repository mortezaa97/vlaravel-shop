<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers\Review;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mortezaa97\Reviews\Http\Resources\ReviewResource;
use Mortezaa97\Reviews\Models\Review;
use Mortezaa97\Shop\Models\Product;

class ProductReviewsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Product $product)
    {
        $reviews = Cache::remember('product_reviews_' . $product->id, 60 * 24, function () use ($product) {
            return ReviewResource::collection(
                Review::where('model_id', $product->id)
                    ->where('model_type', Product::class)
                    ->with('createdBy')
                    ->where('status', Status::APPROVED)
                    ->paginate()
            );
        });

        return response()->json($reviews->response()->getData(true));
    }
}
