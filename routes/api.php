<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumirServicioController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/urlcallback', [ConsumirServicioController::class, 'urlCallback']);
Route::post('/consultartransaccion', [ConsumirServicioController::class, 'ConsultarEstado']);
