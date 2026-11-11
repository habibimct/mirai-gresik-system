<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return response()
            ->view('auth.login')
            ->header(
                'Cache-Control',
                'no-store, no-cache, must-revalidate, max-age=0'
            )
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = $request->user();
        // User dengan role AdminLTE 
        if ($user->hasAnyRole([
            'Super Admin',
            'Admin',
            'Staff Administrasi',
            'Instruktur',
        ])) {
            return redirect()->route('dashboard');
        }
        // User dengan role Pengurus 
        if ($user->hasRole('Pengurus')) {
            return redirect()->route('pengurus.dashboard');
        }
        // User dengan role Peserta 
        if ($user->hasRole('Peserta')) {
            return redirect()->route('participant.dashboard');
        }
        // User belum memiliki role 
        return redirect()->route('no-role');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
