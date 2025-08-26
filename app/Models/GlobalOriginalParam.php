<?php

namespace App\Models;

use App\Enums\GlobalOriginalParamChange\GlobalOriginalParamChangeEnumFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalOriginalParam extends Model
{

    protected $table = 'global_original_param';
    protected $guarded = [];
    public function getFilterTypeTitleAttribute(): string
    {

        //dd(GlobalOriginalParamChangeEnumFilter::map());
        return  GlobalOriginalParamChangeEnumFilter::map()[$this->filter_type_title];

    }
}
