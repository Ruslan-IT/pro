<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Category\ProductIndexRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Drawing;
use App\Models\GlobalOriginalParamChange;
use App\Models\Product;
use App\Models\SuppliersTovarsCatalogs;
use App\Models\SuppliersTovarsParam;
use App\Services\CategoryService;
use App\Services\ParamService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function productIndex(Category $catalogs, ProductIndexRequest $request)
    {
        // 1. Получаем базовые данные (категории, хлебные крошки)
        $breadcrumbs = array_reverse(CategoryService::getCategoryParents($catalogs)) ?: $catalogs;
        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);
        $categoryChildrenAll = $categoryChildren['childrenAll'][0]->values()->toArray();

        // Получаем все виды нанесения
        $drawings = Drawing::all();

        //dd($categoryChildren);

        // 2. Получаем ID всех товаров в категории (для параметров)
        $allTovarIds = SuppliersTovarsCatalogs::whereIn('catalog_id', array_column($categoryChildren['children'], 'id'))
            ->pluck('tovar_id')
            ->toArray();



        // 3. Получаем ВСЕ параметры категории один раз
        $allProductIdsForParams = Product::whereIn('tovar_id', $allTovarIds)->pluck('id');

        $params_group = ParamService::paramProduct($allProductIdsForParams);

        // Получаем все товары с их параметрами

        $productQuery = Product::select([
            'suppliers_tovars.id',
            'suppliers_tovars.sid',
            'suppliers_tovars.tovar_id',
            'suppliers_tovars.title_original',
            'suppliers_tovars.id_parent',
            'suppliers_tovars.title',
            'suppliers_tovars.url',
            'suppliers_tovars.price',
            'suppliers_tovars.photo',
            'suppliers_tovars.content',
            'suppliers_tovars.article',
            'suppliers_tovars.total'
        ])
            ->leftJoin('suppliers', 'suppliers.id', '=', 'suppliers_tovars.sid') // LEFT JOIN с таблицей поставщиков
            ->addSelect('suppliers.sklad')                                       // Добавляем выборку поля "склад" из таблицы поставщиков
            ->whereIn('suppliers_tovars.tovar_id', $allTovarIds)                 // Фильтруем товары по списку UUID
            ->with(['param' => function($query) {                                // Загружаем связанные параметры товаров
                $query->select('tovar_id', 'param_id', 'type')                   // Выбираем нужные поля из таблицы параметров
                    ->with(['originalParam' => function($q) {                    // Загружаем связанные оригинальные параметры
                        $q->select('id', 'original', 'type');                    // Выбираем нужные поля из таблицы оригинальных параметров
                    }]);
            }]);



        // Применение фильтров
        if ($request->has('filters')) {

            $filters = $request->input('filters');
            $data = $request->validated();

            if (isset($filters['integer']['from']['drawing'])) {
                $productQuery->where('price', '>=', $filters['integer']['from']['drawing']);
            }

            if (isset($filters['integer']['to']['drawing'])) {
                $productQuery->where('price', '<=', $filters['integer']['to']['drawing']);
            }


            if (isset($filters['integer']['from']['quantity'])) {
                $productQuery->where('suppliers_tovars.total', '>=', $filters['integer']['from']['quantity']);
            }

            if (isset($filters['integer']['to']['quantity'])) {
                $productQuery->where('suppliers_tovars.total', '<=', $filters['integer']['to']['quantity']);
            }



            if(isset($data['filters']['checkbox']['brand'])) {
                $productQuery->whereHas('suppliers_tovars_paramp', function($query) use ($filters) {
                    $query->where('type', 'brand')
                        ->whereHas('paramChange', function($q) use ($filters) {
                            $q->whereIn('change', $filters['checkbox']['brand']);
                        });
                });
            }

            if(isset($data['filters']['checkbox']['material'])) {
                $productQuery->whereHas('suppliers_tovars_paramp', function($query) use ($filters) {
                    $query->where('type', 'material')
                        ->whereHas('paramChange', function($q) use ($filters) {
                            $q->whereIn('change', $filters['checkbox']['material']);
                        });
                });
            }
        }




        $groupedProducts = CategoryService::getProductParamVariants($productQuery->get());

        $groupedProductsCollection = collect(array_values($groupedProducts));

        // пагинацию:
        $perPage = $request->input('per_page', 20);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $groupedProductsCollection->forPage($currentPage, $perPage);

        $products = new LengthAwarePaginator(
            $currentItems,
            $groupedProductsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // 6. Формируем ответ
        $actualProductsFact = ProductResource::collection($products)->resolve();

        if($request->wantsJson()) {
            return response()->json([
                'data' => $actualProductsFact,
                'meta' => [
                    'total_count' => $products->total(),
                    'current_page' => $products->currentPage(),
                    'per_page' => $products->perPage(),
                    'last_page' => $products->lastPage(),
                ],
                'params' => $params_group, // Все параметры категории
                'drawings' => $drawings,
            ]);
        }

        return inertia('Client/Category/ProductIndex', [
            'products' => $actualProductsFact,
            'breadcrumbs' => $breadcrumbs,
            'catalogs' => $catalogs,
            'product_count_subcategories' => $categoryChildrenAll,
            'categories' => $categoryChildren['catalog_tree'],
            'params' => $params_group, // Все параметры категории
            'total_count' => $products->total(),
            'pagination' => $products->toArray(),
            'drawings' => $drawings,
        ]);
    }

}

