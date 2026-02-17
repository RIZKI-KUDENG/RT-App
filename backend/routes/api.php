<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OccupantController;
use App\Http\Controllers\HouseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/occupants', [OccupantController::class, 'store']);
Route::get('/occupants', [OccupantController::class, 'index']);
Route::get('/houses', [HouseController::class, 'index']);
