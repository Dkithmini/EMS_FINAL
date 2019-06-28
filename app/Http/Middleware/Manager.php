<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Manager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'manager') {
        return $next($request);
    }
    elseif (Auth::check() && Auth::user()->role == 'supervisor') {
        return redirect('/supervisor');
    }
    else {
        return redirect('/admin');
    }
    }
}
