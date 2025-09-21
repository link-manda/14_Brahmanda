<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- MULAI PERUBAHAN ---
        // Tambahkan logika redirect berdasarkan role
        $user = $request->user();

        if (in_array($user->role, ['admin', 'petugas'])) {
            // Jika user adalah admin atau petugas, arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika tidak, arahkan ke dashboard masyarakat (default)
        return redirect()->intended(route('dashboard'));
        // --- AKHIR PERUBAHAN ---
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
