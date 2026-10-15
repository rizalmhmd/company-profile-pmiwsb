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
    public function showPerawatLogin(): RedirectResponse
    {
        return redirect()->route('login.admin');
    }

    /**
     * Handle login for Admin & Perawat
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
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Redirect to appropriate dashboard based on user role
            if ($user->isPerawat()) {
                return redirect()->intended(route('dashboard.perawat'));
            }

            return redirect()->intended(route('dashboard.admin'));
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    /**
     * Handle perawat login
     */
    public function storePerawatLogin(Request $request): RedirectResponse
    {
        return $this->storeAdminLogin($request);
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
