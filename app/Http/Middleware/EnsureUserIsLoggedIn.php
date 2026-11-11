<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLoggedIn
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('user_id')) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Utente non autenticato'], 401);
            }
            return redirect('login');
        }

        return $next($request);
    }
}
