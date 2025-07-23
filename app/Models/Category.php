<?php

namespace App\Models;

use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;


class Category extends Model
{

    protected $table = 'catalogs';


    public function products($catalogs): BelongsToMany
    {
        // Создаем базовое отношение
        $relation = $this->belongsToMany(
            Product::class,
            'suppliers_tovars_catalogs',
            'catalog_id',
            'tovar_id',
            'id',
            'tovar_id'
        );

        if ($this->id_parent === 0) {
            $childCategoryIds = $this->getAllDescendantIds();
            $childCategoryIds[] = $this->id;
        }

        return $relation;
    }


    // Метод для получения всех ID потомков
    protected function getAllDescendantIds(): array
    {
        $ids = [];
        $children = Category::where('id_parent', $this->id)->get();

        foreach ($children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $child->getAllDescendantIds());
        }

        return $ids;
    }
}
