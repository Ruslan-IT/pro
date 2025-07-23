<?php

use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\ProductController;
use Illuminate\Support\Facades\Route;

Route::name('client.')->group(function (){
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('categories/{catalogs}/products', [CategoryController::class, 'productIndex'])->name('categories.products.index');
});
