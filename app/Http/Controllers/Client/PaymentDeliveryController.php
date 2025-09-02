<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentDelivery;
use Inertia\Inertia;

class PaymentDeliveryController extends Controller
{
    public function index()
    {
        $page = PaymentDelivery::first();

        return Inertia::render('Client/PaymentDelivery/Index', [
            'page' => $page,
            'seo_title' => $page->seo_title ?? 'Оплата и доставка',
            'seo_description' => $page->seo_description ?? '',
            'seo_h1' => $page->seo_h1 ?? 'Оплата и доставка'
        ]);
    }
}
