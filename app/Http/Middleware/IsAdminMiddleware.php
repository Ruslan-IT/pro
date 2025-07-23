<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        // Для API-запросов возвращаем JSON-ошибку
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Для веб-запросов редирект с сообщением
        return redirect('/')->with('error', 'Доступ запрещен');
    }
}


