<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingRuanganApiController;
Route::post('login', [AuthController::class,'login']);
Route::post('register', [AuthController::class,'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('booking-ruangan', [BookingRuanganApiController::class, 'index']);
    Route::post('booking-ruangan', [BookingRuanganApiController::class, 'store']);
    Route::get('booking-ruangan/riwayat', [BookingRuanganApiController::class, 'riwayat']);
    Route::get('booking-ruangan/{id}', [BookingRuanganApiController::class, 'show']);
    Route::put('booking-ruangan/{id}', [BookingRuanganApiController::class, 'update']);
    Route::delete('booking-ruangan/{id}', [BookingRuanganApiController::class, 'destroy']);

});
