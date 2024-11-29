<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class RouteAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() && $request->bearerToken()) {
            if(!Str::contains($request->url(), 'auth')){
                $accessToken = PersonalAccessToken::findToken($request->bearerToken());
                if ($accessToken) {
                    $user = $accessToken->tokenable;
                    auth()->login($user);
                }
            }
        }
        return $next($request);
    }
}
