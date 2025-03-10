<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ParkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/register",[AuthController::class, "createUser"]);
Route::post("/login",[AuthController::class, "loginUser"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/parks", [ParkController::class, "allParks"]);
    Route::post("/parks", [ParkController::class, "createPark"]);
});
