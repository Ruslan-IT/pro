<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {


        $products = ProductResource::collection(Product::limit(10)->get())->resolve();
        //dd($products);

        return inertia('Client/Product/Index',
            compact('products'

        ));

    }


    public function show(Category $catalogs, Product $product)
    {

        // 1. Получаем базовые данные (категории, хлебные крошки)
        $breadcrumbs = array_reverse(CategoryService::getCategoryParents($catalogs)) ?: $catalogs;
        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);
        $categoryChildrenAll = $categoryChildren['childrenAll'][0]->values()->toArray();




        // Получаем базовое название без цвета/размера
        $baseTitle = CategoryService::generateGroupKey($product->title);

        $products = Product::with(['param.originalParam'])
            ->where('title', 'LIKE', $baseTitle . '%')
            ->get();

        // Ищем все товары, где название начинается с базового
        //$products = Product::where('title', 'LIKE', $baseTitle . '%')->get();



        // Группируем
        $grouped = collect(CategoryService::getProductParamVariants($products));

        //dd($categoryChildrenAll);


        return inertia('Client/Product/Show', [
            'product' => ProductResource::make($grouped->first())->resolve(),
            'breadcrumbs' => $breadcrumbs,
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],

        ]);

    }
}
