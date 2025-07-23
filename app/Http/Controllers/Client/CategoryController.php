<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Category\ProductIndexRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\GlobalOriginalParamChange;
use App\Models\Product;
use App\Models\SuppliersTovarsCatalogs;
use App\Models\SuppliersTovarsParam;
use App\Services\CategoryService;
use App\Services\ParamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function productIndex(Category $catalogs, ProductIndexRequest $request){


        /*
        * * * Хлебные крошки
        */
        $breadcrumbs = array_reverse(CategoryService::getCategoryParents($catalogs));
        if(!$breadcrumbs) $breadcrumbs = $catalogs;


        /*
         * * * получение категории и подкатегории
        */
        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);
        $categoryChildrenAll = $categoryChildren['childrenAll'][0]->values()->toArray();

        //получение ID товаров по выбранным категориям
        $products = SuppliersTovarsCatalogs::whereIn('catalog_id', array_column($categoryChildren['children'], 'id'));
        //Сначала получим массив tovar_id
        $tovarIds = $products->pluck('tovar_id')->unique()->toArray();

        //Получаем сами товары
        $productQuery  = Product::select(['id', 'sid',  'tovar_id', 'title_original', 'id_parent', 'title', 'url',  'price', 'photo'])
            ->whereIn('tovar_id', $tovarIds);


        if ($request->has('filters')) {

            $filters = $request->input('filters');
            $data = $request->validated();




            if (isset($filters['integer']['from']['drawing'])) {
                $from = $filters['integer']['from']['drawing'];
                $productQuery->where('price', '>=', $from);
            }

            if (isset($filters['integer']['to']['drawing'])) {
                $to = $filters['integer']['to']['drawing'];
                $productQuery->where('price', '<=', $to);
            }


            if(isset($data['filters']['checkbox']['brand'])){

                $productQuery->whereHas('suppliers_tovars_paramp', function($query) use ($filters) {
                    $query->where('type', 'brand')
                        ->whereHas('paramChange', function($q) use ($filters) {
                            $q->whereIn('change', $filters['checkbox']['brand']);
                        });
                });

            }

            if(isset($data['filters']['checkbox']['material'])){

                $productQuery->whereHas('suppliers_tovars_paramp', function($query) use ($filters) {
                    $query->where('type', 'material')
                        ->whereHas('paramChange', function($q) use ($filters) {
                            $q->whereIn('change', $filters['checkbox']['material']);
                        });
                });

            }

            $totalProductsCount = $productQuery->count(); // Общее количество товаров

            //$actualProducts = $productQuery->paginate(500);
            $actualProducts = $productQuery->get();

            if($request->wantsJson()){


                $uniqueProducts = CategoryService::getUniqueProductsByBaseTitle($actualProducts);
                $actualProductsFact = ProductResource::collection($uniqueProducts)->resolve();


                return response()->json([
                    'data' => $actualProductsFact,  // Основные данные
                    'meta' => [
                        'total_count' => $totalProductsCount  // Дополнительная информация
                    ]
                ]);
            }

        }

        $totalProductsCount = $productQuery->count(); // Общее количество товаров


        //$actualProducts = $productQuery->get();
        $actualProducts = $productQuery->paginate(10);


        /**
         * * * ПОЛУЧАЕМ УНИКАЛЬНЫЕ ПАРАМЕТРЫ. * * *
         *
         * Фильтрует товары, оставляя только уникальные по основному названию
         * (часть строки до первой запятой в title_original)
         */
        $uniqueProducts = CategoryService::getUniqueProductsByBaseTitle($actualProducts);
        // извлекаем только ID групп товаров
        $uniqueProductIds = $uniqueProducts->pluck('id');
        //получаем параметры товаров, по категории, сортируем по параметрам и убираем дубли.
        $params_group = ParamService::paramProduct($uniqueProductIds);



        $actualProductsFact = ProductResource::collection($uniqueProducts)->resolve();

        return inertia('Client/Category/ProductIndex', [
            'products' => $actualProductsFact,
            'breadcrumbs' => $breadcrumbs,
            'catalogs' => $catalogs,
            'product_count_subcategories' => $categoryChildrenAll,
            'categories' => $categoryChildren['catalog_tree'],
            'params' => $params_group,
            'total_count' => $totalProductsCount,
        ]);
    }


}
