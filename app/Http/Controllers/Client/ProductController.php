<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        //$products = ProductResource::collection(Product::whereNull('id_parent')->get())->resolve();
        //$products = ProductResource::collection(Product::get())->resolve();
        //return  inertia('Client/Product/Index', compact('products'));

        $products = ProductResource::collection(Product::limit(10)->get())->resolve();
        //dd($products);

        return inertia('Client/Product/Index',
            compact('products'

        ));

    }

    public function show(Product $product)
    {

        // Получаем базовое название без цвета/размера
        $baseTitle = CategoryService::generateGroupKey($product->title);

        // Ищем все товары, где название начинается с базового
        $products = Product::where('title', 'LIKE', $baseTitle . '%')->get();



        // Группируем
        $grouped = CategoryService::groupProductsByIdWithTitles($products);

        return inertia('Client/Product/Show', [
            'product' => ProductResource::make($grouped->first())->resolve()
        ]);

    }
}
