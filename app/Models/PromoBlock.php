<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'link',
        'button_text',
        'orders',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];
}
