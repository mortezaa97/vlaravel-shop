<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mortezaa97\Shop\Http\Resources\ProductResource;
use Mortezaa97\Shop\Models\Product;

class FilterProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $cacheKey = 'products_filter_' . md5(json_encode([
                'available' => $request->available,
                'min_price' => $request->min_price,
                'max_price' => $request->max_price,
                'categories' => $request->categories,
                'brands' => $request->brands,
                'search' => $request->search,
                'url' => $request->url,
                'order' => $request->order,
                'page' => $request->page ?? 1,
                'tags' => $request->tags,
            ]));

            $products = Cache::remember($cacheKey, 60 * 24, function () use ($request) {
                $variantConditions = function ($q) use ($request) {
                    $q->where('price', '>', 0)
                        ->when($request->available, fn ($q) => $q->where('quantity', '>', 0))
                        ->when($request->min_price, fn ($q) => $q->where(function ($q) use ($request) {
                            $q->where('price', '>=', $request->min_price)
                                ->orWhere('sale_price', '>=', $request->min_price);
                        }))
                        ->when($request->max_price, fn ($q) => $q->where(function ($q) use ($request) {
                            $q->where('price', '<=', $request->max_price)
                                ->orWhere('sale_price', '<=', $request->max_price);
                        }));
                };

                $query = Product::query()
                    ->with(['variants' => $variantConditions])
                    ->whereHas('variants', function ($q) {
                        $q->where('quantity', '>', 0)
                            ->where('price', '>', 0);
                    })
                    ->when($request->categories, fn ($q) => $q->whereIn('category_id', json_decode($request->categories, true)))
                    ->when($request->brands, fn ($q) => $q->whereIn('brand_id', json_decode($request->brands, true)))
                    ->when($request->search, fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                    ->when($request->url, function ($q) use ($request) {
                        $q->whereHas('categories', fn ($query) => $query->where('url', $request->url));
                    })
                    ->when($request->has('tags') && ! empty($request->tags), function ($q) use ($request) {
                        $tags = json_decode($request->tags);
                        $q->whereHas('tags', function ($q) use ($tags) {
                            $q->whereIn('slug', $tags);
                        });
                    });

                // Apply sorting
                switch ($request->order) {
                    case 'oldest':
                        $query->oldest();
                        break;
                    case 'highest':
                        $query->orderByDesc(
                            Product::select('price')
                                ->whereNotNull('parent_id')
                                ->whereColumn('product_id', 'products.id')
                                ->where('price', '>', 0)
                                ->when($request->available, fn ($q) => $q->where('quantity', '>', 0))
                                ->when($request->min_price, fn ($q) => $q->where(function ($q) use ($request) {
                                    $q->where('price', '>=', $request->min_price)
                                        ->orWhere('sale_price', '>=', $request->min_price);
                                }))
                                ->when($request->max_price, fn ($q) => $q->where(function ($q) use ($request) {
                                    $q->where('price', '<=', $request->max_price)
                                        ->orWhere('sale_price', '<=', $request->max_price);
                                }))
                                ->orderBy('price', 'desc')
                                ->limit(1)
                        );
                        break;
                    case 'newest':
                        $query->latest();
                        break;
                    case 'seen':
                        $query->orderByDesc('views');
                        break;
                    default: // 'lowest' and default
                        $query->orderBy(
                            Product::select('price')
                                ->whereNotNull('parent_id')
                                ->whereColumn('product_id', 'products.id')
                                ->where('price', '>', 0)
                                ->when($request->available, fn ($q) => $q->where('quantity', '>', 0))
                                ->when($request->min_price, fn ($q) => $q->where(function ($q) use ($request) {
                                    $q->where('price', '>=', $request->min_price)
                                        ->orWhere('sale_price', '>=', $request->min_price);
                                }))
                                ->when($request->max_price, fn ($q) => $q->where(function ($q) use ($request) {
                                    $q->where('price', '<=', $request->max_price)
                                        ->orWhere('sale_price', '<=', $request->max_price);
                                }))
                                ->orderBy('price', 'asc')
                                ->limit(1)
                        );
                }

                return $query->paginate()->through(function ($product) {
                    $product->default_variant = $product->default_variant;
                    $product->breadcrumbs = $product->breadcrumbs;

                    return ProductResource::make($product);
                });
            });
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json($products);
    }
}
