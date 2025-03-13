<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ParkController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/register", [AuthController::class, "createUser"]);
Route::post("/login", [AuthController::class, "loginUser"]);

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/parks/statistiques", [ParkController::class, "statistiques"]);
    Route::get("/parks/search", [ParkController::class, "searchByName"]);
    Route::get("/parks", [ParkController::class, "allParks"]);
    Route::get("/parks/{id}", [ParkController::class, "getById"]);
    Route::post("/parks", [ParkController::class, "createPark"]);
    Route::delete("/parks/{id}/delete", [ParkController::class, "deletePark"]);
    Route::put("/parks/{id}", [ParkController::class, "update"]);

    Route::get("/reservations", [ReservationController::class, "getAll"]);
    Route::post("/reservations", [ReservationController::class, "create"]);
    Route::put("/reservations/{id}", [ReservationController::class, "update"]);
    Route::get("/reservations/user/{id}", [ReservationController::class, "getReservationById"]);
});
