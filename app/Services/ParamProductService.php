<?php

namespace App\Services;

use App\Models\ParamProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ParamProductService
{
    public static function replicateBatch(Product $product, Product $cloneProduct)
    {
        foreach ($product->paramProducts as $paramProduct) {
            $cloneParamProduct = $paramProduct->replicate();
            $cloneParamProduct->product_id = $cloneProduct->id;
            $cloneParamProduct->push();
        }
    }

    public static function getGroupedByParamArray(Product $product): array
    {
        $paramProducts = ParamProduct::groupedByParams($product)->get()
        ->groupBy('param_id')->map(function ($paramProductItem) {
            return [
                'title' => $paramProductItem->first()->title,
                'data' => $paramProductItem->toArray()
            ];
        });

        return array_values($paramProducts->toArray());
    }
}
