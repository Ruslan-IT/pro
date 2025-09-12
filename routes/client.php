<?php

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\PageController;
use App\Http\Resources\Product\ProductResource;
use Illuminate\Support\Facades\Route;

Route::name('client.')->group(function (){

    // Живой поиск
    Route::get('products/search', [SearchController::class, 'search'])
        ->name('products.search');

    //Поиск по кнопке
    Route::get('products/search-page', [SearchController::class, 'searchPage'])
        ->name('products.search-page');



    Route::get('products', [ProductController::class, 'index'])
        ->name('products.index');

    Route::get('products/{product:url}', [ProductController::class, 'show'])
        ->name('products.show');

    Route::get('categories/{catalogs:url}/products', [CategoryController::class, 'productIndex'])
        ->name('categories.products.index');

    Route::resource('/carts', CartController::class);

    Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');


});
