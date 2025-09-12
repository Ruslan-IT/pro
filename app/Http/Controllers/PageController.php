<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Services\CategoryService;
use Inertia\Inertia;

class PageController extends Controller
{
    public function show(Category $catalogs, $slug)
    {

        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return Inertia::render('Client/Pages/Page', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'page' => $page
        ]);
    }
}
