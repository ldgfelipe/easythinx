<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\StripePaymentController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/img/{ref}',[ArchivosController::class,'desEncriptEnlace']);
Route::get('/webhook-stripe',[StripePaymentController::class,'webhookStripe']);

Route::get('/webhook-stripe-oxxo',[StripePaymentController::class,'webhookStripeOxxo']);
Route::get('/webhook-stripe',[StripePaymentController::class,'webhookStripe']);
Route::post('/webhook-stripe',[StripePaymentController::class,'webhookStripe']);

Route::post('/webhook-stripe-oxxo',[StripePaymentController::class,'webhookStripeOxxo']);