<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class OwnerMiddleware
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
                           ->with('error', 'You must be logged in to access the owner panel.');
        }
        
        // Check if user has owner role
        $user = Auth::user();
        if (!$user->isOwner()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Owner privileges required.'
                ], 403);
            }
            
            // If user is customer, redirect to customer dashboard
            if ($user->isCustomer()) {
                return redirect()->route('customer.dashboard')
                               ->with('error', 'You do not have permission to access the owner panel.');
            }
            
            // If user is admin, redirect to admin dashboard
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')
                               ->with('error', 'You do not have permission to access the owner panel.');
            }
            
            // For users without a proper role, redirect to home
            return redirect()->route('home')
                           ->with('error', 'Access denied. Owner privileges required.');
        }
        
        return $next($request);
    }
}
