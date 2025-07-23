<?php

namespace App\Http\Resources;


use App\Enums\GlobalOriginalParamChange\GlobalOriginalParamChangeEnumFilter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GlobalOriginalParamChangeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray ( $request)
    {

        return [
            'id' => $this->id,
            'original' => $this->original,
            'type' => $this->type,
            /*'filter_type_title' => $this->filter_type_title,*/

        ];
    }
}
