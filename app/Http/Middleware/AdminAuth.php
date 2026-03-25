<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Memeriksa apakah session admin_logged_in bernilai true
        if (!session('admin_logged_in')) {
            // Jika tidak ada session login, arahkan kembali ke halaman login dengan pesan error
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu untuk mengakses dashboard.');
        }

        return $next($request);
    }
}