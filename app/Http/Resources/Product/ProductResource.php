<?php

namespace App\Http\Resources\Product;

//use App\Http\Resources\Cart\CartResource;
//use App\Http\Resources\Image\ImageResource;
//use App\Http\Resources\Param\ParamWithPivotValueResource;
use App\Http\Resources\Image\ImageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        // Для работы с массивом используем array-доступ
        $data = is_array($this->resource) ? $this->resource : $this->resource->toArray();

        $url = 'https://mvgifts.ru/img/tovars/' . $data['sid'] . '/' . $data['tovar_id'] . '/' . $data['tovar_id'] .'.jpg';

        // Получаем размеры изображения (упрощенная версия)
        $height = 200;
        $width = 200;

        return [
            'id' => $data['id'],
            'title' => $data['title'],
            'sid' => $data['sid'],
            'url' => $data['url'],
            'url_img' => $url,
            'height' => $height.'px',
            'width' => $width.'px',
            'article' => $data['article'],
            'content' => $data['content'],
            'total' => $data['total'],
            'id_parent' => $data['id_parent'],
            'price' => $data['price'],
            'base_title' => $data['base_title'] ?? null,
            'variants' => $this->formatVariants($data['variants'] ?? []),
            'params' => $data['params'] ?? null, // Добавляем параметры
        ];
    }

    protected function formatVariants(array $variants): array
    {
        return array_map(function ($variant) {
            return [
                'id' => $variant['id'],
                'title' => $variant['title'],
                'price' => $variant['price'],
                'photo' => $variant['photo'],
                'total' => $variant['total'],
                'tovar_id' => $variant['tovar_id'],
                'color' => $variant['color'],
                'sklad' => $variant['sklad'],
                'article' => $variant['article'],
                'size' => $variant['size'] ?? null,
                'material' => $variant['material'] ?? null,
            ];
        }, $variants);
    }
}


