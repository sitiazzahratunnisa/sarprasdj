<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // Cek login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Cek role user (sesuai database)
        if (Auth::user()->role !== $role) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return $next($request);
    }
}