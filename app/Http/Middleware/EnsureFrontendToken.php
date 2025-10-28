<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class EnsureFrontendToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validToken = config('app.api_secret');
        if (!$validToken) {
            Log::warning('API_SECRET is not set. Thus token validation is disabled');
            return $next($request);
        }

        $tokenFromRequest = $request->header('Authorization');
        if (!$tokenFromRequest) {
            throw new UnauthorizedHttpException("Bearer error=\"Token are not provided\"");
        }

        $tokenFromRequest = ((array)$tokenFromRequest)[0];
        $extractedToken = trim(str_replace('Bearer', '', $tokenFromRequest));

        if ($extractedToken !== $validToken) {
            throw new UnauthorizedHttpException("Bearer error=\"Token is invalid\"");
        }

        return $next($request);
    }
}
