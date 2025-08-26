<?php

namespace App\Models;

use App\Enums\Param\ParamFilterTypeEnum;
use Illuminate\Database\Eloquent\Model;

class SuppliersTovarsParam extends Model
{

    protected $table = 'suppliers_tovars_param';
    protected $guarded = [];

    public function getFilterTypeTitleAttribute(): string
    {
        return  ParamFilterTypeEnum::map()[$this->filter_type];
    }



    public function product()
    {
        return $this->belongsTo(Product::class, 'tovar_id', 'id');
    }

    public function paramChange()
    {
        return $this->belongsTo(GlobalOriginalParamChange::class, 'param_id', 'param_id');
    }

    public function originalParam()
    {
        return $this->belongsTo(GlobalOriginalParam::class, 'param_id', 'id');
    }
}
