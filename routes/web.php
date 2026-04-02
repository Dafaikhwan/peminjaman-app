<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\NotificationController;

// === Controller Admin ===
use App\Http\Controllers\Admin\AlatController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\LaporanKerusakanController as AdminLaporanController;
use App\Http\Controllers\Admin\LaporanKerusakanExportController;
use App\Http\Controllers\Admin\LaporanPeminjamanController;
use App\Http\Controllers\Admin\BookingRuanganController;

// === Controller User ===
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\PeminjamanController as UserPeminjamanController;
use App\Http\Controllers\User\LaporanKerusakanController as UserLaporanController;

// === Controller Teknisi ===
use App\Http\Controllers\Teknisi\LaporanKerusakanController as TeknisiLaporanController;


// =================== AUTH ===================
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// =================== LANDING PAGE ===================
Route::get('/', function () { 
    $totalAlat = \App\Models\Alat::count() ?? 0;
    $peminjamanPerBulan = \App\Models\Peminjaman::whereMonth('created_at', now()->month)->count() ?? 0;
    $kepuasan = 95;
    return view('landing', compact('totalAlat','peminjamanPerBulan','kepuasan'));
})->name('home');


// =================== ADMIN ===================
Route::middleware([RoleMiddleware::class.':admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('alat', AlatController::class);
    Route::resource('ruangan', RuanganController::class);
    Route::resource('pengguna', PenggunaController::class);
    Route::resource('peminjaman', AdminPeminjamanController::class);
    Route::resource('laporan', AdminLaporanController::class);

    Route::post('peminjaman/{peminjaman}/status', [AdminPeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
    Route::get('peminjaman/export/pdf', [AdminPeminjamanController::class, 'exportPdf'])->name('peminjaman.exportPdf');

    Route::get('laporan-peminjaman', [LaporanPeminjamanController::class, 'index'])->name('laporan.peminjaman');
    Route::get('laporan-peminjaman/export-pdf', [LaporanPeminjamanController::class, 'exportPdf'])->name('laporan.peminjaman.pdf');
    Route::get('laporan-peminjaman/export-excel', [LaporanPeminjamanController::class, 'exportExcel'])->name('laporan.peminjaman.excel');

    Route::get('laporan-kerusakan', [LaporanKerusakanExportController::class, 'index'])->name('laporan-kerusakan.index');
    Route::get('laporan-kerusakan/export-pdf', [LaporanKerusakanExportController::class, 'exportPdf'])->name('laporan-kerusakan.exportPdf');
    Route::get('laporan-kerusakan/export-excel', [LaporanKerusakanExportController::class, 'exportExcel'])->name('laporan-kerusakan.exportExcel');
    Route::post('laporan/{laporan}/update-status', [AdminLaporanController::class, 'updateStatus'])->name('laporan.updateStatus');

    Route::get('log-aktivitas', [App\Http\Controllers\LogAktivitasController::class, 'index'])->name('log');
    // Chart data untuk Chart.js (letakkan di dalam grup admin yang sudah ada)
Route::get('laporan-peminjaman/chart', [App\Http\Controllers\Admin\LaporanPeminjamanController::class, 'chart'])
    ->name('laporan.peminjaman.chart');

// (opsional) Export CSV
Route::get('laporan-peminjaman/export-csv', [App\Http\Controllers\Admin\LaporanPeminjamanController::class, 'exportCsv'])
    ->name('laporan.peminjaman.csv');

    // Chart data untuk Chart.js
Route::get('laporan-kerusakan/chart', [LaporanKerusakanExportController::class, 'chart'])->name('laporan-kerusakan.chart');

// Export CSV
Route::get('laporan-kerusakan/export-csv', [LaporanKerusakanExportController::class, 'exportCsv'])->name('laporan-kerusakan.exportCsv');

Route::get('peminjaman/ruangan/create', 
    [AdminPeminjamanController::class,'createRuangan']
)->name('peminjaman.create.ruangan');

Route::post('peminjaman/ruangan', 
    [AdminPeminjamanController::class,'storeRuangan']
)->name('peminjaman.store.ruangan');

Route::resource('booking-ruangan', BookingRuanganController::class);


});


// =================== TEKNISI ===================
Route::middleware([RoleMiddleware::class.':teknisi'])
    ->prefix('teknisi')->name('teknisi.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboardTeknisi'])->name('dashboard');
        Route::resource('laporan', TeknisiLaporanController::class)->only(['index','show','edit','update']);
        Route::post('laporan/{laporan}/update-status', [TeknisiLaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
});



// =================== USER ===================
Route::middleware([RoleMiddleware::class.':user'])
    ->prefix('user')->name('user.')
    ->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    Route::get('peminjaman/riwayat', [UserPeminjamanController::class, 'riwayat'])->name('peminjaman.riwayat');

    Route::resource('peminjaman', UserPeminjamanController::class)->except(['destroy']);
    Route::post('/peminjaman/{peminjaman}/batal', [UserPeminjamanController::class, 'batal'])->name('peminjaman.batal');

    Route::resource('laporan', UserLaporanController::class)->except(['destroy']);
    Route::put('/laporan/{laporan}/batal', [UserLaporanController::class, 'batal'])->name('laporan.batal');

    Route::post('/notifications/mark-all-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    })->name('notifications.markAllRead');

    Route::resource('booking-ruangan', \App\Http\Controllers\User\BookingRuanganController::class);

Route::post('booking-ruangan/{booking}/batal',
    [\App\Http\Controllers\User\BookingRuanganController::class,'batal']
)->name('booking-ruangan.batal');

Route::get('booking-ruangan-riwayat',
    [\App\Http\Controllers\User\BookingRuanganController::class,'riwayat']
)->name('booking-ruangan.riwayat');

});


// =================== KALENDER ===================
Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender.index');
Route::get('/kalender/data', [KalenderController::class, 'getData'])->name('kalender.data');
Route::post('/kalender/update-tanggal', [KalenderController::class, 'updateTanggal'])->name('kalender.update');


// =================== QR CODE ===================
Route::get('/peminjaman/detail/{id}', function($id) {
    $data = \App\Models\Peminjaman::findOrFail($id);
    return view('qr.detail', compact('data'));
})->name('peminjaman.detail');

Route::get('/peminjaman/{id}/qr', [App\Http\Controllers\QRCodeController::class, 'show'])->name('peminjaman.qr');


// =================== NOTIFIKASI GLOBAL (VERSI BENAR – non duplikat) ===================
Route::middleware('auth')->group(function () {

    Route::get('notifications/mark-as-read/{id}', 
        [NotificationController::class, 'markNotificationAsRead']
    )->name('notifications.read.one');

    Route::get('notifications/mark-all-read', 
        [NotificationController::class, 'markAllNotificationsAsRead']
    )->name('notifications.read.all');

    Route::post('/notifications/read', function () {
        auth()->user()->notifications()->update(['dibaca' => true]);
        return response()->json(['success' => true]);
    })->name('notifications.read.ajax');
});