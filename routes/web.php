<?php

use App\Http\Controllers\Game\AnimalController;
use App\Http\Controllers\Game\FarmController;
use App\Http\Controllers\Game\MainController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('game')->name('game')->group(function () {
        Route::get('/', MainController::class);

        Route::prefix('animals')->name('.animals')->group(function () {
            Route::get('/', [AnimalController::class, 'index'])->name('.list');
            Route::post('add', [AnimalController::class, 'create'])->name('.adding');
        });
    });
});
