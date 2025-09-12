<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Models\Drawing;
use App\Models\Product;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;

class SearchController extends Controller
{


    public function search(Request $request)
    {

        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $products = Product::where('title', 'like', "%{$query}%")
            ->orWhere('article', 'like', "%{$query}%")
            ->limit(10)
            ->get(['id', 'title', 'article', 'url', 'price']);

        return response()->json($products);
    }

    // Полноценный поиск с пагинацией (возвращает Inertia-ответ)
    public function searchPage(Request $request, Category $catalogs)
    {

        $query = $request->input('query');

        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        if (!$query) {
            return redirect()->back();
        }

        // Получаем товары с отношениями для группировки
        $products = Product::where('title', 'like', "%{$query}%")
            ->orWhere('article', 'like', "%{$query}%")
            ->with(['param', 'param.originalParam'])
            ->get();

        // Группируем товары аналогично категориям
        $groupedProducts = CategoryService::getProductParamVariants($products);

        // Преобразуем в коллекцию для пагинации
        $groupedProductsCollection = collect(array_values($groupedProducts));

        // Создаем пагинацию
        $perPage = $request->input('per_page', 12);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $groupedProductsCollection->forPage($currentPage, $perPage);

        $paginatedProducts = new LengthAwarePaginator(
            $currentItems,
            $groupedProductsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        $actualProductsFact = ProductResource::collection($paginatedProducts)->resolve();

        // Получаем все виды нанесения
        $drawings = Drawing::all();


        return Inertia::render('Client/Product/Search', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'products' => $actualProductsFact,
            'query' => $query,
            'drawings' => $drawings
        ]);
    }
}
