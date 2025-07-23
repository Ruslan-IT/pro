<?php

namespace App\Http\Resources\Param;

use App\Enums\Param\ParamFilterTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParamWithPivotValueResource extends JsonResource
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
            'value' => $this->getOriginal('pivot_value'),
        ];
    }
}
