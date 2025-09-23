<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CallbackRequest;

class CallbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'agreedToPrivacy' => 'required|accepted',
        ]);

        try {
            // Отправка email администратору
            Mail::to('info@mvgifts.ru')->send(new CallbackRequest($validated));

            // Отправка копии на email пользователя, если он указан
            if (!empty($validated['email'])) {
                Mail::to($validated['email'])->send(new CallbackRequest($validated, true));
            }

            return response()->json([
                'success' => true,
                'message' => 'Заявка успешно отправлена'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка при отправке заявки: ' . $e->getMessage()
            ], 500);
        }
    }
}
