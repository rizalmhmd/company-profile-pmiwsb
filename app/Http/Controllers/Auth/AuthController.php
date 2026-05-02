<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    /**
     * Show admin login form
     */
    public function showAdminLogin(): Response
    {
        return Inertia::render('Auth/LoginAdmin');
    }

    /**
     * Show perawat login form
     */
    public function showPerawatLogin(): Response
    {
        return Inertia::render('Auth/LoginPerawat');
    }

    /**
     * Handle admin login
     */
    public function storeAdminLogin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Check if user is admin
            if ($user->isAdmin()) {
                return redirect()->intended(route('dashboard.admin'));
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'Akun ini bukan admin. Silakan gunakan akun admin yang tepat.');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    /**
     * Handle perawat login
     */
    public function storePerawatLogin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Check if user is perawat
            if ($user->isPerawat()) {
                return redirect()->intended(route('dashboard.perawat'));
            } else {
                Auth::logout();
                return redirect()->back()->with('error', 'Akun ini bukan perawat. Silakan gunakan akun perawat yang tepat.');
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
