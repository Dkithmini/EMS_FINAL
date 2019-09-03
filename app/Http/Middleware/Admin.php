<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }
   
        return redirect('/admin');

    }

    public function handle($request, Closure $next)
    {

        if ( Auth::check() && Auth::user()->role == 'supervisor' )
        {
            return $next($request);
        }

    return redirect('/supervisor');

    }

    public function handle($request, Closure $next)
    {

        if ( Auth::check() && Auth::user()->role == 'manager' )
        {
            return $next($request);
        }

    return redirect('/manager');

    }
    
}
