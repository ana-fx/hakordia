<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        Log::info('Login page accessed', [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'session_id' => session()->getId(),
        ]);

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        Log::info('Login attempt started', [
            'email' => $request->email,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'session_id' => $request->session()->getId(),
            'has_csrf_token' => $request->has('_token'),
            'csrf_token_match' => $request->session()->token() === $request->input('_token'),
        ]);

        try {
        $request->authenticate();

        $request->session()->regenerate();

            Log::info('Login successful', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'user_id' => Auth::id(),
                'new_session_id' => $request->session()->getId(),
            ]);

        return redirect()->intended(route('dashboard', absolute: false));
        } catch (\Exception $e) {
            Log::error('Login failed', [
                'email' => $request->email,
                'ip' => $request->ip(),
                'error' => $e->getMessage(),
                'error_class' => get_class($e),
            ]);

            throw $e;
        }
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
