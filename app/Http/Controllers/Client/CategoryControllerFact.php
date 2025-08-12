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

        // 2. Получаем ID всех товаров в категории (для параметров)
        $allTovarIds = SuppliersTovarsCatalogs::whereIn('catalog_id', array_column($categoryChildren['children'], 'id'))
            ->pluck('tovar_id')
            ->unique()
            ->toArray();

        // 3. Получаем ВСЕ параметры категории один раз
        $allProductIdsForParams = Product::whereIn('tovar_id', $allTovarIds)->pluck('id');
        $params_group = ParamService::paramProduct($allProductIdsForParams);



        // 4. Запрос для пагинации товаров (только ID для текущей страницы)
        $productQuery = Product::select(['id', 'sid', 'tovar_id', 'title_original', 'id_parent', 'title', 'url', 'price', 'photo'])
            ->whereIn('tovar_id', $allTovarIds);




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

        $groupedProducts =  CategoryService::groupProductsByIdWithTitles($productQuery->get());




        // Ручная пагинация
        $perPage = $request->input('per_page', 20);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $groupedProducts->forPage($currentPage, $perPage);

        // Создаем пагинатор вручную
        $products = new LengthAwarePaginator(
            $currentItems,
            $groupedProducts->count(),
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
        ]);
    }

}

