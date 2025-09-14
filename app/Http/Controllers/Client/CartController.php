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

        // Если items пришел как JSON-строка, декодируем его
        if (is_string($validated['items'])) {
            $validated['items'] = json_decode($validated['items'], true);
        }

        // Обрабатываем items для добавления информации о нанесении
        $processedItems = [];
        foreach ($validated['items'] as $item) {
            $processedItem = [
                'title' => $item['title'] ?? 'Без названия',
                'quantity' => $item['quantity'] ?? 1,
                'price' => $item['price'] ?? 0,
                'article' => $item['article'] ?? '',
                'color' => $item['color'] ?? '',
                'size' => $item['size'] ?? '',
                'with_printing' => $item['with_printing'] ?? false,
                'printing_cost' => $item['printing_cost'] ?? 0,
                'image' => $item['image'] ?? ''
            ];
            $processedItems[] = $processedItem;
        }

        // Добавляем статус по умолчанию
        $validated['items'] = $processedItems;
        $validated['status'] = Cart::STATUS_NEW;
        $validated['is_paid'] = false;

        // Сохраняем заказ в базу данных
        $cart = Cart::create($validated);


        Mail::to($cart['email'])->send(new OrderCreatedMail($cart));

        // Очищаем корзину после успешного сохранения

        return response()->json([
            'success' => true,
            'message' => 'Заказ успешно отправлен!',
            'order_id' => $cart->id
        ]);
    }
}
