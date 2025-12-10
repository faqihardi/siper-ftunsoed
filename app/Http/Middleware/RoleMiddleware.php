<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. If not login
        if (!Auth::check()) {
            return redirect()->route('show.login')->with('error', 'Silakan login terlebih dahulu,');
        }

        // 2. Get user with role relation
        $user = Auth::user();
        
        // 3. Check if role relation exists
        if (!$user->role) {
            Auth::logout();
            return redirect()->route('show.login')->with('error', 'Role pengguna tidak ditemukan. Silakan hubungi administrator.');
        }

        $userRole = $user->role->nama_role;

        // 4. Check listed role
        if (!in_array($userRole, $roles)) {
            return abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
