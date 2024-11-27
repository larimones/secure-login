<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                return $next($request);
            } else {
                return redirect('/welcome')->with('error', 'Você não tem permissão para acessar esta página.');
            }
        }

        return redirect('/login')->with('error', 'Por favor, faça login para acessar esta página.');
    }
}