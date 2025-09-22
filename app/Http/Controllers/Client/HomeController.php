<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\AboutCompanyBlock;
use App\Models\Category;
use App\Models\Slide;
use App\Models\PromoBlock;
use App\Models\News;
use App\Models\Portfolio;
use App\Services\CategoryService;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Category $catalogs)
    {

        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        $slides = Slide::where('is_active', true)
            ->orderBy('orders')
            ->get();

        $promoBlocks = PromoBlock::where('is_active', true)
            ->orderBy('orders')
            ->get();

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

        // Получаем данные для секции "О компании"
        $aboutBlocks = AboutCompanyBlock::active()->ordered()->get();



        return Inertia::render('Client/Home/Index', [
            'slides' => $slides,
            'promoBlocks' => $promoBlocks,
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'portfolio' => $portfolio,
            'news' => $news, // Передаем новости в компонент
            'aboutBlocks' => $aboutBlocks,
        ]);
    }
}
