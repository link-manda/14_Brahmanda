<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user sudah login DAN perannya adalah 'admin' atau 'petugas'
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'petugas'])) {
            return $next($request); // Lanjutkan ke halaman yang dituju
        }

        // Jika tidak, tolak akses
        abort(403, 'AKSI TIDAK DIIZINKAN.');
    }
}
