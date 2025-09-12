<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Contact;
use App\Services\CategoryService;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index(Category $catalogs)
    {
        $page = Contact::first();

        $categoryChildren = CategoryService::getCategoryChildren2($catalogs);

        return Inertia::render('Client/Contact/Index', [
            'catalogs' => $catalogs,
            'categories' => $categoryChildren['catalog_tree'],
            'page' => $page,
            'seo_title' => $page->seo_title ?? 'Контакты',
            'seo_description' => $page->seo_description ?? '',
            'seo_h1' => $page->seo_h1 ?? 'Контакты'
        ]);
    }
}
