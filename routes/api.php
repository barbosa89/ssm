<?php

use App\Http\Controllers\Admin\Api\TransportKeyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')
    ->prefix('admin/v1')
    ->name('admin.')
    ->group(function () {
        Route::post('transport_keys', [TransportKeyController::class, 'generate'])
            ->name('transport_keys.generate');
    });
