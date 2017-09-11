<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class admin
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
        if(Auth::check() && Auth::User()->isAdmin())  //check if user is authenticated && usr is admin
        {
            return $next($request);    
        }
        return redirect('home');  //or login becoz login will take u to home

    }
}
