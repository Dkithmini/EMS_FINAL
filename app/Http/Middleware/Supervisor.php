<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Supervisor
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
        if (Auth::check() && Auth::user()->role == 'supervisor') {
        return $next($request);
    }
    elseif (Auth::check() && Auth::user()->role == 'manager') {
        return redirect('/manager');
    }
    else {
        return redirect('/admin');
    }
    }
}
