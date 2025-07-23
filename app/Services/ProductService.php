<?php

namespace App\Services;

use App\Http\Requests\Admin\Product\UpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\GlobalOriginalParamChange;
use App\Models\Product;
use App\Models\SuppliersTovars;
use App\Models\SuppliersTovarsParam;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductService
{

    public static function store(mixed $data)
    {
        $product =  Product::create($data['product']);

        //добавление параметров в еще вдве таблице
        ProductService::attachBatchParams($product, $data);

        ImageService::storeBatch($product, $data);
        return $product;
    }


    public static function attachBatchParams(Product $product, array $data)
    {

        foreach ($data['params'] as $param) {

            //Получение последней записи
            $param_change = GlobalOriginalParamChange::latest()->first();
            $lastId = $param_change->id;

            //добавление новых параметров SuppliersTovarsParam
            $suppliers_tovars_param = SuppliersTovarsParam::create([
                'tovar_id' => $product->id,
                'type' => $param['title_translit'],
                'param_id' => $lastId,
            ]);

            //добавление новых параметров GlobalOriginalParamChange
            $suppliers_tovars_param_change = GlobalOriginalParamChange::create([
                'param_id' => $lastId,
                'change' => $param['value'],
            ]);

        }
    }

    public static function update(Product $product, array  $data)
    {
        $product->update($data['product']);
        ImageService::storeBatch($product, $data);
        return $product->fresh();
    }

    public static function indexByCategories(array $categoryChildren ): Collection
    {
        return Product::whereIn('tovar_id', array_column($categoryChildren, 'id'))
            ->whereNull('id_parent')
            ->get();
    }



}

