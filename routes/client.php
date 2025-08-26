<?php

use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Support\Facades\Route;

Route::name('client.')->group(function (){

    // Сначала специфичные маршруты, потом общие
    Route::get('products/search', [ProductController::class, 'search'])
        ->name('products.search');

    Route::get('products', [ProductController::class, 'index'])
        ->name('products.index');

    Route::get('products/{product:url}', [ProductController::class, 'show'])
        ->name('products.show');

    Route::get('categories/{catalogs:url}/products', [CategoryController::class, 'productIndex'])
        ->name('categories.products.index');
});
