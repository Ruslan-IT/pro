<?php

namespace App\Http\Resources\Param;

use App\Enums\Param\ParamFilterTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'filter_type' => $this->filter_type,
            'filter_type_title' => $this->filter_type_title,
            'title_translit' => $this->title_translit,
        ];
    }
}
