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
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! Auth::check()) {
            return redirect()->route('show.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        
        // Eager load role jika belum di-load
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        $userRole = $user->role->nama_role;

        if ($userRole !== $role) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}