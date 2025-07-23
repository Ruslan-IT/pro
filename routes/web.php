<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


//Log::info('Файл web.php загружен');

require __DIR__.'/client.php';
require __DIR__.'/admin.php';
require __DIR__.'/auth.php';
