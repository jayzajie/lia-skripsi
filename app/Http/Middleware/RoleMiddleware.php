<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $user = $request->user();
        $currentRoute = $request->route()->getName();

        if (!$user->hasRole($role)) {
            // Jangan redirect jika sudah di dashboard yang sesuai untuk menghindari loop
            if ($user->hasRole('superadmin') && $currentRoute !== 'superadmin.dashboard') {
                return redirect()->route('superadmin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            } elseif ($user->hasRole('admin') && $currentRoute !== 'admin.dashboard') {
                return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            } elseif ($user->hasRole('user') && $currentRoute !== 'dashboard') {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            } else {
                // Jika sudah di dashboard yang sesuai, tampilkan 403
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        return $next($request);
    }
}
