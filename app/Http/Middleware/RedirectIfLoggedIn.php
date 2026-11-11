<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfLoggedIn
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->has('user_id')) {
            return redirect('home');
        }

        return $next($request);
    }
}
