<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\Portfolio;
use App\Services\CategoryService;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Category $catalogs)
    {

        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        // Получаем последние работы из портфолио (например, 3 последние)
        $portfolio = Portfolio::published()
            ->orderBy('published_at', 'desc')
            ->take(6)
            ->get();

        // Получаем последние новости
        $news = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(6) // Берем 3 последние новости
            ->get();


        return Inertia::render('Client/Home/Index', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'portfolio' => $portfolio,
            'news' => $news, // Передаем новости в компонент

        ]);
    }
}
