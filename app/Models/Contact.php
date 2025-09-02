<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'email',
        'address',
        'work_time',
        'company_name',
        'inn',
        'kpp',
        'ogrn',
        'legal_address',
        'image',
        'seo_title',
        'seo_description',
        'seo_h1'
    ];

    /**
     * Получить URL изображения
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return null;
    }
}
