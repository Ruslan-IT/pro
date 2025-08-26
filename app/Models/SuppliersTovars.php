<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliersTovars extends Model
{
    use HasFactory;
    protected $table = 'suppliers_tovars';

    protected $fillable = [
        'sid',
        'tovar_id',
        'id_parent',
        'article',
        'title',
        'url',
        'title_full',
        'title_original',
        'price',
        'content',
        'count_in_box',
        'v_box',
        'weight_box',
        'weight_1',
        'v_1',
        'total',
        'catalog_id',
        'filtr_size',
        'sale',
        'date',
        'date_update',
        'photo',
        'sklad',
        'photo_src'
    ];

    public static function create($data)
    {
    }
}
