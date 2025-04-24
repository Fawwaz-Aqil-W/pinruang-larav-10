<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                           ->with('error', 'Please login first.');
        }

        if (!auth()->user()->is_admin) {
            return redirect()->route('home')
                           ->with('error', 'Unauthorized access. Admin only.');
        }

        return $next($request);
    }
}