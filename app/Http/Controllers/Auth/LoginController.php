<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request for the application.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirect based on user role
            return match($user->role) {
                'customer' => redirect()->route('customer.dashboard')
                    ->with('success', 'Selamat datang kembali, ' . $user->name . '!'),
                'owner' => redirect()->route('owner.dashboard')
                    ->with('success', 'Selamat datang, Owner ' . $user->name . '!'),
                'admin' => redirect('/admin'),
                'studio_staff' => redirect('/staff')
                    ->with('success', 'Login berhasil!'),
                default => redirect()->route('customer.dashboard')
                    ->with('success', 'Login berhasil!')
            };
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
                        ->with('success', 'Anda telah berhasil logout.');
    }
}
