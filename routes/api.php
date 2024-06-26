<?php

use App\Http\Controllers\RoomController;
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


Route::get('/rooms/{hotel_name}/{checkin_date}/{checkout_date}', [RoomController::class, 'getAvailableRooms']);
Route::get('/rooms/{hotel_name}/{checkin_date}/{checkout_date}/{id}', [RoomController::class, 'getAvailableRooms']);
Route::get('/rooms/weather/{hotel_name}', [RoomController::class, 'getWeather']);
