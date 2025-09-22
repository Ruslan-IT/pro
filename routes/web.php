<?php


use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CallbackController;
use App\Http\Controllers\Client\SearchController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


//Log::info('Файл web.php загружен');

require __DIR__.'/client.php';
require __DIR__.'/admin.php';
require __DIR__.'/auth.php';


Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{portfolio:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Роуты для раздела "Нанесение"
/*Route::get('/drawing', [App\Http\Controllers\Client\DrawingController::class, 'index'])->name('client.drawing.index');*/
Route::get('/drawing/{url}', [App\Http\Controllers\Client\DrawingController::class, 'show'])->name('client.drawing.show');
Route::get('/drawing-list', [App\Http\Controllers\Client\DrawingController::class, 'list'])->name('client.drawing.list');

// Страница оплаты и доставки
Route::get('/payment-delivery', [App\Http\Controllers\Client\PaymentDeliveryController::class, 'index'])->name('client.payment-delivery.index');
// Страница контактов
Route::get('/contacts', [App\Http\Controllers\Client\ContactController::class, 'index'])->name('client.contacts.index');

// Политика конфиденциальности (редирект на общий маршрут)
Route::get('/privacy-policy', function () {
    return redirect()->route('pages.show', 'privacy-policy');
});

// Страницы
Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.show');

Route::post('/api/callback', [CallbackController::class, 'store']);
