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


    public function products(): BelongsToMany
    {
        // Создаем базовое отношение
        $relation = $this->belongsToMany(
            Product::class,              // 1. Связанная модель
            'suppliers_tovars_catalogs',  // 2. Имя промежуточной таблицы
            'catalog_id',         // 3. Ключ текущей модели в промежуточной таблице
            'tovar_id',           // 4. Ключ связанной модели в промежуточной таблице
            'id',                     // 5. Первичный ключ текущей модели (опционально)
            'tovar_id'                // 6. Первичный ключ связанной модели (опционально)
        );

       /* if ($this->id_parent === 0) {
            $childCategoryIds = $this->getAllDescendantIds();
            $childCategoryIds[] = $this->id;
        }*/

        return $relation;
    }


    // Метод для получения всех ID потомков
    public function getAllDescendantIds(): array
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
