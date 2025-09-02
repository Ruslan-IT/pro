<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Services\CategoryService;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index(Category $catalogs)
    {
        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        $articles = Article::published()
            ->ordered()
            ->paginate(10);

        return Inertia::render('Client/Article/Index', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'articles' => $articles,
        ]);
    }

    public function show($slug, Category $catalogs)
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        // Увеличиваем счетчик просмотров
        $article->incrementViews();

        return Inertia::render('Client/Article/Show', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'article' => $article,
        ]);
    }
}
