<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutCompanyBlock extends Model
{
    use HasFactory;

    protected $table = 'about_company_blocks';

    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'button_text',
        'is_main',
        'orders',
        'is_active'
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'is_active' => 'boolean',
        'orders' => 'integer'
    ];

    public function scopeMain($query)
    {
        return $query->where('is_main', true)->where('is_active', true);
    }

    public function scopeBlocks($query)
    {
        return $query->where('is_main', false)->where('is_active', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('orders');
    }
}
