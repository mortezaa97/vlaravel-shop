<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mortezaa97\Shop\Http\Requests\FilterProductsRequest;
use Mortezaa97\Shop\Http\Resources\ProductSimpleResource;
use Mortezaa97\Shop\Models\Product;

class FilterProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(FilterProductsRequest $request)
    {
        try {
            $validated = $request->validated();

            /**
             * Product Conditions.
             */
            $query = Product::query()
                ->active()
                ->whereNull('parent_id')
                ->when($validated['categories'] ?? null, function ($q) use ($validated) {
                    $q->whereHas('categories', fn ($query) => $query->whereIn('categories.id', $validated['categories']));
                })
                ->when($validated['product_name'] ?? null, function ($q) use ($validated) {
                    $q->where('name', 'like', '%' . $validated['product_name'] . '%');
                })
                ->when($validated['category_url'] ?? null, function ($q) use ($validated) {
                    $category = Category::where('url', $validated['category_url'])->first();
                    if ($category) {
                        $categoryIds = $category->getAllDescendantIds();
                        $q->whereHas('categories', fn ($query) => $query->whereIn('categories.id', $categoryIds));
                    }
                })
                ->when($validated['min_price'] ?? null, function ($q) use ($validated) {
                    $q->whereHas('children', function ($query) use ($validated) {
                        $query->where('price', '>=', $validated['min_price']);
                    });
                })
                ->when($validated['max_price'] ?? null, function ($q) use ($validated) {
                    $q->whereHas('children', function ($query) use ($validated) {
                        $query->where('price', '<=', $validated['max_price']);
                    });
                })
                ->when($validated['attributes'] ?? null, function ($q) use ($validated) {
                    foreach ($validated['attributes'] as $attributeJson) {
                        $attribute = json_decode($attributeJson, true);
                        if ($attribute && isset($attribute['attribute_id'], $attribute['attribute_value_id'])) {
                            $q->whereHas('children', function ($query) use ($attribute) {
                                $query->whereHas('attributeProducts', function ($subQuery) use ($attribute) {
                                    $subQuery->where('attribute_id', $attribute['attribute_id'])
                                        ->where('attribute_value_id', $attribute['attribute_value_id']);
                                });
                            });
                        }
                    }
                })
                ->with([
                    'children' => function ($q) {
                        $q->where('price', '>', 0)->where('quantity', '>', 0);
                    },
                    'categories',
                    'specifications.attribute',
                    'specifications.value',
                    'tags',
                    'attributeProducts',
                ]);

            /**
             * Sorting.
             */
            switch ($validated['order'] ?? 'newest') {
                case 'newest':
                    $query->latest();
                    break;
                case 'most_viewed':
                    $query->orderByDesc('views');
                    break;
                case 'most_liked':
                    $query->withCount('wishlists as like_count')
                        ->orderByDesc('like_count');
                    break;
                default:
                    $query->latest();
            }

            /**
             * Pagination.
             */
            $perPage = $validated['per_page'] ?? 15;
            $products = $query->paginate($perPage)->through(function ($product) {
                return ProductSimpleResource::make($product);
            });

            return response()->json($products);
        } catch (ValidationException $e) {
            // Re-throw validation exceptions so they're handled properly by Laravel
            throw $e;
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
