<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PaymentDelivery;
use App\Services\CategoryService;
use Inertia\Inertia;

class PaymentDeliveryController extends Controller
{
    public function index(Category $catalogs)
    {
        $page = PaymentDelivery::first();

        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        return Inertia::render('Client/PaymentDelivery/Index', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'page' => $page,
            'seo_title' => $page->seo_title ?? 'Оплата и доставка',
            'seo_description' => $page->seo_description ?? '',
            'seo_h1' => $page->seo_h1 ?? 'Оплата и доставка'
        ]);
    }
}
