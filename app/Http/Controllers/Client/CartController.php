<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderCreatedMail;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function index()
    {
        return inertia('Client/Cart/Index');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'items' => 'required|array',
            'total_price' => 'required|numeric',
            'agreed_to_privacy' => 'required|accepted'
        ]);

        // Добавляем статус по умолчанию
        $validated['status'] = Cart::STATUS_NEW;
        $validated['is_paid'] = false;

        // Сохраняем заказ в базу данных
        $cart = Cart::create($validated);

        Mail::to('admin@ru-landing.ru')->send(new OrderCreatedMail($cart));

        // Очищаем корзину после успешного сохранения

        return response()->json([
            'success' => true,
            'message' => 'Заказ успешно отправлен!',
            'order_id' => $cart->id
        ]);
    }
}
