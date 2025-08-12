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
        $url = 'https://mvgifts.ru/img/tovars/' . $this->sid . '/' . $this->tovar_id . '/' . $this->tovar_id .'.jpg';

        // Получаем размеры изображения с обработкой ошибок
        $height = 200;
        $width = 200;

        try {
            $wh = getimagesize($url);
            if ($wh) {
                $height = $wh[1];
                $width = $wh[0];
                if ($wh[1] > 200) {
                    $height = 200;
                    $width = ($height * $wh[0]) / $wh[1];
                }
                if ($width > 200) {
                    $width = 200;
                    $height = ($width * $wh[1]) / $wh[0];
                }
            }
        } catch (\Exception $e) {
            // В случае ошибки оставляем значения по умолчанию
        }

        // Обработка вариантов - теперь работает и с массивом, и с коллекцией
        $variants = [];
        if (!empty($this->variants)) {
            // Если variants - это коллекция, преобразуем в массив
            $variantsArray = is_array($this->variants) ? $this->variants : $this->variants->toArray();

            foreach ($variantsArray as $variant) {
                $variants[] = [
                    'id' => $variant['id'] ?? null,
                    'title' => $variant['title'] ?? null,
                    'price' => $variant['price'] ?? null,
                    'photo' => $variant['photo'] ?? null,
                    'total' => $variant['total'] ?? null,
                    'tovar_id' => $variant['tovar_id'] ?? null,
                    'color' => $variant['color'] ?? null,
                    'sklad' => $variant['sklad'] ?? null,
                    'article' => $variant['article'] ?? null,
                ];
            }
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'sid' => $this->sid,
            'url_img' => $url,
            'height' => $height.'px',
            'width' => $width.'px',
            'article' => $this->article,
            'total' => $this->total,
            'id_parent' => $this->id_parent,
            'price' => $this->price,
            'base_title' => $this->base_title ?? null,
            'variants' => $variants,
        ];
    }
}


