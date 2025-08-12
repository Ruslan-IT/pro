<?php

namespace App\Services;

use App\Models\Param;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ParamService
{
    public static function store(array $data): Param
    {
        return Param::create($data);
    }

    public static function update(Param $param, array $data): Param
    {
        $param->update($data);
        return $param->fresh();
    }


    public static function indexByCategories(Collection $categoryChildren): Collection
    {

//        $arr = collect([]);
//        $categoryChildren->pluck('paramProducts')->each(function ($coll) use ($arr) {
//            $coll->each(function ($c)  use ($arr) {
//                $arr->push($c);
//            });
//        });

        $arr = [];
        foreach ($categoryChildren->load('paramProducts')->pluck('paramProducts') as $paramProducts) {
            $arr = array_merge($arr, $paramProducts->toArray());
        }
        $arr = collect($arr);

        $params = Param::whereIn('id', $arr->pluck('param_id')->unique())->get();
        $arr = $arr->groupBy('param_id');

        foreach ($params as $param) {
            $param->param_values = $arr[$param->id]->unique('value')->sortBy('value')->pluck('value')->toArray();
        }

        return $params;

    }


    //получаем параметры товаров, по категории, сортируем по параметрам и убираем дубли.
    public static function paramProduct($uniqueProductIds)
    {

        //получаем параметры по товарам
        $params = DB::table('suppliers_tovars_param')
            ->join('global_original_param_change', 'suppliers_tovars_param.param_id', '=', 'global_original_param_change.param_id')
            ->whereIn('suppliers_tovars_param.tovar_id', $uniqueProductIds)
            ->select(
                'suppliers_tovars_param.param_id',
                'suppliers_tovars_param.type', // Добавляем поле type
                'global_original_param_change.change'
            )
            //->distinct() // устранение дубликатов
            ->get()
            ->values() //сбрасывает ключи коллекции
            ->map(function ($item, $index) { //преобразует каждую запись
                // Группир уем по param_id, сохраняя все данные
                return [
                    'type' => $item->type,
                    'param_id' => $item->param_id, // Сохраняем оригинальный param_id
                    'change' => $item->change
                ];
            });



        return $params
            ->groupBy('type')
            ->map(function ($group) {
                return $group->unique('change'); //  удалить дубликаты
            })
            ->toArray();
    }
}
