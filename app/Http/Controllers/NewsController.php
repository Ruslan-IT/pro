<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Services\CategoryService;
use Inertia\Inertia;

class NewsController extends Controller
{
    public function index(Category $catalogs)
    {
        $news = News::published()
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);



        return Inertia::render('Client/News/Index', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'news' => $news
        ]);
    }

    public function show(Category $catalogs, News $news)
    {
        if (!$news->is_published || $news->published_at->isFuture()) {
            abort(404);
        }

        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        return Inertia::render('Client/News/Show', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'newsItem' => $news
        ]);
    }
}
