<?php

namespace App\Models;

//use App\Http\Filters\ProductFilter;
//use App\Models\Traits\HasFilter;
//use App\Observers\ProductObserver;
//use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use App\Models\SuppliersTovarsParam;

#[ObservedBy(ProductObserver::class)]



class Product extends Model
{



    //use HasFilter;z
    protected $table = 'suppliers_tovars';
    protected $guarded = [];

    public function catalogs(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'suppliers_tovars_catalogs',
            'tovar_id',
            'catalog_id'
        );
    }



    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }

    public function siblingProducts(): HasMany
    {
        return  $this->parent->children();
    }

    public function productGroup(): BelongsTo
    {
        return  $this->belongsTo(ProductGroup::class);
    }

    public function getGroupProductsAttribute(): Collection
    {
        return $this->productGroup->products()->whereNot('parent_id', $this->parent_id)->distinct('parent_id')->get();
    }

    public function params(): BelongsToMany
    {
        return $this->belongsToMany(Param::class)->withPivot('value');
    }

    public function category(): BelongsTo
    {

        return $this->belongsTo(Category::class);
    }

    public function children(): HasMany
    {

        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

     public function suppliers_tovars_paramp(): HasMany
    {
        // Если в SuppliersTovarsParam внешний ключ ссылается на Product->id
        return $this->hasMany(SuppliersTovarsParam::class, 'tovar_id', 'id');

    }










}

