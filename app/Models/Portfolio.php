<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category_id',
        'client',
        'project_date',
        'project_url',
        'technologies',
        'gallery',
        'features',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'published_at',
        'sort_order',
    ];

    protected $casts = [
        'project_date' => 'date',
        'published_at' => 'datetime',
        'technologies' => 'array',
        'gallery' => 'array',
        'features' => 'array',
        'is_published' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->image) {
                    return Storage::disk('public')->exists($this->image)
                        ? Storage::disk('public')->url($this->image)
                        : asset('img/portfolio/placeholder.jpg');
                }
                return asset('img/portfolio/placeholder.jpg');
            }
        );
    }

    protected function galleryUrls(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->gallery)) {
                    return [];
                }

                $urls = [];
                foreach ($this->gallery as $image) {
                    $urls[] = Storage::disk('public')->exists($image)
                        ? Storage::disk('public')->url($image)
                        : asset('img/portfolio/placeholder.jpg');
                }

                return $urls;
            }
        );
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
