<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;
class AdminCheck
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
        // if(Auth::check())
        // {
        //     if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('user'))
        //     {
        //         return $next($request);
        //     }
        // }
        // return redirect()->route('login');
        return $next($request);
    }
}
