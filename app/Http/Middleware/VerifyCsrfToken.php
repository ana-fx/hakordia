<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Log;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        $token = $request->input('_token') ?: $request->header('X-CSRF-TOKEN');
        $sessionToken = $request->hasSession() ? $request->session()->token() : null;

        $isLogin = $request->is('login') || $request->path() === 'login' || str_contains($request->path(), 'login');

        // Log token validation for login requests
        if ($isLogin) {
            Log::info('CSRF Token Validation Check', [
                'url' => $request->fullUrl(),
                'path' => $request->path(),
                'has_session' => $request->hasSession(),
                'session_id' => $request->hasSession() ? $request->session()->getId() : 'NO_SESSION',
                'token_from_request' => $token ? substr($token, 0, 20) . '...' : 'NULL',
                'token_from_session' => $sessionToken ? substr($sessionToken, 0, 20) . '...' : 'NULL',
                'tokens_match' => $token && $sessionToken ? hash_equals($sessionToken, $token) : false,
                'has_token_in_request' => !empty($token),
                'has_session_token' => !empty($sessionToken),
                'cookies' => array_keys($request->cookies->all()),
            ]);
        }

        return parent::tokensMatch($request);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        // Log ALL POST requests for debugging
        if ($request->isMethod('POST')) {
            $isLoginRoute = $request->is('login') || $request->path() === 'login' || str_contains($request->path(), 'login');

            // Log all POST requests to see if they reach middleware
            Log::info('CSRF Middleware: POST request received', [
                'url' => $request->fullUrl(),
                'path' => $request->path(),
                'is_login' => $isLoginRoute,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'has_session' => $request->hasSession(),
                'session_id' => $request->hasSession() ? $request->session()->getId() : 'NO_SESSION',
                'has_token' => $request->has('_token'),
                'token_from_request' => $request->input('_token'),
                'token_from_session' => $request->hasSession() ? $request->session()->token() : 'NO_SESSION',
                'cookies' => $request->cookies->all(),
                'referer' => $request->header('referer'),
                'app_key_set' => !empty(config('app.key')),
                'app_key_preview' => config('app.key') ? substr(config('app.key'), 0, 20) . '...' : 'NOT SET',
                'session_config' => [
                    'driver' => config('session.driver'),
                    'secure' => config('session.secure'),
                    'domain' => config('session.domain'),
                    'same_site' => config('session.same_site'),
                    'cookie_name' => config('session.cookie'),
                ],
                'storage_writable' => is_writable(storage_path()),
                'session_storage_writable' => is_writable(storage_path('framework/sessions')),
            ]);
        }

        try {
            return parent::handle($request, $next);
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            Log::error('CSRF Token Mismatch - 419 Error', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'session_id' => $request->hasSession() ? $request->session()->getId() : 'NO_SESSION',
                'has_session' => $request->hasSession(),
                'token_from_request' => $request->input('_token'),
                'token_from_session' => $request->hasSession() ? $request->session()->token() : 'NO_SESSION',
                'token_match' => $request->hasSession() && $request->has('_token')
                    ? ($request->session()->token() === $request->input('_token'))
                    : false,
                'referer' => $request->header('referer'),
                'cookies' => $request->cookies->all(),
                'session_config' => [
                    'driver' => config('session.driver'),
                    'secure' => config('session.secure'),
                    'domain' => config('session.domain'),
                    'same_site' => config('session.same_site'),
                ],
            ]);

            throw $e;
        }
    }
}

