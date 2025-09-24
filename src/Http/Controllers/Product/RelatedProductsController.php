<?php

namespace App\Http\Controllers\Product;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use Mortezaa97\Shop\Http\Resources\ProductResource;
use App\Models\Category;
use Mortezaa97\Shop\Models\Product;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class RelatedProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request,Product $product)
    {
        $categories = $product->categories()->get();
        if (! isset($categories)) {
            return [];
        }

        $categoryService = new CategoryService;
        $allCategoryIds = $categoryService->getCategoryChildrenIds($categories);
        $allCategories = Category::whereIn('id', $allCategoryIds)->get();

        return ProductResource::collection(Product::whereHas('categories', function ($query) use ($allCategories) {
            $query->whereIn('category_id', $allCategories->pluck('id'));
        })->where('id', '!=', $product->id)->currentStatus(Status::PUBLISHED)->take(15)->get());
    }
}
