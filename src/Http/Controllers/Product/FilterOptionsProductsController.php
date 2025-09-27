<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;
use Mortezaa97\Shop\Models\Attribute;
use Mortezaa97\Shop\Models\Product;

class FilterOptionsProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $attributes = Attribute::with('values')->get();
        $price_ranges = [
            [
                'min' => 500000,
                'max' => 1000000,
            ],
            [
                'min' => 1000000,
                'max' => 2000000,
            ],
            [
                'min' => 2000000,
                'max' => 3000000,
            ],
            [
                'min' => 3000000,
                'max' => 5000000,
            ],
            [
                'min' => 5000000,
                'max' => 10000000,
            ],
            [
                'min' => 10000000,
                'max' => PHP_INT_MAX,
            ],
        ];
        $sort_types = [
            'newest' => 'جدیدترین',
            'most_viewed' => 'پربازدیدترین',
            'most_liked' => 'محبوب‌ترین',
        ];
        if (! $request->validated('url')) {
            $page = Page::where('slug', 'category-details-page')->firstOrFail();

            $categories = Category::query()
                ->whereNull('parent_id')
                ->where('model_type', Product::class)
                ->get();

            return response()->json([
                'meta_title' => $page->meta_title,
                'meta_desc' => $page->meta_desc,
                'meta_keywords' => $page->meta_keywords,
                'breadcrumbs' => null,
                'child_categories' => CategoryResource::collection($categories),
                'attributes' => $attributes,
                'price_ranges' => $price_ranges,
                'sort_types' => $sort_types,
            ]);
        } else {
            $category = Category::where('url', $request->validated('url'))->firstOrFail();

            return response()->json([
                'meta_title' => $category->meta_title,
                'meta_desc' => $category->meta_desc,
                'meta_keywords' => $category->meta_keywords,
                'breadcrumbs' => $category->breadcrumbs,
                'child_categories' => CategoryResource::collection($category->children),
                'attributes' => $attributes,
                'price_ranges' => $price_ranges,
                'sort_types' => $sort_types,
            ]);
        }
    }
}
