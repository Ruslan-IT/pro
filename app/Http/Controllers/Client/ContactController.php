<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $page = Contact::first();

        return Inertia::render('Client/Contact/Index', [
            'page' => $page,
            'seo_title' => $page->seo_title ?? 'Контакты',
            'seo_description' => $page->seo_description ?? '',
            'seo_h1' => $page->seo_h1 ?? 'Контакты'
        ]);
    }
}
