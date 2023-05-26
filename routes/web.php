<?php

use App\Http\Controllers\Admin\SymmetricKeyController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', WelcomeController::class);

Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::delete('symmetrics/{symmetric}', [SymmetricKeyController::class, 'destroy'])
            ->name('symmetrics.destroy');

        Route::patch('symmetrics/{symmetric}', [SymmetricKeyController::class, 'update'])
            ->name('symmetrics.update');

        Route::get('symmetrics/{symmetric}/edit', [SymmetricKeyController::class, 'edit'])
            ->name('symmetrics.edit');

        Route::post('symmetrics', [SymmetricKeyController::class, 'store'])
            ->name('symmetrics.store');

        Route::get('symmetrics/create', [SymmetricKeyController::class, 'create'])
            ->name('symmetrics.create');

        Route::get('symmetrics', [SymmetricKeyController::class, 'index'])
            ->name('symmetrics.index');

        Route::get('symmetrics/{symmetric}', [SymmetricKeyController::class, 'show'])
            ->name('symmetrics.show');
    });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
