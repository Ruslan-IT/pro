<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $guarded = [];
    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
