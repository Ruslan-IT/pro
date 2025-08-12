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

    public static function getCategoryChildren(Category $category, $category_all): array
    {
        $arr = [];
        //$categoryChildren = $category_all->where('id_parent', $category->id);
        $categoryChildren = $category_all->where('id_parent', $category->id);

        //dd($categoryChildren);

        foreach ($categoryChildren as $categoryChild) {
            $arr = array_merge($arr, self::getCategoryChildren($categoryChild, $category_all));
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

    /**
     * Группирует товары по основному названию (часть до первой запятой/точки с запятой)
     * Возвращает массив, где ключ - базовое название, а значение - коллекция вариантов
     */
    public static function groupProductsByIdWithTitles2($products)
    {


        return $products->map(function ($product) {
            $parts = preg_split('/[,;]/', $product->title_original, 2);

            // Сохраняем дополнительные данные в самом продукте
            $product->base_title = trim($parts[0]);
            $product->variant = isset($parts[1]) ? trim($parts[1]) : '';

            return $product;
        })


            ->groupBy('base_title') // Группируем по базовому названию
            ->map(function ($group) {
                $mainProduct = $group->first();

                // Добавляем варианты к основному продукту
                $mainProduct->variants = $group->slice(1)->values();

                return $mainProduct;
            })
            ->values();


    }

    /**
     * Группирует продукты по ключу, извлеченному из названия, и формирует варианты по цветам
     *
     * @param \Illuminate\Support\Collection $products Коллекция продуктов для группировки
     * @return \Illuminate\Support\Collection Группированная коллекция с основными продуктами и вариантами
     */
    public static function groupProductsByIdWithTitles($products)
    {
        return $products->groupBy(function ($product) {
            return self::generateGroupKey($product->title);
        })
            ->map(function ($productGroup) {
                $mainProduct = $productGroup->first();
                $colors = [];
                $variants = [];

                foreach ($productGroup as $product) {
                    $color = self::extractColorFromTitle($product->title);

                    // Если цвет не найден, пробуем извлечь из других полей
                    if (!$color && isset($product->color)) {
                        $color = $product->color;
                    }

                    if ($color && !isset($colors[$color])) {
                        $variants[] = [
                            'id' => $product->id,
                            'title' => $product->title,
                            'price' => $product->price,
                            'photo' => $product->photo,
                            'total' => $product->total,
                            'tovar_id' => $product->tovar_id,
                            'color' => $color,
                            'sklad' => $product->sklad,
                            'article' => $product->article
                        ];
                        $colors[$color] = true; // Используем ассоциативный массив для уникальности
                    }
                }

                $mainProduct->variants = $variants;
                $mainProduct->color = self::extractColorFromTitle($mainProduct->title)
                    ?? $mainProduct->color
                    ?? null;

                return $mainProduct;
            })
            ->values();
    }

    /**
     * Генерирует ключ группировки на основе названия товара
     *
     * @param string $title Название товара
     * @return string Ключ для группировки
     */
    public static function generateGroupKey($title)
    {
        // Нормализация: удаление лишних пробелов
        $title = trim($title);

        // 1. Группировка по части до первой запятой/точки с запятой
        if (strpos($title, ',') !== false) {
            return trim(explode(',', $title)[0]);
        }
        if (strpos($title, ';') !== false) {
            return trim(explode(';', $title)[0]);
        }

        // 2. Группировка по первым 4 цифрам (для артикулов)
        if (preg_match('/^(\d{4})/', $title, $matches)) {
            return $matches[1];
        }

        // 3. Группировка по названию до указания размера
        if (preg_match('/(.*?)\s*,\s*размер\s*[SMLX]+/ui', $title, $matches)) {
            return trim($matches[1]);
        }
        if (preg_match('/(.*?)\s*размер\s*[SMLX]+/ui', $title, $matches)) {
            return trim($matches[1]);
        }

        // 4. Группировка для товаров с римскими цифрами (версии/серии)
        if (preg_match('/(.*?)\s*[IVX]+$/u', $title, $matches)) {
            return trim($matches[1]);
        }

        // 5. Группировка для товаров с цветом в конце (без разделителя)
        if (preg_match('/(.*?)\s+[а-яё]+$/ui', $title, $matches)) {
            $base = trim($matches[1]);
            $possibleColor = trim(str_replace($base, '', $title));
            // Проверяем, является ли последнее слово цветом
            if (self::isColorWord($possibleColor)) {
                return $base;
            }
        }

        // 6. Возвращаем полное название, если не сработали другие правила
        return $title;
    }

    /**
     * Проверяет, является ли слово названием цвета
     *
     * @param string $word Проверяемое слово
     * @return bool True если слово есть в списке цветов
     */
    protected static function isColorWord($word)
    {
        // Список распознаваемых цветов
        $colors = ['красный', 'красная', 'синий', 'тёмно-синий', 'зеленый', 'черный', 'белый', 'желтый', 'жёлтый',
            'голубой', 'фиолетовый', 'оранжевый', 'серый', 'серый меланж', 'серебристый',
            'золотой', 'коричневый', 'розовый', 'бирюзовый', 'бежевый'];

        return in_array(mb_strtolower(trim($word)), $colors);
    }


    /**
     * Извлекает цвет из названия товара с учетом сложных составных цветов и размеров
     *
     * @param string $title Название товара
     * @return string|null Найденный цвет или null
     */
    protected static function extractColorFromTitle($title)
    {
        // Приводим к нижнему регистру и удаляем лишние пробелы
        $title = mb_strtolower(trim($title));

        // Расширенный список цветов с вариантами написания
        $colorMap = [
            'бел' => 'белый',
            'черн' => 'черный',
            'красн' => 'красный',
            'син' => 'синий',
            'голуб' => 'голубой',
            'зелен' => 'зеленый',
            'желт' => 'желтый',
            'оранж' => 'оранжевый',
            'фиолет' => 'фиолетовый',
            'розов' => 'розовый',
            'сер' => 'серый',
            'серебр' => 'серебристый',
            'золот' => 'золотой',
            'коричнев' => 'коричневый',
            'бирюз' => 'бирюзовый',
            'беж' => 'бежевый',
            'бордов' => 'бордовый',
            'мокко' => 'мокко',
            'сиренев' => 'сиреневый',
            'кремов' => 'кремовый',
            'пастельн' => 'пастельный',
            'морск' => 'морская волна',
            'тёмно' => 'тёмный',
            'ярко' => 'яркий'
        ];

        // 1. Сначала проверяем цвета с размерами (например, "белый_xs")
        if (preg_match('/([а-яё-]+)_[smlx\d]+/ui', $title, $matches)) {
            $possibleColor = $matches[1];

            // Проверяем составные цвета (типа "ярко-синий")
            if (str_contains($possibleColor, '-')) {
                $colorParts = explode('-', $possibleColor);
                foreach ($colorMap as $key => $color) {
                    if (mb_strpos($colorParts[1], $key) === 0) {
                        return $colorParts[0] . '-' . $color;
                    }
                }
            }

            // Проверяем простые цвета
            foreach ($colorMap as $key => $color) {
                if (mb_strpos($possibleColor, $key) === 0) {
                    return $color;
                }
            }
        }

        // 2. Проверяем сложные составные цвета (типа "ярко-синий")
        if (preg_match('/(тёмно|ярко)\-?(\s*[а-яё]+)/ui', $title, $matches)) {
            $prefix = $matches[1];
            $baseColor = $matches[2];

            foreach ($colorMap as $key => $color) {
                if (mb_strpos($baseColor, $key) === 0) {
                    return $prefix . '-' . $color;
                }
            }
        }

        // 3. Проверяем простые цвета и составные без префикса
        foreach ($colorMap as $key => $color) {
            // Ищем цвет как отдельное слово
            if (preg_match('/\b'.$key.'[а-яё]*\b/u', $title)) {
                // Особые случаи
                if ($key === 'пастельн' && preg_match('/пастельн\s*зелё?н/u', $title)) {
                    return 'пастельный зеленый';
                }
                if ($key === 'морск' && preg_match('/морск\s*волн/u', $title)) {
                    return 'морская волна';
                }
                if ($key === 'сер' && preg_match('/сер\s*меланж/u', $title)) {
                    return 'серый меланж';
                }
                return $color;
            }
        }

        return null;
    }







}
