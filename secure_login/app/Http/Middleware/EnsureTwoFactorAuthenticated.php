<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureTwoFactorAuthenticated
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->two_factor_token && $user->two_factor_expires_at->isFuture()) {
            return redirect()->route('verify-2fa-form');
        }

        return $next($request);
    }
}
