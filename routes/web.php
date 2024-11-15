<?php

use App\Http\Controllers\VideoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {



    Route::resource('video', VideoController::class, ['except' => ['index', 'show']]);
});
Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::resource('video', VideoController::class, ['only' => ['index', 'show']]);
