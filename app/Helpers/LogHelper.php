<?php

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

if (! function_exists('catatLog')) {
    function catatLog($aksi, $deskripsi = null)
    {
        if (!Auth::check()) {
            return;
        }

        LogAktivitas::create([
            'user_id'    => Auth::id(),
            'aksi'       => $aksi,
            'deskripsi'  => $deskripsi,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
