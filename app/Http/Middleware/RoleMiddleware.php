<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if (!$user || !in_array(strtolower($user->peran), array_map('strtolower', $roles))) {
            abort(403, "Akses ditolak!");
        }

        return $next($request);
    }
}