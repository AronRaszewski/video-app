<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\VideoController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::resource('video', VideoController::class, ['except' => ['index', 'show']]);
    Route::post('video/upload', [VideoController::class, 'upload'])->name('video.upload');

    Route::prefix('video/{video}/rate')->controller(RateController::class)->group(function () {

        Route::post('/', 'rate')->name('ratings.rate'); // Ocena lub zmiana oceny

        // Route::post('/', 'store')->name('ratings.store'); // Dodanie oceny
        // Route::put('/', 'update')->name('ratings.update'); // Modyfikacja oceny
        Route::delete('/', 'destroy')->name('ratings.destroy'); // Usunięcie oceny

    });

    Route::resource('video/{video}/comments', CommentController::class, ['only' => ['store']]);
});
Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::resource('video', VideoController::class, ['only' => ['index', 'show']]);

Route::get('search-users/{nickname}', function (Request $request, string $nickname) {
    return User::whereLike('name', '%' . $nickname . '%')->get(['id', 'name']);
})->name('search.users');
