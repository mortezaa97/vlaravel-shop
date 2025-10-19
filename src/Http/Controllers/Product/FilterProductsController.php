<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Mortezaa97\Shop\Http\Resources\ProductSimpleResource;
use Mortezaa97\Shop\Models\Product;

class FilterProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
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
                ->with(['children' => $variantConditions, 'categories', 'reviews', 'tags'])
                ->whereHas('children', function ($q) {
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
                })
                ->when($request->has('attributes') ?? null, function ($q) use ($request) {
                    foreach ($request->attributes as $attributeJson) {
                        $attribute = json_decode($attributeJson, true);
                        if ($attribute && isset($request->attributes, $attribute['attribute_value_id'])) {
                            $q->whereHas('variants', function ($query) use ($attribute) {
                                $query->active()->whereHas('attributeVariants', function ($subQuery) use ($attribute) {
                                    $subQuery->where('attribute_id', $attribute['attribute_id'])
                                        ->where('attribute_value_id', $attribute['attribute_value_id']);
                                });
                            });
                        }
                    }
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
                            ->whereColumn('id', 'products.id')
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
                            ->whereColumn('id', 'products.id')
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

            $products = ProductSimpleResource::collection($query->paginate());
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json($products->response()->getData(true));
    }
}
