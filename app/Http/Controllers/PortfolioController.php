<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Category;
use App\Services\CategoryService;
use Inertia\Inertia;

class PortfolioController extends Controller
{
    public function index(Category $catalogs)
    {


        $portfolio = Portfolio::published()
            ->orderBy('published_at', 'desc')
            ->paginate(10);


        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);




        return Inertia::render('Client/Portfolio/Index', [
            'portfolio' => $portfolio,
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
        ]);
    }

    public function show(Category $catalogs, Portfolio $portfolio)
    {



        /*if (!$portfolio->is_published || $portfolio->published_at->isFuture()) {
            abort(404);
        }*/

        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);


        return Inertia::render('Client/Portfolio/Show', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'portfolioItem' => $portfolio
        ]);
    }
}
