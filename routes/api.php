<?php
use App\Http\Controllers\Api\PeminjamanApiController;
use App\Http\Controllers\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingRuanganApiController;
use App\Http\Controllers\Api\AlatController;
use App\Http\Controllers\Api\RuanganApiController;
Route::post('login', [AuthController::class,'login']);
Route::post('register', [AuthController::class,'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('peminjaman', [PeminjamanApiController::class, 'index']);
    Route::post('peminjaman', [PeminjamanApiController::class, 'store']);
    Route::get('peminjaman/{id}', [PeminjamanApiController::class, 'show']);

    Route::get('alat', function () {return \App\Models\Alat::all();});
    Route::get('/alat', [AlatController::class, 'index']);
    Route::get('/alat/{id}', [AlatController::class, 'show']);

    Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);
    Route::post('notifications/read-all', [NotificationController::class, 'markAllNotificationsAsRead']);
    Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount']);

    Route::get('notifications', [NotificationController::class, 'index']);

    Route::post('notifications/read', [NotificationController::class, 'markAsRead']);

    Route::post('notifications/read-all', [NotificationController::class, 'markAllNotificationsAsRead']);

    // 🔥 TAMBAHKAN INI
    Route::get('user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::get('ruangan', [RuanganApiController::class, 'index']);

    Route::get('booking-ruangan', [BookingRuanganApiController::class, 'index']);
    Route::post('booking-ruangan', [BookingRuanganApiController::class, 'store']);
    Route::get('booking-ruangan/riwayat', [BookingRuanganApiController::class, 'riwayat']);
    Route::get('booking-ruangan/{id}', [BookingRuanganApiController::class, 'show']);
    Route::put('booking-ruangan/{id}', [BookingRuanganApiController::class, 'update']);
    Route::delete('booking-ruangan/{id}', [BookingRuanganApiController::class, 'destroy']);

});