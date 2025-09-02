<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'payment_content',
        'delivery_content',
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
