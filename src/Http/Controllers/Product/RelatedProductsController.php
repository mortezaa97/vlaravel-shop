<?php

declare(strict_types=1);

namespace Mortezaa97\Shop\Http\Controllers\Product;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Mortezaa97\Shop\Http\Resources\ProductSimpleResource;
use Mortezaa97\Shop\Models\Product;

class RelatedProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Product $product)
    {
        $categories = $product->categories()->with('children')->get();
        if (! isset($categories)) {
            return [];
        }

        $categoryService = new CategoryService;
        $allCategoryIds = $categoryService->getCategoryChildrenIds($categories);
        $allCategories = Category::whereIn('id', $allCategoryIds)->get();

        return ProductSimpleResource::collection(Product::whereHas('categories', function ($query) use ($allCategories) {
            $query->whereIn('category_id', $allCategories->pluck('id'));
        })->with('reviews')->parent()->where('id', '!=', $product->id)->where('status', Status::PUBLISHED)->take(15)->get());
    }
}
