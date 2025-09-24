<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Mortezaa97\Reviews\Http\Controllers\ReviewController;
use Mortezaa97\Shop\Http\Controllers\Product\CompareProductsController;
use Mortezaa97\Shop\Http\Controllers\Product\IncreaseViewProductsController;
use Mortezaa97\Shop\Http\Controllers\Product\MostSoldProductsController;
use Mortezaa97\Shop\Http\Controllers\Product\RelatedProductsController;
use Mortezaa97\Shop\Http\Controllers\ProductController;
use Mortezaa97\Shop\Http\Controllers\Review\ProductReviewsController;


Route::prefix('api/products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{product:code}', [ProductController::class, 'show'])->name('products.show');
});

Route::get('products-related/{product:slug}', RelatedProductsController::class)->name('products.related');
Route::get('products-reviews/{product:slug}', ProductReviewsController::class)->name('products.reviews');
Route::get('products-increase-view/{product:slug}', IncreaseViewProductsController::class)->name('products.increase.view');
Route::post('products-compare', CompareProductsController::class)->name('products.compare');
Route::get('most-sold-products', MostSoldProductsController::class)->name('products.most.sold');

