<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GlobalOriginalParamChangeController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ParamController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SuppliersTovarsController;
use App\Http\Controllers\Admin\CatalogsController;


use App\Http\Middleware\IsAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->prefix('admin')->middleware(['auth', IsAdminMiddleware::class]);

Route::prefix('admin')->name('admin.')->middleware(['auth', IsAdminMiddleware::class])->group(function () {

    Route::resource('catalogs', CatalogsController::class);
    Route::resource('global_original_param_changes', GlobalOriginalParamChangeController::class);
    Route::resource('suppliers-tovars', SuppliersTovarsController::class)->parameters(['suppliers-tovars' => 'supplierTovars']);
    Route::resource('products', ProductController::class);

    Route::resource('params', ParamController::class);

    Route::delete('images/{image}', [ImageController::class, 'destroy'])->name('images.destroy');

});
