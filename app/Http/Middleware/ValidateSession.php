<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ValidateSession
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
        $path = request()->getPathInfo();
        
        // dd($path);
        // dd(Auth::user());
        return $next($request);
    }
}
