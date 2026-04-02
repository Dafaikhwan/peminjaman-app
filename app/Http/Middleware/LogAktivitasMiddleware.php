<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogAktivitasMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!auth()->check()) {
            return $response;
        }

        // Abaikan halaman log sendiri
        if ($request->is('admin/log-aktivitas*')) {
            return $response;
        }

        $aksi = match ($request->method()) {
            'POST' => 'tambah',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'hapus',
            default => 'akses',
        };

        $aktivitas = strtoupper($aksi) . ' → ' . $request->path();

        catatLog($aksi, $aktivitas);

        return $response;
    }
}
