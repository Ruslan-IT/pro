<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Drawing;
use App\Services\CategoryService;
use Inertia\Inertia;

class DrawingController extends Controller
{
    // Страница со списком всех видов нанесения
    public function index(Category $catalogs)
    {
        $drawings = Drawing::all();
        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        return Inertia::render('Client/Drawing/Index', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'drawings' => $drawings,
            'seo_title' => 'Все виды нанесения',
            'seo_description' => 'Все виды нанесения изображений на сувенирную продукцию',
            'seo_h1' => 'Все виды нанесения'
        ]);
    }



    // Страница конкретного вида нанесения
    public function show($url,  Category $catalogs)
    {
        $drawing = Drawing::where('url', $url)->firstOrFail();
        $allDrawings = Drawing::all();
        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        return Inertia::render('Client/Drawing/Show', [

            'categories' => $categoryChildren['catalog_tree'],
            'drawing' => $drawing,
            'drawings' => $allDrawings,
            'seo_title' => $drawing->seo_title,
            'seo_description' => $drawing->seo_description,
            'seo_h1' => $drawing->seo_h1
        ]);
    }

    public function list()
    {
        return Drawing::all();
    }
}
