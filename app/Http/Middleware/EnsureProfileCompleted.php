<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Jika user adalah pelanggan dan belum mengisi nomor telepon
        if ($user && $user->role === 'pelanggan' && empty($user->phone)) {
            // Kecuali jika sedang di halaman profil atau proses update profil
            if (!$request->routeIs('pelanggan.profil') && !$request->routeIs('pelanggan.profil.update')) {
                return redirect()->route('pelanggan.profil')
                    ->with('warning', 'Harap lengkapi nomor telepon Anda terlebih dahulu agar dapat melakukan transaksi.');
            }
        }

        return $next($request);
    }
}
