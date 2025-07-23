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
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {


        $url = 'https://mvgifts.ru/img/tovars/' . $this->sid . '/' . $this->tovar_id . '/' . $this->tovar_id .'.jpg';

        $wh = getimagesize($url);

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


       /* $url ='';
        $height = '';
        $width = '';*/
        return [
            'id' => $this->id,
            'title' => $this->title,
            'sid' => $this->sid,
            'url_img' => $url,
            'height' => $height.'px',
            'width' => $width.'px',
            'article' => $this->article,
            //'article' => $this->article,
            //'description' => $this->description,
            'id_parent' => $this->id_parent,
            //'content' => $this->content,
            'price' => $this->price,
            //'old_price' => $this->old_price,
            //'qty' => $this->qty,
            //'category_id' => $this->category_id,
            //'product_group_id' => $this->product_group_id,
            //'cart' => CartResource::make($this->cart)->resolve(),
            //'has_children' => $this->has_children,
            //'images' => ImageResource::collection($this->images)->resolve(),
            //'preview_image_url' => $this->preview_image_url,
            //'params' => ParamWithPivotValueResource::collection($this->params)->resolve()
        ];
    }
}


