<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated. Please login first.'
                ], 401);
            }
            
            return redirect()->route('login')
                           ->with('error', 'You must be logged in to access the admin panel.');
        }
        
        // Check if user has admin role
        $user = Auth::user();
        if (!$user->hasAdminAccess()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Admin privileges required.'
                ], 403);
            }
            
            // If user is customer, redirect to customer dashboard
            if ($user->isCustomer()) {
                return redirect()->route('customer.dashboard')
                               ->with('error', 'You do not have permission to access the admin panel.');
            }
            
            // For users without a proper role, redirect to home
            return redirect()->route('home')
                           ->with('error', 'Access denied. Admin privileges required.');
        }
        
        return $next($request);
    }
}
