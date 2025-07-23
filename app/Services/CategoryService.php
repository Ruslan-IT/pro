<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public static function store(array $data): Category
    {
        return Category::create($data);

    }

    public static function update(Category $catalogs, array $data): Category
    {
        $catalogs->update($data);
        return $catalogs->fresh();

    }

    public static function getCategoryChildren(Category $category): array
    {
        $arr = [];
        $categoryChildren = Category::where('id_parent', $category->id)->get();

        //dd($categoryChildren);

        foreach ($categoryChildren as $categoryChild) {
            $arr = array_merge($arr, self::getCategoryChildren($categoryChild));
        }

        $arr[] = $category;
        return $arr;
    }


    public static function getCategoryChildren2(Category $category): array
    {
        // Загружаем все категории одним запросом
        $allCategories = Category::select(['id', 'id_parent', 'title'])->get()->keyBy('id');
        return self::getChildrenRecursive($category, $allCategories);
    }

    private static function getChildrenRecursive(Category $category, \Illuminate\Support\Collection $allCategories,array &$result = []): array {
        // Добавляем текущую категорию в результат
        $result[] = $category;

        // Ищем дочерние категории в уже загруженной коллекции
        $children = $allCategories->where('id_parent', $category->id);

        //ищем родителя категории
        $childrenAll = $allCategories->where('id_parent', $category->id_parent);
        if($category->id_parent === 0){
            $childrenAll = $allCategories->where('id_parent', $category->id);
        }

        $childrenAll2[] = $childrenAll;


        foreach ($children as $child) {
            self::getChildrenRecursive($child, $allCategories, $result);
        }

        /****************************************************************************/
        //дерево каталога временное решение
        /****************************************************************************/

        $tree = [];
        foreach ($allCategories as $category) {
            if ($category->id_parent == 0) {
                $tree[$category->id] = [
                    'id' => $category->id,
                    'title' => $category->title,
                    'url' => $category->url,
                    'children' => []
                ];
            }
        }

        foreach ($allCategories as $category) {
            if ($category->id_parent != 0 && isset($tree[$category->id_parent])) {
                $tree[$category->id_parent]['children'][] = [
                    'id' => $category->id,
                    'title' => $category->title,
                    'url' => $category->url
                ];
            }
        }

        /****************************************************************************/
        /****************************************************************************/


        $resultAll = [
            'children' => $result,
            'childrenAll' => $childrenAll2,
            'catalog_tree' => array_values($tree),
        ];

        return $resultAll;
    }



    public static function getCategoryParents(Category $category): array
    {
        //dd($category->id_parent);
        $arr = [];
        if($category->id_parent){
            $parentCategory = Category::select(['id', 'id_parent', 'title'])
                ->find($category->id_parent);

            $arr[] = $parentCategory;

            $arr = array_merge($arr, self::getCategoryParents($parentCategory));
        }
        //$arr[] = $category;
        return $arr;
    }

    /**
     * Фильтрует товары, оставляя только уникальные по основному названию
     * (часть строки до первой запятой в title_original)
     */
    public static function getUniqueProductsByBaseTitle($products)
    {
        return $products->map(function ($product) {
            // Разделяем по запятой или точке с запятой
            $parts = preg_split('/[,;]/', $product->title_original, 2);
            $product->base_title = trim($parts[0]);
            return $product;
        })
            ->unique('base_title') // Оставляем только уникальные по base_title
            ->values(); // Сбрасываем ключи
    }







}
