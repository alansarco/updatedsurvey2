<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->email === 'admin@gmail.com') {
            
            if ($request->is('dashboard')) {
                return redirect()->route('admin.dashboard');
            }

            // Handle browser back button by checking referrer
            if ($request->headers->get('referer')) {
                $previousUrl = parse_url($request->headers->get('referer'), PHP_URL_PATH);
                if ($previousUrl === '/dashboard') {
                    return redirect()->route('admin.dashboard');
                }
            }

            return $next($request);
        }

        
        if ($request->is('admin*')) {
            return redirect()->route('dashboard')
                ->with('error', 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}
