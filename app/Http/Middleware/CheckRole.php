<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Treat legacy 'user' as 'customer'
        if ($userRole === 'user') {
            $userRole = 'customer';
        }

        foreach ($roles as $role) {
            if ($userRole === $role) {
                return $next($request);
            }
        }

        return redirect()->route('dashboard')
            ->with('error', 'Access Denied: You do not have permission to view this page.');
    }
}
