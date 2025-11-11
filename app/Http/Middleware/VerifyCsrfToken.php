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
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        // Log all POST requests to login route for debugging
        if ($request->is('login') && $request->isMethod('POST')) {
            Log::info('CSRF Middleware: Login POST request received', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'has_session' => $request->hasSession(),
                'session_id' => $request->hasSession() ? $request->session()->getId() : 'NO_SESSION',
                'has_token' => $request->has('_token'),
                'token_from_request' => $request->input('_token'),
                'token_from_session' => $request->hasSession() ? $request->session()->token() : 'NO_SESSION',
                'cookies' => $request->cookies->all(),
                'referer' => $request->header('referer'),
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

