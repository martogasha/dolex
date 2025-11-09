<?php

use App\Http\Controllers\MpesaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//mpesa routes
Route::get('subscribe', [MpesaController::class, 'subscribe']);
Route::get('register', [MpesaController::class, 'register']);
Route::get('getWebhooks', [MpesaController::class, 'getWebhooks']);
Route::get('authenticate', [MpesaController::class, 'authenticate']);
Route::post('storeWebhooks', [MpesaController::class, 'storeWebhooks']);
