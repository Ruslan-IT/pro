<?php

namespace App\Models;

use App\Enums\Param\ParamFilterTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $guarded = [];
    public function getFilterTypeTitleAttribute(): string
    {
        return  ParamFilterTypeEnum::map()[$this->filter_type];
    }
}
